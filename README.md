# CRUDL — Gestión de Usuarios y Bibliotecas

Aplicación web PHP con arquitectura en capas (DDD) para gestionar usuarios y bibliotecas. Incluye autenticación, control de roles, recuperación de contraseña por correo y operaciones CRUD completas.

<img width="1001" height="580" alt="image" src="https://github.com/user-attachments/assets/894008b2-b702-4444-9202-859eea5323e3" />

---

## Tecnologías

- **PHP 8.x** con `declare(strict_types=1)`
- **MySQL** — base de datos relacional
- **PDO** — acceso a base de datos
- **Brevo API** — envío de correos transaccionales vía HTTP
- **vlucas/phpdotenv** — variables de entorno
- **Composer** — gestión de dependencias

---

## Arquitectura

El proyecto sigue los principios de **Domain-Driven Design (DDD)** con separación estricta en capas:

```
CRUDL/
├── Domain/                  # Núcleo del negocio (sin dependencias externas)
│   ├── Models/              # Entidades de dominio (UserModel, BibliotecaModel)
│   ├── ValueObjects/        # Objetos de valor con validación propia
│   ├── Enums/               # Enumeraciones (UserRoleEnum, UserStatusEnum)
│   ├── Events/              # Eventos de dominio
│   └── Exceptions/          # Excepciones de dominio tipadas
│
├── Application/             # Casos de uso
│   └── Services/            # Un servicio por acción de negocio
│
├── Infrastructure/          # Implementaciones técnicas
│   └── Adapters/Persistence/MySQL/
│       ├── Config/          # Conexión PDO
│       ├── Repository/      # Implementación de repositorios
│       ├── Entity/          # DTOs de persistencia
│       └── Mapper/          # Mapeo entre capa de datos y dominio
│
├── web/                     # Capa de presentación web
│   ├── Controllers/         # Controladores HTTP
│   │   └── config/          # Definición de rutas (WebRoutes)
│   └── Presentation/        # View y Flash helpers
│
├── Views/                   # Plantillas PHP
│   ├── users/
│   ├── bibliotecas/
│   ├── auth/
│   └── email/
│
├── Common/                  # Infraestructura transversal
│   ├── ClassLoader.php      # Carga manual de clases
│   └── DependencyInjection.php  # Contenedor de dependencias
│
├── database/
│   └── migrations/          # Scripts SQL de creación de tablas
│
└── public/
    └── index.php            # Front controller único
```

---

## Módulos

### Usuarios
| Ruta | Método | Descripción |
|---|---|---|
| `?route=users.index` | GET | Listar usuarios |
| `?route=users.create` | GET | Formulario de registro |
| `?route=users.store` | POST | Guardar nuevo usuario |
| `?route=users.show&id=` | GET | Detalle de usuario |
| `?route=users.edit&id=` | GET | Formulario de edición |
| `?route=users.update` | POST | Actualizar usuario |
| `?route=users.delete` | POST | Eliminar usuario |

**Roles disponibles:** `ADMIN`, `USER`, `GUEST`
**Estados disponibles:** `ACTIVE`, `INACTIVE`, `PENDING`, `BLOCKED`

### Bibliotecas
| Ruta | Método | Descripción |
|---|---|---|
| `?route=bibliotecas.index` | GET | Listar bibliotecas |
| `?route=bibliotecas.create` | GET | Formulario de registro |
| `?route=bibliotecas.store` | POST | Guardar nueva biblioteca |
| `?route=bibliotecas.show&id=` | GET | Detalle de biblioteca |
| `?route=bibliotecas.edit&id=` | GET | Formulario de edición |
| `?route=bibliotecas.update` | POST | Actualizar biblioteca |
| `?route=bibliotecas.delete` | POST | Eliminar biblioteca |

### Autenticación
| Ruta | Método | Descripción |
|---|---|---|
| `?route=auth.login` | GET | Formulario de login |
| `?route=auth.authenticate` | POST | Verificar credenciales |
| `?route=auth.logout` | GET | Cerrar sesión |
| `?route=auth.forgot` | GET | Formulario recuperación de contraseña |
| `?route=auth.forgot.send` | POST | Enviar contraseña temporal por email |

---

## Base de datos

