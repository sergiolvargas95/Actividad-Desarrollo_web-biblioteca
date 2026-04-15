<?php

declare(strict_types=1);

require_once __DIR__ . '/../Dto/BibliotecaPersistenceDto.php';
require_once __DIR__ . '/../Entity/BibliotecaEntity.php';

require_once __DIR__ . '/../../../../../Domain/Models/BibliotecaModel.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/BibliotecaId.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/BibliotecaNombre.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/BibliotecaDireccion.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/BibliotecaCiudad.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/BibliotecaPais.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/BibliotecaTelefono.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/BibliotecaEmail.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/BibliotecaHorario.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/BibliotecaWeb.php';

final class BibliotecaPersistenceMapper
{
    public function fromModelToDto(BibliotecaModel $biblioteca): BibliotecaPersistenceDto
    {
        return new BibliotecaPersistenceDto(
            $biblioteca->id()->value(),
            $biblioteca->nombre()->value(),
            $biblioteca->direccion()->value(),
            $biblioteca->ciudad()->value(),
            $biblioteca->pais()->value(),
            $biblioteca->telefono()->value(),
            $biblioteca->email()->value(),
            $biblioteca->horarioApertura()->value(),
            $biblioteca->horarioCierre()->value(),
            $biblioteca->numLibros(),
            $biblioteca->numUsuarios(),
            $biblioteca->esPublica(),
            $biblioteca->web()->value()
        );
    }

    public function fromDtoToEntity(BibliotecaPersistenceDto $dto): BibliotecaEntity
    {
        return new BibliotecaEntity(
            $dto->id(),
            $dto->nombre(),
            $dto->direccion(),
            $dto->ciudad(),
            $dto->pais(),
            $dto->telefono(),
            $dto->email(),
            $dto->horarioApertura(),
            $dto->horarioCierre(),
            $dto->numLibros(),
            $dto->numUsuarios(),
            $dto->esPublica(),
            $dto->web()
        );
    }

    public function fromRowToEntity(array $row): BibliotecaEntity
    {
        return new BibliotecaEntity(
            (string)  $row['id'],
            (string)  $row['nombre'],
            (string)  $row['direccion'],
            (string)  $row['ciudad'],
            (string)  $row['pais'],
            (string)  $row['telefono'],
            (string)  $row['email'],
            (string)  $row['horario_apertura'],
            (string)  $row['horario_cierre'],
            (int)     $row['num_libros'],
            (int)     $row['num_usuarios'],
            (bool)    $row['es_publica'],
            (string)  ($row['web'] ?? ''),
            isset($row['created_at']) ? (string) $row['created_at'] : null,
            isset($row['updated_at']) ? (string) $row['updated_at'] : null
        );
    }

    public function fromEntityToModel(BibliotecaEntity $entity): BibliotecaModel
    {
        return new BibliotecaModel(
            new BibliotecaId($entity->id()),
            new BibliotecaNombre($entity->nombre()),
            new BibliotecaDireccion($entity->direccion()),
            new BibliotecaCiudad($entity->ciudad()),
            new BibliotecaPais($entity->pais()),
            new BibliotecaTelefono($entity->telefono()),
            new BibliotecaEmail($entity->email()),
            new BibliotecaHorario($entity->horarioApertura()),
            new BibliotecaHorario($entity->horarioCierre()),
            $entity->numLibros(),
            $entity->numUsuarios(),
            $entity->esPublica(),
            new BibliotecaWeb($entity->web())
        );
    }

    public function fromRowToModel(array $row): BibliotecaModel
    {
        return $this->fromEntityToModel(
            $this->fromRowToEntity($row)
        );
    }

    public function fromRowsToModels(array $rows): array
    {
        $models = array();

        foreach ($rows as $row) {
            $models[] = $this->fromRowToModel($row);
        }

        return $models;
    }
}
