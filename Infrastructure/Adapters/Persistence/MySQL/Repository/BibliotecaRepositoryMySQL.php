<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../../../Application/Ports/Out/SaveBibliotecaPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/UpdateBibliotecaPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/DeleteBibliotecaPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/GetBibliotecaByIdPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/GetBibliotecaByNombrePort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/GetAllBibliotecasPort.php';

require_once __DIR__ . '/../Mapper/BibliotecaPersistenceMapper.php';
require_once __DIR__ . '/../../../../../Domain/Models/BibliotecaModel.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/BibliotecaId.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/BibliotecaNombre.php';

final class BibliotecaRepositoryMySQL implements
    SaveBibliotecaPort,
    UpdateBibliotecaPort,
    DeleteBibliotecaPort,
    GetBibliotecaByIdPort,
    GetBibliotecaByNombrePort,
    GetAllBibliotecasPort
{
    private PDO                       $pdo;
    private BibliotecaPersistenceMapper $mapper;

    public function __construct(PDO $pdo, BibliotecaPersistenceMapper $mapper)
    {
        $this->pdo    = $pdo;
        $this->mapper = $mapper;
    }

    public function save(BibliotecaModel $biblioteca): BibliotecaModel
    {
        $dto = $this->mapper->fromModelToDto($biblioteca);

        $sql = 'INSERT INTO bibliotecas (
                    id, nombre, direccion, ciudad, pais, telefono, email,
                    horario_apertura, horario_cierre,
                    num_libros, num_usuarios, es_publica, web,
                    created_at, updated_at
                ) VALUES (
                    :id, :nombre, :direccion, :ciudad, :pais, :telefono, :email,
                    :horario_apertura, :horario_cierre,
                    :num_libros, :num_usuarios, :es_publica, :web,
                    NOW(), NOW()
                )';

        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(
            ':id'               => $dto->id(),
            ':nombre'           => $dto->nombre(),
            ':direccion'        => $dto->direccion(),
            ':ciudad'           => $dto->ciudad(),
            ':pais'             => $dto->pais(),
            ':telefono'         => $dto->telefono(),
            ':email'            => $dto->email(),
            ':horario_apertura' => $dto->horarioApertura(),
            ':horario_cierre'   => $dto->horarioCierre(),
            ':num_libros'       => $dto->numLibros(),
            ':num_usuarios'     => $dto->numUsuarios(),
            ':es_publica'       => $dto->esPublica() ? 1 : 0,
            ':web'              => $dto->web(),
        ));

        $saved = $this->getById(new BibliotecaId($dto->id()));

        if ($saved === null) {
            throw new RuntimeException('La biblioteca no pudo ser recuperada después de guardarla.');
        }

        return $saved;
    }

    public function update(BibliotecaModel $biblioteca): BibliotecaModel
    {
        $dto = $this->mapper->fromModelToDto($biblioteca);

        $sql = 'UPDATE bibliotecas SET
                    nombre           = :nombre,
                    direccion        = :direccion,
                    ciudad           = :ciudad,
                    pais             = :pais,
                    telefono         = :telefono,
                    email            = :email,
                    horario_apertura = :horario_apertura,
                    horario_cierre   = :horario_cierre,
                    num_libros       = :num_libros,
                    num_usuarios     = :num_usuarios,
                    es_publica       = :es_publica,
                    web              = :web,
                    updated_at       = NOW()
                WHERE id = :id';

        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(
            ':id'               => $dto->id(),
            ':nombre'           => $dto->nombre(),
            ':direccion'        => $dto->direccion(),
            ':ciudad'           => $dto->ciudad(),
            ':pais'             => $dto->pais(),
            ':telefono'         => $dto->telefono(),
            ':email'            => $dto->email(),
            ':horario_apertura' => $dto->horarioApertura(),
            ':horario_cierre'   => $dto->horarioCierre(),
            ':num_libros'       => $dto->numLibros(),
            ':num_usuarios'     => $dto->numUsuarios(),
            ':es_publica'       => $dto->esPublica() ? 1 : 0,
            ':web'              => $dto->web(),
        ));

        $updated = $this->getById(new BibliotecaId($dto->id()));

        if ($updated === null) {
            throw new RuntimeException('La biblioteca no pudo ser recuperada después de actualizarla.');
        }

        return $updated;
    }

    public function getById(BibliotecaId $id): ?BibliotecaModel
    {
        $sql = 'SELECT id, nombre, direccion, ciudad, pais, telefono, email,
                       horario_apertura, horario_cierre,
                       num_libros, num_usuarios, es_publica, web,
                       created_at, updated_at
                FROM bibliotecas
                WHERE id = :id
                LIMIT 1';

        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':id' => $id->value()));

        $row = $statement->fetch();

        if ($row === false) {
            return null;
        }

        return $this->mapper->fromRowToModel($row);
    }

    public function getByNombre(BibliotecaNombre $nombre): ?BibliotecaModel
    {
        $sql = 'SELECT id, nombre, direccion, ciudad, pais, telefono, email,
                       horario_apertura, horario_cierre,
                       num_libros, num_usuarios, es_publica, web,
                       created_at, updated_at
                FROM bibliotecas
                WHERE nombre = :nombre
                LIMIT 1';

        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':nombre' => $nombre->value()));

        $row = $statement->fetch();

        if ($row === false) {
            return null;
        }

        return $this->mapper->fromRowToModel($row);
    }

    public function getAll(): array
    {
        $sql = 'SELECT id, nombre, direccion, ciudad, pais, telefono, email,
                       horario_apertura, horario_cierre,
                       num_libros, num_usuarios, es_publica, web,
                       created_at, updated_at
                FROM bibliotecas
                ORDER BY nombre ASC';

        $statement = $this->pdo->query($sql);
        $rows      = $statement->fetchAll();

        return $this->mapper->fromRowsToModels($rows);
    }

    public function delete(BibliotecaId $id): void
    {
        $sql = 'DELETE FROM bibliotecas WHERE id = :id';

        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':id' => $id->value()));
    }
}
