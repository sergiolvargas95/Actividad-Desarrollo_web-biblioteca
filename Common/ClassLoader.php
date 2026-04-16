<?php

declare(strict_types=1);

final class ClassLoader
{
    private static array $classMap = array(
        'InvalidUserEmailException' => 'Domain/Exceptions/InvalidUserEmailException.php',
        'InvalidUserIdException' => 'Domain/Exceptions/InvalidUserIdException.php',
        'InvalidUserNameException' => 'Domain/Exceptions/InvalidUserNameException.php',
        'InvalidUserPasswordException' => 'Domain/Exceptions/InvalidUserPasswordException.php',
        'InvalidUserRoleException' => 'Domain/Exceptions/InvalidUserRoleException.php',
        'InvalidUserStatusException' => 'Domain/Exceptions/InvalidUserStatusException.php',
        'UserAlreadyExistsException' => 'Domain/Exceptions/UserAlreadyExistsException.php',
        'UserNotFoundException' => 'Domain/Exceptions/UserNotFoundException.php',
        'InvalidCredentialsException' => 'Domain/Exceptions/InvalidCredentialsException.php',

        'UserRoleEnum' => 'Domain/Enums/UserRoleEnum.php',
        'UserStatusEnum' => 'Domain/Enums/UserStatusEnum.php',

        'UserId' => 'Domain/ValueObjects/UserId.php',
        'UserName' => 'Domain/ValueObjects/UserName.php',
        'UserEmail' => 'Domain/ValueObjects/UserEmail.php',
        'UserPassword' => 'Domain/ValueObjects/UserPassword.php',

        'UserModel' => 'Domain/Models/UserModel.php',

        'CreateUserUseCase' => 'Application/Ports/In/CreateUserUseCase.php',
        'UpdateUserUseCase' => 'Application/Ports/In/UpdateUserUseCase.php',
        'GetUserByIdUseCase' => 'Application/Ports/In/GetUserByIdUseCase.php',
        'GetAllUsersUseCase' => 'Application/Ports/In/GetAllUsersUseCase.php',
        'DeleteUserUseCase' => 'Application/Ports/In/DeleteUserUseCase.php',
        'LoginUseCase' => 'Application/Ports/In/LoginUseCase.php',
        'ForgotPasswordUseCase' => 'Application/Ports/In/ForgotPasswordUseCase.php',

        'SaveUserPort' => 'Application/Ports/Out/SaveUserPort.php',
        'UpdateUserPort' => 'Application/Ports/Out/UpdateUserPort.php',
        'GetUserByIdPort' => 'Application/Ports/Out/GetUserByIdPort.php',
        'GetUserByEmailPort' => 'Application/Ports/Out/GetUserByEmailPort.php',
        'GetAllUsersPort' => 'Application/Ports/Out/GetAllUsersPort.php',
        'DeleteUserPort' => 'Application/Ports/Out/DeleteUserPort.php',

        'CreateUserCommand' => 'Application/Services/Dto/Commands/CreateUserCommand.php',
        'UpdateUserCommand' => 'Application/Services/Dto/Commands/UpdateUserCommand.php',
        'DeleteUserCommand' => 'Application/Services/Dto/Commands/DeleteUserCommand.php',
        'LoginCommand' => 'Application/Services/Dto/Commands/LoginCommand.php',
        'ForgotPasswordCommand' => 'Application/Services/Dto/Commands/ForgotPasswordCommand.php',
        'GetUserByIdQuery' => 'Application/Services/Dto/Queries/GetUserByIdQuery.php',
        'GetAllUsersQuery' => 'Application/Services/Dto/Queries/GetAllUsersQuery.php',

        'CreateUserService' => 'Application/Services/CreateUserService.php',
        'UpdateUserService' => 'Application/Services/UpdateUserService.php',
        'GetUserByIdService' => 'Application/Services/GetUserByIdService.php',
        'GetAllUsersService' => 'Application/Services/GetAllUsersServices.php',
        'DeleteUserService' => 'Application/Services/DeleteUserService.php',
        'LoginService' => 'Application/Services/LoginService.php',
        'ForgotPasswordService' => 'Application/Services/ForgotPasswordService.php',
        'UserApplicationMapper' => 'Application/Services/Mappers/UserApplicationMapper.php',

        // ── Biblioteca: Exceptions ────────────────────────────────────────────────
        'InvalidBibliotecaIdException'        => 'Domain/Exceptions/InvalidBibliotecaIdException.php',
        'InvalidBibliotecaNombreException'    => 'Domain/Exceptions/InvalidBibliotecaNombreException.php',
        'InvalidBibliotecaDireccionException' => 'Domain/Exceptions/InvalidBibliotecaDireccionException.php',
        'InvalidBibliotecaCiudadException'    => 'Domain/Exceptions/InvalidBibliotecaCiudadException.php',
        'InvalidBibliotecaPaisException'      => 'Domain/Exceptions/InvalidBibliotecaPaisException.php',
        'InvalidBibliotecaTelefonoException'  => 'Domain/Exceptions/InvalidBibliotecaTelefonoException.php',
        'InvalidBibliotecaEmailException'     => 'Domain/Exceptions/InvalidBibliotecaEmailException.php',
        'InvalidBibliotecaHorarioException'   => 'Domain/Exceptions/InvalidBibliotecaHorarioException.php',
        'InvalidBibliotecaWebException'       => 'Domain/Exceptions/InvalidBibliotecaWebException.php',
        'BibliotecaNotFoundException'         => 'Domain/Exceptions/BibliotecaNotFoundException.php',
        'BibliotecaAlreadyExistsException'    => 'Domain/Exceptions/BibliotecaAlreadyExistsException.php',

        // ── Biblioteca: Value Objects ─────────────────────────────────────────────
        'BibliotecaId'        => 'Domain/ValueObjects/BibliotecaId.php',
        'BibliotecaNombre'    => 'Domain/ValueObjects/BibliotecaNombre.php',
        'BibliotecaDireccion' => 'Domain/ValueObjects/BibliotecaDireccion.php',
        'BibliotecaCiudad'    => 'Domain/ValueObjects/BibliotecaCiudad.php',
        'BibliotecaPais'      => 'Domain/ValueObjects/BibliotecaPais.php',
        'BibliotecaTelefono'  => 'Domain/ValueObjects/BibliotecaTelefono.php',
        'BibliotecaEmail'     => 'Domain/ValueObjects/BibliotecaEmail.php',
        'BibliotecaHorario'   => 'Domain/ValueObjects/BibliotecaHorario.php',
        'BibliotecaWeb'       => 'Domain/ValueObjects/BibliotecaWeb.php',

        // ── Biblioteca: Model ─────────────────────────────────────────────────────
        'BibliotecaModel' => 'Domain/Models/BibliotecaModel.php',

        // ── Biblioteca: Ports In ──────────────────────────────────────────────────
        'CreateBibliotecaUseCase'      => 'Application/Ports/In/CreateBibliotecaUseCase.php',
        'UpdateBibliotecaUseCase'      => 'Application/Ports/In/UpdateBibliotecaUseCase.php',
        'DeleteBibliotecaUseCase'      => 'Application/Ports/In/DeleteBibliotecaUseCase.php',
        'GetBibliotecaByIdUseCase'     => 'Application/Ports/In/GetBibliotecaByIdUseCase.php',
        'GetAllBibliotecasUseCase'     => 'Application/Ports/In/GetAllBibliotecasUseCase.php',

        // ── Biblioteca: Ports Out ─────────────────────────────────────────────────
        'SaveBibliotecaPort'           => 'Application/Ports/Out/SaveBibliotecaPort.php',
        'UpdateBibliotecaPort'         => 'Application/Ports/Out/UpdateBibliotecaPort.php',
        'DeleteBibliotecaPort'         => 'Application/Ports/Out/DeleteBibliotecaPort.php',
        'GetBibliotecaByIdPort'        => 'Application/Ports/Out/GetBibliotecaByIdPort.php',
        'GetBibliotecaByNombrePort'    => 'Application/Ports/Out/GetBibliotecaByNombrePort.php',
        'GetAllBibliotecasPort'        => 'Application/Ports/Out/GetAllBibliotecasPort.php',

        // ── Biblioteca: Commands & Queries ────────────────────────────────────────
        'CreateBibliotecaCommand'  => 'Application/Services/Dto/Commands/CreateBibliotecaCommand.php',
        'UpdateBibliotecaCommand'  => 'Application/Services/Dto/Commands/UpdateBibliotecaCommand.php',
        'DeleteBibliotecaCommand'  => 'Application/Services/Dto/Commands/DeleteBibliotecaCommand.php',
        'GetBibliotecaByIdQuery'   => 'Application/Services/Dto/Queries/GetBibliotecaByIdQuery.php',
        'GetAllBibliotecasQuery'   => 'Application/Services/Dto/Queries/GetAllBibliotecasQuery.php',

        // ── Biblioteca: Services ──────────────────────────────────────────────────
        'CreateBibliotecaService'      => 'Application/Services/CreateBibliotecaService.php',
        'UpdateBibliotecaService'      => 'Application/Services/UpdateBibliotecaService.php',
        'DeleteBibliotecaService'      => 'Application/Services/DeleteBibliotecaService.php',
        'GetBibliotecaByIdService'     => 'Application/Services/GetBibliotecaByIdService.php',
        'GetAllBibliotecasService'     => 'Application/Services/GetAllBibliotecasService.php',
        'BibliotecaApplicationMapper'  => 'Application/Services/Mappers/BibliotecaApplicationMapper.php',

        // ── Biblioteca: Infrastructure ────────────────────────────────────────────
        'BibliotecaPersistenceDto'     => 'Infrastructure/Adapters/Persistence/MySQL/Dto/BibliotecaPersistenceDto.php',
        'BibliotecaEntity'             => 'Infrastructure/Adapters/Persistence/MySQL/Entity/BibliotecaEntity.php',
        'BibliotecaPersistenceMapper'  => 'Infrastructure/Adapters/Persistence/MySQL/Mapper/BibliotecaPersistenceMapper.php',
        'BibliotecaRepositoryMySQL'    => 'Infrastructure/Adapters/Persistence/MySQL/Repository/BibliotecaRepositoryMySQL.php',

        'Connection' => 'Infrastructure/Adapters/Persistence/MySQL/Config/Connection.php',
        'UserPersistenceDto' => 'Infrastructure/Adapters/Persistence/MySQL/Dto/UserPersistenceDto.php',
        'UserEntity' => 'Infrastructure/Adapters/Persistence/MySQL/Entity/UserEntity.php',
        'UserPersistenceMapper' => 'Infrastructure/Adapters/Persistence/MySQL/Mapper/UserPersistenceMapper.php',
        'UserRepositoryMySQL' => 'Infrastructure/Adapters/Persistence/MySQL/Repository/UserRepositoryMySQL.php',

        // ── Biblioteca: Web ───────────────────────────────────────────────────────
        'CreateBibliotecaWebRequest' => 'web/Controllers/Dto/CreateBibliotecaRequest.php',
        'UpdateBibliotecaWebRequest' => 'web/Controllers/Dto/UpdateBibliotecaRequest.php',
        'BibliotecaResponse'         => 'web/Controllers/Dto/BibliotecaResponse.php',
        'BibliotecaWebMapper'        => 'web/Controllers/Mapper/BibliotecaWebMapper.php',
        'BibliotecaController'       => 'web/Controllers/BibliotecaController.php',

        'CreateUserWebRequest' => 'web/Controllers/Dto/CreateUserRequest.php',
        'UpdateUserWebRequest' => 'web/Controllers/Dto/UpdateUserRequest.php',
        'LoginWebRequest' => 'web/Controllers/Dto/LoginRequest.php',
        'UserResponse' => 'web/Controllers/Dto/UserResponse.php',
        'UserWebMapper' => 'web/Controllers/Mapper/UserWebRoutes.php',
        'UserController' => 'web/Controllers/UserController.php',
        'WebRoutes' => 'web/Controllers/config/WebRoutes.php',

        'View' => 'web/Presentation/View.php',
        'Flash' => 'web/Presentation/Flash.php',

        'DependencyInjection' => 'Common/DependencyInjection.php',
    );

    public static function register(): void
    {
        spl_autoload_register(array(self::class, 'loadClass'));
    }

    public static function loadClass(string $className): void
    {
        if(!isset(self::$classMap[$className])) {
            return;
        }

        $baseDir = dirname(__DIR__) . DIRECTORY_SEPARATOR;
        $filePath = $baseDir . self::$classMap[$className];

        if(!file_exists($filePath)) {
            throw new RuntimeException(
                sprintf('No se encontró el archivo para la clase %s en %s', $className, $filePath)
            );
        }

        require_once $filePath;
    }
}