<?php

declare(strict_types=1);

require_once __DIR__ . '/../Dto/Commands/CreateBibliotecaCommand.php';
require_once __DIR__ . '/../Dto/Commands/UpdateBibliotecaCommand.php';
require_once __DIR__ . '/../Dto/Commands/DeleteBibliotecaCommand.php';
require_once __DIR__ . '/../Dto/Queries/GetBibliotecaByIdQuery.php';

require_once __DIR__ . '/../../../Domain/Models/BibliotecaModel.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/BibliotecaId.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/BibliotecaNombre.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/BibliotecaDireccion.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/BibliotecaCiudad.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/BibliotecaPais.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/BibliotecaTelefono.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/BibliotecaEmail.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/BibliotecaHorario.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/BibliotecaWeb.php';

final class BibliotecaApplicationMapper
{
    public static function fromCreateCommandToModel(CreateBibliotecaCommand $command): BibliotecaModel
    {
        return BibliotecaModel::create(
            new BibliotecaId($command->getId()),
            new BibliotecaNombre($command->getNombre()),
            new BibliotecaDireccion($command->getDireccion()),
            new BibliotecaCiudad($command->getCiudad()),
            new BibliotecaPais($command->getPais()),
            new BibliotecaTelefono($command->getTelefono()),
            new BibliotecaEmail($command->getEmail()),
            new BibliotecaHorario($command->getHorarioApertura()),
            new BibliotecaHorario($command->getHorarioCierre()),
            $command->getNumLibros(),
            $command->getNumUsuarios(),
            $command->getEsPublica(),
            new BibliotecaWeb($command->getWeb())
        );
    }

    public static function fromUpdateCommandToModel(UpdateBibliotecaCommand $command): BibliotecaModel
    {
        return new BibliotecaModel(
            new BibliotecaId($command->getId()),
            new BibliotecaNombre($command->getNombre()),
            new BibliotecaDireccion($command->getDireccion()),
            new BibliotecaCiudad($command->getCiudad()),
            new BibliotecaPais($command->getPais()),
            new BibliotecaTelefono($command->getTelefono()),
            new BibliotecaEmail($command->getEmail()),
            new BibliotecaHorario($command->getHorarioApertura()),
            new BibliotecaHorario($command->getHorarioCierre()),
            $command->getNumLibros(),
            $command->getNumUsuarios(),
            $command->getEsPublica(),
            new BibliotecaWeb($command->getWeb())
        );
    }

    public static function fromGetByIdQueryToBibliotecaId(GetBibliotecaByIdQuery $query): BibliotecaId
    {
        return new BibliotecaId($query->getId());
    }

    public static function fromDeleteCommandToBibliotecaId(DeleteBibliotecaCommand $command): BibliotecaId
    {
        return new BibliotecaId($command->getId());
    }

    public static function fromModelToArray(BibliotecaModel $biblioteca): array
    {
        return array(
            'id'              => $biblioteca->id()->value(),
            'nombre'          => $biblioteca->nombre()->value(),
            'direccion'       => $biblioteca->direccion()->value(),
            'ciudad'          => $biblioteca->ciudad()->value(),
            'pais'            => $biblioteca->pais()->value(),
            'telefono'        => $biblioteca->telefono()->value(),
            'email'           => $biblioteca->email()->value(),
            'horarioApertura' => $biblioteca->horarioApertura()->value(),
            'horarioCierre'   => $biblioteca->horarioCierre()->value(),
            'numLibros'       => $biblioteca->numLibros(),
            'numUsuarios'     => $biblioteca->numUsuarios(),
            'esPublica'       => $biblioteca->esPublica(),
            'web'             => $biblioteca->web()->value(),
        );
    }

    public static function fromModelsToArray(array $bibliotecas): array
    {
        $result = array();
        foreach ($bibliotecas as $biblioteca) {
            $result[] = self::fromModelToArray($biblioteca);
        }

        return $result;
    }
}
