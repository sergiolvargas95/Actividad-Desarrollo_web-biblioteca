<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// ── Guardia de seguridad: bloquear acceso directo a archivos/carpetas ──────────
// El .htaccess redirige internamente cualquier URL que no sea public/ hacia aquí.
// Detectamos ese caso comparando la URL solicitada con la ruta pública esperada.

(function (): void {
    $requestPath = rtrim(
        (string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH), 
        '/'
    );
    // dirname de /crud-usuarios/public/index.php → /crud-usuarios/public
    $publicBase = rtrim(dirname((string) ($_SERVER['SCRIPT_NAME'] ?? '/index.php')), '/');

    // Si la URL pedida no comienza con /…/public/, fue un acceso directo indebido.
    if ($requestPath !== $publicBase && !str_starts_with($requestPath, $publicBase . '/')) {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $dest = isset($_SESSION['auth']['id']) ? 'home' : 'auth.login';
        header('Location: ' . $publicBase . '/index.php?route=' . $dest);
        exit;
    } })();
    // ──────────────────────────────────────────────────────────────────────────────
    require_once __DIR__ . '/../Common/ClassLoader.php';
    require_once __DIR__ . '/../Common/DependencyInjection.php';
    require_once __DIR__ . '/../web/Presentation/View.php';
    require_once __DIR__ . '/../web/Presentation/Flash.php';
    require_once __DIR__ . '/../web/Controllers/config/WebRoutes.php';

    DependencyInjection::boot(); Flash::start();

    // ──────────────────────────────────────────────────────────────
    // Auth helpers
    // ──────────────────────────────────────────────────────────────

    function isLoggedIn(): bool {
        return isset($_SESSION['auth']['id']);
    }

    function requireAuth(): void {
        if (!isLoggedIn()) {
            Flash::setMessage('Debes iniciar sesión para acceder a esta sección.'); View::redirect('auth.login');
        }
    }

    function getLoggedUser(): array {
        return is_array($_SESSION['auth'] ?? null) ? $_SESSION['auth'] : array();
    }

    // ──────────────────────────────────────────────────────────────
    // Routing
    // ──────────────────────────────────────────────────────────────

    $route = isset($_GET['route']) ? trim((string) $_GET['route']) : 'home';
    $routes = WebRoutes::routes();

    if (!isset($routes[$route])) {
        http_response_code(404);
        View::render('home', buildHomeViewData('Ruta no encontrada.'));
        exit;
    }

    $definition = $routes[$route];
    $httpMethod = strtoupper((string) $_SERVER['REQUEST_METHOD']);

    if ($httpMethod !== $definition['method']) {
        http_response_code(405);
        View::render('home', buildHomeViewData('Método HTTP no permitido.'));
        exit;
    }

    // Protect all user management routes behind authentication.
    $publicActions = array('home', 'login', 'authenticate', 'logout', 'forgot', 'forgot.send', 'create', 'store');
    if (!in_array($definition['action'], $publicActions, true) && !isLoggedIn()) {
        Flash::setMessage('Debes iniciar sesión para acceder a esta sección.');
        View::redirect('auth.login');
    }

    try {
        switch ($definition['action']) {
            // ── Home ──────────────────────────────────────────────
            case 'home':
                View::render('home', buildHomeViewData());
                break;
            // ── Create / Store ────────────────────────────────────
            case 'create':
                View::render('users/create', buildCreateUserViewData());
                break;
            case 'store':
                $controller = DependencyInjection::getUserController();
                $form = getCreateUserFormData();
                $form['id'] = generateUuid4();
                $errors = validateCreateUserForm($form);

                if (!empty($errors)) {
                    Flash::setOld($form);
                    Flash::setErrors($errors);
                    Flash::setMessage('Corrige los errores del formulario.');
                    View::redirect('users.create');
                }

                $request = new CreateUserWebRequest(
                    $form['id'],
                    $form['name'],
                    $form['email'],
                    $form['password'],
                    $form['role']
                );

                $controller->store($request);
                Flash::setSuccess('Usuario registrado correctamente.');
                View::redirect('users.index');
                break;

                // ── Index ─────────────────────────────────────────────
                case 'index':
                    $controller = DependencyInjection::getUserController();
                    $users = $controller->index();
                    View::render('users/list', buildListUsersViewData($users));
                    break;
                // ── Show ──────────────────────────────────────────────
                case 'show':
                    $controller = DependencyInjection::getUserController();
                    $id = isset($_GET['id']) ? trim((string) $_GET['id']) : '';
                    $user = $controller->show($id);
                    View::render('users/show', array(
                        'pageTitle' => 'Detalle de usuario',
                        'user' => $user,
                        'message' => Flash::message(),
                    ));
                    break;
                // ── Edit ──────────────────────────────────────────────
                case 'edit':
                    $controller = DependencyInjection::getUserController();
                    $id = isset($_GET['id']) ? trim((string) $_GET['id']) : '';
                    $user = $controller->show($id);
                    View::render('users/edit', buildEditUserViewData($user));
                    break;
                // ── Update ────────────────────────────────────────────
                case 'update':
                    $controller = DependencyInjection::getUserController();
                    $form = getUpdateUserFormData();
                    $errors = validateUpdateUserForm($form);

                    if (!empty($errors)) {
                        Flash::setOld($form);
                        Flash::setErrors($errors);
                        Flash::setMessage('Corrige los errores del formulario.');
                        header('Location: ?route=users.edit&id=' . urlencode($form['id']));
                        exit;
                    }

                    $request = new UpdateUserWebRequest(
                        $form['id'],
                        $form['name'],$form['email'],
                        $form['password'],
                        $form['role'],
                        $form['status']
                    );

                    $controller->update($request);
                    Flash::setSuccess('Usuario actualizado correctamente.');
                    View::redirect('users.index');
                    break;
                    // ── Delete ────────────────────────────────────────────
                    case 'delete':
                        $controller = DependencyInjection::getUserController();
                        $id = isset($_POST['id']) ? trim((string) $_POST['id']) : '';
                        $controller->delete($id);
                        Flash::setSuccess('Usuario eliminado correctamente.');
                        View::redirect('users.index');
                        break;
                    // ── Login ─────────────────────────────────────────────
                    case 'login':
                        if (isLoggedIn()) {
                            View::redirect('home');
                        }

                        View::render('auth/login', array(
                            'pageTitle' => 'Iniciar sesión',
                            'message' => Flash::message(),
                            'errors' => Flash::errors(),
                            'old' => Flash::old(),
                        ));
                        break;
                        // ── Authenticate ──────────────────────────────────────
                        case 'authenticate':
                            $email = trim(strtolower((string) ($_POST['email'] ?? '')));
                            $password = (string) ($_POST['password'] ?? '');
                            $authErrors = array();
                            if ($email === '') {
                                $authErrors['email'] = 'El correo es obligatorio.';
                            }

                            if ($password === '') {
                                $authErrors['password'] = 'La contraseña es obligatoria.';
                            }

                            if (!empty($authErrors)) {
                                Flash::setErrors($authErrors);
                                Flash::setOld(array('email' => $email));
                                View::redirect('auth.login');
                            }

                            $loginUseCase = DependencyInjection::getLoginUseCase();
                            $command = new LoginCommand($email, $password);
                            $user = $loginUseCase->execute($command);
                            $_SESSION['auth'] = array(
                                'id' => $user->id()->value(),
                                'name' => $user->name()->value(),
                                'email' => $user->email()->value(),
                                'role' => $user->role(),
                            );

                            Flash::setSuccess('Bienvenido/a, ' . $user->name()->value() . '.');
                            View::redirect('home');
                            break;

                            // ── Logout ────────────────────────────────────────────
                            case 'logout':
                                session_destroy();
                                header('Location: ?route=auth.login');
                                exit;

                            // ── Forgot password (form) ────────────────────────────
                            case 'forgot':
                                View::render('auth/forgot-password', array(
                                    'pageTitle' => 'Recuperar contraseña',
                                    'message' => Flash::message(),
                                    'success' => Flash::success(),
                                    'errors' => Flash::errors(),
                                    'old' => Flash::old(),
                                ));
                                break;
                            // ── Forgot password (send) ────────────────────────────
                            case 'forgot.send':
                                $forgotEmail = trim(strtolower((string) ($_POST['email'] ?? '')));
                                if ($forgotEmail === '' || !filter_var($forgotEmail, FILTER_VALIDATE_EMAIL)) {
                                    Flash::setErrors(array('email' => 'Introduce un correo electrónico válido.'));
                                    Flash::setOld(array('email' => $forgotEmail));
                                    View::redirect('auth.forgot');
                                }

                                $forgotUseCase = DependencyInjection::getForgotPasswordUseCase();
                                $forgotResult  = $forgotUseCase->execute(new ForgotPasswordCommand($forgotEmail));

                                // Always show generic success to avoid user enumeration.
                                if ($forgotResult !== null) {
                                    sendPasswordRecoveryEmail(
                                        $forgotResult['email'],
                                        $forgotResult['name'],
                                        $forgotResult['tempPassword']
                                    );
                                }

                                Flash::setSuccess(
                                    'Si el correo está registrado y la cuenta está activa, ' .
                                    'recibirás un mensaje con tu contraseña temporal.'
                                );

                                View::redirect('auth.forgot');
                                break;
                            // ── Bibliotecas: Index ────────────────────────────────
                            case 'bibliotecas.index':
                                $controller  = DependencyInjection::getBibliotecaController();
                                $bibliotecas = $controller->index();
                                View::render('bibliotecas/list', array(
                                    'pageTitle'   => 'Lista de bibliotecas',
                                    'bibliotecas' => $bibliotecas,
                                    'message'     => Flash::message(),
                                    'success'     => Flash::success(),
                                ));
                                break;

                            // ── Bibliotecas: Create ───────────────────────────────
                            case 'bibliotecas.create':
                                View::render('bibliotecas/create', array(
                                    'pageTitle' => 'Registrar biblioteca',
                                    'message'   => Flash::message(),
                                    'success'   => Flash::success(),
                                    'errors'    => Flash::errors(),
                                    'old'       => Flash::old(),
                                ));
                                break;

                            // ── Bibliotecas: Store ────────────────────────────────
                            case 'bibliotecas.store':
                                $controller = DependencyInjection::getBibliotecaController();
                                $form       = getBibliotecaCreateFormData();
                                $form['id'] = generateUuid4();
                                $errors     = validateBibliotecaCreateForm($form);

                                if (!empty($errors)) {
                                    Flash::setOld($form);
                                    Flash::setErrors($errors);
                                    Flash::setMessage('Corrige los errores del formulario.');
                                    View::redirect('bibliotecas.create');
                                }

                                $request = new CreateBibliotecaWebRequest(
                                    $form['id'],
                                    $form['nombre'],
                                    $form['direccion'],
                                    $form['ciudad'],
                                    $form['pais'],
                                    $form['telefono'],
                                    $form['email'],
                                    $form['horario_apertura'],
                                    $form['horario_cierre'],
                                    (int) $form['num_libros'],
                                    (int) $form['num_usuarios'],
                                    (bool) $form['es_publica'],
                                    $form['web']
                                );

                                $controller->store($request);
                                Flash::setSuccess('Biblioteca registrada correctamente.');
                                View::redirect('bibliotecas.index');
                                break;

                            // ── Bibliotecas: Show ─────────────────────────────────
                            case 'bibliotecas.show':
                                $controller = DependencyInjection::getBibliotecaController();
                                $id         = isset($_GET['id']) ? trim((string) $_GET['id']) : '';
                                $biblioteca = $controller->show($id);
                                View::render('bibliotecas/show', array(
                                    'pageTitle'   => 'Detalle de biblioteca',
                                    'biblioteca'  => $biblioteca,
                                    'message'     => Flash::message(),
                                ));
                                break;

                            // ── Bibliotecas: Edit ─────────────────────────────────
                            case 'bibliotecas.edit':
                                $controller = DependencyInjection::getBibliotecaController();
                                $id         = isset($_GET['id']) ? trim((string) $_GET['id']) : '';
                                $biblioteca = $controller->show($id);
                                View::render('bibliotecas/edit', array(
                                    'pageTitle'   => 'Editar biblioteca',
                                    'biblioteca'  => $biblioteca,
                                    'message'     => Flash::message(),
                                    'errors'      => Flash::errors(),
                                    'old'         => Flash::old(),
                                ));
                                break;

                            // ── Bibliotecas: Update ───────────────────────────────
                            case 'bibliotecas.update':
                                $controller = DependencyInjection::getBibliotecaController();
                                $form       = getBibliotecaUpdateFormData();
                                $errors     = validateBibliotecaUpdateForm($form);

                                if (!empty($errors)) {
                                    Flash::setOld($form);
                                    Flash::setErrors($errors);
                                    Flash::setMessage('Corrige los errores del formulario.');
                                    header('Location: ?route=bibliotecas.edit&id=' . urlencode($form['id']));
                                    exit;
                                }

                                $request = new UpdateBibliotecaWebRequest(
                                    $form['id'],
                                    $form['nombre'],
                                    $form['direccion'],
                                    $form['ciudad'],
                                    $form['pais'],
                                    $form['telefono'],
                                    $form['email'],
                                    $form['horario_apertura'],
                                    $form['horario_cierre'],
                                    (int) $form['num_libros'],
                                    (int) $form['num_usuarios'],
                                    (bool) $form['es_publica'],
                                    $form['web']
                                );

                                $controller->update($request);
                                Flash::setSuccess('Biblioteca actualizada correctamente.');
                                View::redirect('bibliotecas.index');
                                break;

                            // ── Bibliotecas: Delete ───────────────────────────────
                            case 'bibliotecas.delete':
                                $controller = DependencyInjection::getBibliotecaController();
                                $id         = isset($_POST['id']) ? trim((string) $_POST['id']) : '';
                                $controller->delete($id);
                                Flash::setSuccess('Biblioteca eliminada correctamente.');
                                View::redirect('bibliotecas.index');
                                break;

                            default:
                                throw new RuntimeException('Acción no soportada.');
                        }
                    } catch (Throwable $exception) {
                        $msg = $exception->getMessage();
                        Flash::setMessage($msg);

                        switch ($route) {
                            case 'users.store':
                                Flash::setOld(getCreateUserFormData());
                                View::redirect('users.create');
                                break;
                            case 'users.update':
                                $updateId = trim((string) ($_POST['id'] ?? ''));
                                Flash::setOld(getUpdateUserFormData());
                                header('Location: ?route=users.edit&id=' . urlencode($updateId));
                                exit;
                            case 'auth.authenticate':
                                Flash::setOld(array('email' => trim(strtolower((string) ($_POST['email'] ?? '')))));
                                View::redirect('auth.login');
                                break;
                            case 'auth.forgot.send':
                                Flash::setOld(array('email' => trim((string) ($_POST['email'] ?? ''))));
                                View::redirect('auth.forgot');
                                break;
                            case 'users.show':
                            case 'users.edit':
                                View::redirect('users.index');
                                break;
                            case 'users.delete':
                                Flash::setMessage($msg);
                                View::redirect('users.index');
                                break;
                            case 'bibliotecas.store':
                                Flash::setOld(getBibliotecaCreateFormData());
                                View::redirect('bibliotecas.create');
                                break;
                            case 'bibliotecas.update':
                                $updateBibId = trim((string) ($_POST['id'] ?? ''));
                                Flash::setOld(getBibliotecaUpdateFormData());
                                header('Location: ?route=bibliotecas.edit&id=' . urlencode($updateBibId));
                                exit;
                            case 'bibliotecas.show':
                            case 'bibliotecas.edit':
                                View::redirect('bibliotecas.index');
                                break;
                            case 'bibliotecas.delete':
                                Flash::setMessage($msg);
                                View::redirect('bibliotecas.index');
                                break;
                            default:
                                View::render('home',
                                buildHomeViewData($msg));
                                break;
                        }
                    }

                    // ──────────────────────────────────────────────────────────────
                    // Email helper
                    // ──────────────────────────────────────────────────────────────
                        function sendPasswordRecoveryEmail(string $email, string $name, string $tempPassword): void {
                            $templateFile = __DIR__ . '/../Views/email/forgot-password.php';
                            ob_start();
                            extract(['email' => $email, 'name' => $name, 'tempPassword' => $tempPassword], EXTR_SKIP);
                            require $templateFile;
                            $htmlBody = (string) ob_get_clean();

                            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                            $mail->isSMTP();
                            $mail->Host       = $_ENV['MAIL_HOST'];
                            $mail->SMTPAuth   = true;
                            $mail->Username   = $_ENV['MAIL_USERNAME'];
                            $mail->Password   = $_ENV['MAIL_PASSWORD'];
                            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port       = (int) $_ENV['MAIL_PORT'];
                            $mail->CharSet    = 'UTF-8';

                            $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
                            $mail->addAddress($email, $name);
                            $mail->isHTML(true);
                            $mail->Subject = 'Recuperación de contraseña';
                            $mail->Body    = $htmlBody;

                            $mail->send();
                        }


                        // ──────────────────────────────────────────────────────────────
                        // View-data builders
                        // ──────────────────────────────────────────────────────────────
                        function buildListUsersViewData(array $users): array
                        {
                            return array(
                                'pageTitle' => 'Lista de usuarios',
                                'users' => $users,
                                'message' => Flash::message(),
                                'success' => Flash::success(),
                            );
                        }

                        function buildHomeViewData(string $message = ''): array
                        {
                            return array(
                                'pageTitle' => 'Menú principal',
                                'message' => $message,
                                'success' => Flash::success(),
                            );
                        }

                        function buildCreateUserViewData(): array
                        {
                            return array(
                                'pageTitle' => 'Registrar usuario',
                                'roleOptions' => UserRoleEnum::values(),
                                'message' => Flash::message(),
                                'success' => Flash::success(),
                                'errors' => Flash::errors(),
                                'old' => Flash::old(),
                            );
                        }

                        function buildEditUserViewData(UserResponse $user): array
                        {
                            return array(
                                'pageTitle' => 'Editar usuario',
                                'user' => $user,
                                'roleOptions' => UserRoleEnum::values(),
                                'statusOptions' => UserStatusEnum::values(),
                                'message' => Flash::message(),
                                'errors' => Flash::errors(),
                                'old' => Flash::old(),
                            );
                        }

                        // ──────────────────────────────────────────────────────────────
                        // Helpers
                        // ──────────────────────────────────────────────────────────────
                        function generateUuid4(): string
                        {
                            $data = random_bytes(16);
                            $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
                            $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

                            return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
                        }

                        // ──────────────────────────────────────────────────────────────
                        // Form data accessors
                        // ──────────────────────────────────────────────────────────────
                        function getCreateUserFormData(): array
                        {
                            return array(
                                'name' => isset($_POST['name']) ? trim((string) $_POST['name']) : '',
                                'email' => isset($_POST['email']) ? trim((string) $_POST['email']) : '',
                                'password' => isset($_POST['password']) ? trim((string) $_POST['password']) : '',
                                'role' => isset($_POST['role']) ? trim((string) $_POST['role']) : '',
                            );
                        }

                        function getUpdateUserFormData(): array
                        {
                            return array(
                                'id' => isset($_POST['id']) ? trim((string) $_POST['id']) : '',
                                'name' => isset($_POST['name']) ? trim((string) $_POST['name']) : '',
                                'email' => isset($_POST['email']) ? trim((string) $_POST['email']) : '',
                                'password' => isset($_POST['password']) ? (string) $_POST['password'] : '',
                                'role' => isset($_POST['role']) ? trim((string) $_POST['role']) : '',
                                'status' => isset($_POST['status']) ? trim((string) $_POST['status']) : '',
                            );
                        }

                        // ──────────────────────────────────────────────────────────────
                        // Validators
                        // ──────────────────────────────────────────────────────────────
                        function validateCreateUserForm(array $form): array
                        {
                            $errors = array();
                            if ($form['name'] === '') {
                                $errors['name'] = 'El nombre es obligatorio.';
                            }

                            if ($form['email'] === '') {
                                $errors['email'] = 'El correo es obligatorio.';
                            } elseif (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
                                $errors['email'] = 'El correo no tiene un formato válido.';
                            }

                            if ($form['password'] === '') {
                                $errors['password'] = 'La contraseña es obligatoria.';
                            } elseif (strlen($form['password']) < 8) {
                                $errors['password'] = 'La contraseña debe tener al menos 8 caracteres.';
                            }

                            if ($form['role'] === '') {
                                $errors['role'] = 'El rol es obligatorio.';
                            }

                            return $errors;
                        }

                        function validateUpdateUserForm(array $form): array
                        {
                            $errors = array();
                            if ($form['name'] === '') {
                                $errors['name'] = 'El nombre es obligatorio.';
                            }

                            if ($form['email'] === '') {
                                $errors['email'] = 'El correo es obligatorio.';
                            } elseif (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
                                $errors['email'] = 'El correo no tiene un formato válido.';
                            }

                            // Password is optional on update; validate only if provided.
                            if ($form['password'] !== '' && strlen($form['password']) < 8) {
                                $errors['password'] = 'La contraseña debe tener al menos 8 caracteres si deseas cambiarla.';
                            }

                            if ($form['role'] === '') {
                                $errors['role'] = 'El rol es obligatorio.';
                            }

                            if ($form['status'] === '') {
                                $errors['status'] = 'El estado es obligatorio.';
                            }

                            return $errors;
                        }

                        // ──────────────────────────────────────────────────────────────
                        // Biblioteca: Form data accessors
                        // ──────────────────────────────────────────────────────────────
                        function getBibliotecaCreateFormData(): array
                        {
                            return array(
                                'nombre'           => isset($_POST['nombre'])           ? trim((string) $_POST['nombre'])           : '',
                                'direccion'        => isset($_POST['direccion'])        ? trim((string) $_POST['direccion'])        : '',
                                'ciudad'           => isset($_POST['ciudad'])           ? trim((string) $_POST['ciudad'])           : '',
                                'pais'             => isset($_POST['pais'])             ? trim((string) $_POST['pais'])             : '',
                                'telefono'         => isset($_POST['telefono'])         ? trim((string) $_POST['telefono'])         : '',
                                'email'            => isset($_POST['email'])            ? trim((string) $_POST['email'])            : '',
                                'horario_apertura' => isset($_POST['horario_apertura']) ? trim((string) $_POST['horario_apertura']) : '',
                                'horario_cierre'   => isset($_POST['horario_cierre'])   ? trim((string) $_POST['horario_cierre'])   : '',
                                'num_libros'       => isset($_POST['num_libros'])       ? (int) $_POST['num_libros']                : 0,
                                'num_usuarios'     => isset($_POST['num_usuarios'])     ? (int) $_POST['num_usuarios']              : 0,
                                'es_publica'       => isset($_POST['es_publica'])       && $_POST['es_publica'] === '1',
                                'web'              => isset($_POST['web'])              ? trim((string) $_POST['web'])              : '',
                            );
                        }

                        function getBibliotecaUpdateFormData(): array
                        {
                            $data           = getBibliotecaCreateFormData();
                            $data['id']     = isset($_POST['id']) ? trim((string) $_POST['id']) : '';
                            return $data;
                        }

                        // ──────────────────────────────────────────────────────────────
                        // Biblioteca: Validators
                        // ──────────────────────────────────────────────────────────────
                        function validateBibliotecaCreateForm(array $form): array
                        {
                            $errors = array();

                            if ($form['nombre'] === '') {
                                $errors['nombre'] = 'El nombre es obligatorio.';
                            } elseif (mb_strlen($form['nombre']) < 3) {
                                $errors['nombre'] = 'El nombre debe tener al menos 3 caracteres.';
                            }

                            if ($form['direccion'] === '') {
                                $errors['direccion'] = 'La dirección es obligatoria.';
                            }

                            if ($form['ciudad'] === '') {
                                $errors['ciudad'] = 'La ciudad es obligatoria.';
                            }

                            if ($form['pais'] === '') {
                                $errors['pais'] = 'El país es obligatorio.';
                            }

                            if ($form['telefono'] === '') {
                                $errors['telefono'] = 'El teléfono es obligatorio.';
                            } elseif (!preg_match('/^\+?[\d\s\-().]{6,20}$/', $form['telefono'])) {
                                $errors['telefono'] = 'El formato del teléfono no es válido.';
                            }

                            if ($form['email'] === '') {
                                $errors['email'] = 'El email es obligatorio.';
                            } elseif (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
                                $errors['email'] = 'El email no tiene un formato válido.';
                            }

                            if ($form['horario_apertura'] === '') {
                                $errors['horario_apertura'] = 'El horario de apertura es obligatorio.';
                            } elseif (!preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $form['horario_apertura'])) {
                                $errors['horario_apertura'] = 'El horario debe tener el formato HH:MM.';
                            }

                            if ($form['horario_cierre'] === '') {
                                $errors['horario_cierre'] = 'El horario de cierre es obligatorio.';
                            } elseif (!preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $form['horario_cierre'])) {
                                $errors['horario_cierre'] = 'El horario debe tener el formato HH:MM.';
                            }

                            if ($form['num_libros'] < 0) {
                                $errors['num_libros'] = 'El número de libros no puede ser negativo.';
                            }

                            if ($form['num_usuarios'] < 0) {
                                $errors['num_usuarios'] = 'El número de usuarios no puede ser negativo.';
                            }

                            if ($form['web'] !== '' && !filter_var($form['web'], FILTER_VALIDATE_URL)) {
                                $errors['web'] = 'La URL del sitio web no tiene un formato válido.';
                            }

                            return $errors;
                        }

                        function validateBibliotecaUpdateForm(array $form): array
                        {
                            return validateBibliotecaCreateForm($form);
                        }