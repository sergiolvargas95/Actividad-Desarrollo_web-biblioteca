<?php

declare(strict_types=1);

require_once __DIR__ . '/../Dto/CreateBibliotecaRequest.php';
require_once __DIR__ . '/../Dto/UpdateBibliotecaRequest.php';
require_once __DIR__ . '/../Dto/BibliotecaResponse.php';

require_once __DIR__ . '/../../../Application/Services/Dto/Commands/CreateBibliotecaCommand.php';
require_once __DIR__ . '/../../../Application/Services/Dto/Commands/UpdateBibliotecaCommand.php';
require_once __DIR__ . '/../../../Application/Services/Dto/Commands/DeleteBibliotecaCommand.php';
require_once __DIR__ . '/../../../Application/Services/Dto/Queries/GetBibliotecaByIdQuery.php';

require_once __DIR__ . '/../../../Domain/Models/BibliotecaModel.php';

final class BibliotecaWebMapper
{
    public function fromCreateRequestToCommand(CreateBibliotecaWebRequest $request): CreateBibliotecaCommand
    {
        return new CreateBibliotecaCommand(
            $request->getId(),
            $request->getNombre(),
            $request->getDireccion(),
            $request->getCiudad(),
            $request->getPais(),
            $request->getTelefono(),
            $request->getEmail(),
            $request->getHorarioApertura(),
            $request->getHorarioCierre(),
            $request->getNumLibros(),
            $request->getNumUsuarios(),
            $request->getEsPublica(),
            $request->getWeb()
        );
    }

    public function fromUpdateRequestToCommand(UpdateBibliotecaWebRequest $request): UpdateBibliotecaCommand
    {
        return new UpdateBibliotecaCommand(
            $request->getId(),
            $request->getNombre(),
            $request->getDireccion(),
            $request->getCiudad(),
            $request->getPais(),
            $request->getTelefono(),
            $request->getEmail(),
            $request->getHorarioApertura(),
            $request->getHorarioCierre(),
            $request->getNumLibros(),
            $request->getNumUsuarios(),
            $request->getEsPublica(),
            $request->getWeb()
        );
    }

    public function fromIdToGetByIdQuery(string $id): GetBibliotecaByIdQuery
    {
        return new GetBibliotecaByIdQuery($id);
    }

    public function fromIdToDeleteCommand(string $id): DeleteBibliotecaCommand
    {
        return new DeleteBibliotecaCommand($id);
    }

    public function fromModelToResponse(BibliotecaModel $biblioteca): BibliotecaResponse
    {
        return new BibliotecaResponse(
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

    public function fromModelsToResponses(array $bibliotecas): array
    {
        $responses = array();

        foreach ($bibliotecas as $biblioteca) {
            $responses[] = $this->fromModelToResponse($biblioteca);
        }

        return $responses;
    }
}