### Tabla `users`
| Columna | Tipo | Descripción |
|---|---|---|
| `id` | VARCHAR(36) | UUID v4 |
| `name` | VARCHAR(255) | Nombre completo |
| `email` | VARCHAR(255) | Único |
| `password` | VARCHAR(255) | Hash bcrypt |
| `role` | ENUM | `ADMIN`, `USER`, `GUEST` |
| `status` | ENUM | `ACTIVE`, `INACTIVE`, `PENDING`, `BLOCKED` |
| `created_at` / `updated_at` | DATETIME | Auditoría automática |

### Tabla `bibliotecas`
| Columna | Tipo | Descripción |
|---|---|---|
| `id` | VARCHAR(36) | UUID v4 |
| `nombre` | VARCHAR(255) | Único |
| `direccion` | VARCHAR(255) | |
| `ciudad` / `pais` | VARCHAR(100) | Indexados |
| `telefono` | VARCHAR(20) | Formato `+?[\d\s\-().]{6,20}` |
| `email` | VARCHAR(255) | |
| `horario_apertura` / `horario_cierre` | VARCHAR(5) | Formato `HH:MM` |
| `num_libros` / `num_usuarios` | INT UNSIGNED | No negativos |
| `es_publica` | TINYINT(1) | Booleano |
| `web` | VARCHAR(500) | URL opcional |
| `created_at` / `updated_at` | DATETIME | Auditoría automática |

---

## Instalación local (XAMPP)

### 1. Clonar el repositorio
```bash
git clone <url-del-repo> c:/xampp/htdocs/CRUDL
cd c:/xampp/htdocs/CRUDL
```

### 2. Instalar dependencias
```bash
composer install
```

### 3. Configurar variables de entorno
```bash
cp .env.example .env
```

Edita `.env` con tus credenciales:
```env
BREVO_API_KEY=xkeysib-xxxxxxxxxxxx
MAIL_FROM_ADDRESS=no-reply@tudominio.com
MAIL_FROM_NAME="CRUDL App"
```

### 4. Crear la base de datos
Desde phpMyAdmin o MySQL CLI:
```sql
CREATE DATABASE crudl CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Luego ejecutar las migraciones en orden:
```bash
mysql -u root crudl < database/migrations/000_create_users_table.sql
mysql -u root crudl < database/migrations/001_create_bibliotecas_table.sql
```

### 5. Configurar la conexión
Edita `Common/DependencyInjection.php` con tus credenciales MySQL:
```php
return new Connection(
    host: '127.0.0.1',
    port: 3306,
    database: 'crudl',
    username: 'root',
    password: '',
);
```

### 6. Acceder
```
http://localhost/CRUDL/public/index.php?route=home
```

---

## Deploy en hosting gratuito (InfinityFree)

### Consideraciones importantes
- InfinityFree **bloquea conexiones SMTP salientes** (puertos 25, 465, 587)
- La función `mail()` de PHP está **deshabilitada**
- Por eso el envío de correos usa la **API HTTP de Brevo** (no PHPMailer ni SMTP)

### Pasos
1. Crear cuenta en [infinityfree.com](https://infinityfree.com)
2. Crear base de datos MySQL desde el panel e importar las migraciones desde phpMyAdmin
3. Actualizar `Common/DependencyInjection.php` con las credenciales MySQL del panel
4. Crear cuenta en [brevo.com](https://www.brevo.com) y obtener un API Key
5. Subir todos los archivos por FTP a la carpeta `htdocs/` del servidor
6. Crear el `.env` en el servidor con las credenciales reales

---

## Envío de correos (Brevo API)

El proyecto usa la API REST de Brevo para envío de correos transaccionales (ej. recuperación de contraseña). No usa SMTP ni la función `mail()` de PHP — la solicitud sale por HTTPS (puerto 443) hacia `api.brevo.com`.

Variables de entorno requeridas:
```env
BREVO_API_KEY=        # API Key generada en Settings → API Keys de Brevo
MAIL_FROM_ADDRESS=    # Remitente verificado en Brevo (Senders → Add a sender)
MAIL_FROM_NAME=       # Nombre del remitente
```

---

## Seguridad

- Contraseñas hasheadas con `password_hash()` / verificadas con `password_verify()`
- IDs generados como UUID v4 aleatorios
- Consultas SQL con **prepared statements** (PDO, sin concatenación)
- Rutas protegidas: todas excepto `home`, `login`, `register` y `forgot` requieren sesión activa
- Validación de método HTTP por ruta (GET/POST estrictos)
- Acceso directo a archivos fuera de `public/` bloqueado por el front controller
