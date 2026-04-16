<?php

declare(strict_types=1);

require_once __DIR__ . '/ClassLoader.php';

final class DependencyInjection
{
    public static function boot(): void
    {
        ClassLoader::register();
    }

    public static function getConnection(): Connection
    {
        ClassLoader::loadClass('Connection');
        return new Connection(
            host: '127.0.0.1',
            port: 3306,
            database: 'crudl',
            username: 'root',
            password: '',
            charset: 'utf8mb4'
        );
    }

    public static function getPdo(): PDO
    {
        return self::getConnection()->createPdo();
    }

    public static function getUserPersistenceMapper(): UserPersistenceMapper
    {
        ClassLoader::loadClass('UserPersistenceMapper');
        return new UserPersistenceMapper();
    }

    public static function getUserRepository(): UserRepositoryMySQL
    {
        ClassLoader::loadClass('UserRepositoryMySQL');
        return new UserRepositoryMySQL(self::getPdo(), self::getUserPersistenceMapper());
    }

    public static function getCreateUserUseCase(): CreateUserUseCase
    {
        ClassLoader::loadClass('CreateUserService');
        $repo = self::getUserRepository();
        return new CreateUserService($repo, $repo);
    }

    public static function getUpdateUserUseCase(): UpdateUserUseCase
    {
        ClassLoader::loadClass('UpdateUserService');
        $repo = self::getUserRepository();
        return new UpdateUserService($repo, $repo, $repo);
    }

    public static function getDeleteUserUseCase(): DeleteUserUseCase
    {
        ClassLoader::loadClass('DeleteUserService');
        $repo = self::getUserRepository();
        return new DeleteUserService($repo, $repo);
    }

    public static function getUserByIdUseCase(): GetUserByIdUseCase
    {
        ClassLoader::loadClass('GetUserByIdUseCase');
        return new GetUserByIdService(self::getUserRepository());
    }

    public static function getAllUsersUseCase(): GetAllUsersUseCase
    {
        ClassLoader::loadClass('GetAllUsersService');
        return new GetAllUsersService(self::getUserRepository());
    }

    public static function getUserController(): UserController
    {
        ClassLoader::loadClass('UserWebMapper');
        ClassLoader::loadClass('UserController');
        return new UserController(
            self::getCreateUserUseCase(),
            self::getUpdateUserUseCase(),
            self::getUserByIdUseCase(),
            self::getAllUsersUseCase(),
            self::getDeleteUserUseCase(),
            new UserWebMapper()
        );
    }

    public static function getLoginUseCase(): LoginUseCase
    {
        ClassLoader::loadClass('LoginService');
        return new LoginService(self::getUserRepository());
    }

    public static function getForgotPasswordUseCase(): ForgotPasswordUseCase
    {
        ClassLoader::loadClass('ForgotPasswordService');
        $repo = self::getUserRepository();
        return new ForgotPasswordService($repo, $repo);
    }

    // ── Biblioteca ────────────────────────────────────────────────────────────────

    public static function getBibliotecaRepository(): BibliotecaRepositoryMySQL
    {
        ClassLoader::loadClass('BibliotecaRepositoryMySQL');
        ClassLoader::loadClass('BibliotecaPersistenceMapper');
        return new BibliotecaRepositoryMySQL(self::getPdo(), new BibliotecaPersistenceMapper());
    }

    public static function getCreateBibliotecaUseCase(): CreateBibliotecaUseCase
    {
        ClassLoader::loadClass('CreateBibliotecaService');
        $repo = self::getBibliotecaRepository();
        return new CreateBibliotecaService($repo, $repo);
    }

    public static function getUpdateBibliotecaUseCase(): UpdateBibliotecaUseCase
    {
        ClassLoader::loadClass('UpdateBibliotecaService');
        $repo = self::getBibliotecaRepository();
        return new UpdateBibliotecaService($repo, $repo, $repo);
    }

    public static function getDeleteBibliotecaUseCase(): DeleteBibliotecaUseCase
    {
        ClassLoader::loadClass('DeleteBibliotecaService');
        $repo = self::getBibliotecaRepository();
        return new DeleteBibliotecaService($repo, $repo);
    }

    public static function getGetBibliotecaByIdUseCase(): GetBibliotecaByIdUseCase
    {
        ClassLoader::loadClass('GetBibliotecaByIdService');
        return new GetBibliotecaByIdService(self::getBibliotecaRepository());
    }

    public static function getGetAllBibliotecasUseCase(): GetAllBibliotecasUseCase
    {
        ClassLoader::loadClass('GetAllBibliotecasService');
        return new GetAllBibliotecasService(self::getBibliotecaRepository());
    }

    public static function getBibliotecaController(): BibliotecaController
    {
        ClassLoader::loadClass('BibliotecaWebMapper');
        ClassLoader::loadClass('BibliotecaController');
        return new BibliotecaController(
            self::getCreateBibliotecaUseCase(),
            self::getUpdateBibliotecaUseCase(),
            self::getGetBibliotecaByIdUseCase(),
            self::getGetAllBibliotecasUseCase(),
            self::getDeleteBibliotecaUseCase(),
            new BibliotecaWebMapper()
        );
    }
}