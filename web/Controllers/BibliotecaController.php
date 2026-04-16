<?php

declare(strict_types=1);

require_once __DIR__ . '/Mapper/BibliotecaWebMapper.php';

require_once __DIR__ . '/../../Application/Ports/In/CreateBibliotecaUseCase.php';
require_once __DIR__ . '/../../Application/Ports/In/UpdateBibliotecaUseCase.php';
require_once __DIR__ . '/../../Application/Ports/In/GetBibliotecaByIdUseCase.php';
require_once __DIR__ . '/../../Application/Ports/In/GetAllBibliotecasUseCase.php';
require_once __DIR__ . '/../../Application/Ports/In/DeleteBibliotecaUseCase.php';

require_once __DIR__ . '/../../Application/Services/Dto/Queries/GetAllBibliotecasQuery.php';

final class BibliotecaController
{
    private CreateBibliotecaUseCase    $createBibliotecaUseCase;
    private UpdateBibliotecaUseCase    $updateBibliotecaUseCase;
    private GetBibliotecaByIdUseCase   $getBibliotecaByIdUseCase;
    private GetAllBibliotecasUseCase   $getAllBibliotecasUseCase;
    private DeleteBibliotecaUseCase    $deleteBibliotecaUseCase;
    private BibliotecaWebMapper        $mapper;

    public function __construct(
        CreateBibliotecaUseCase  $createBibliotecaUseCase,
        UpdateBibliotecaUseCase  $updateBibliotecaUseCase,
        GetBibliotecaByIdUseCase $getBibliotecaByIdUseCase,
        GetAllBibliotecasUseCase $getAllBibliotecasUseCase,
        DeleteBibliotecaUseCase  $deleteBibliotecaUseCase,
        BibliotecaWebMapper      $mapper
    ) {
        $this->createBibliotecaUseCase  = $createBibliotecaUseCase;
        $this->updateBibliotecaUseCase  = $updateBibliotecaUseCase;
        $this->getBibliotecaByIdUseCase = $getBibliotecaByIdUseCase;
        $this->getAllBibliotecasUseCase  = $getAllBibliotecasUseCase;
        $this->deleteBibliotecaUseCase  = $deleteBibliotecaUseCase;
        $this->mapper                   = $mapper;
    }

    public function index(): array
    {
        $bibliotecas = $this->getAllBibliotecasUseCase->execute(new GetAllBibliotecasQuery());

        return $this->mapper->fromModelsToResponses($bibliotecas);
    }

    public function show(string $id): BibliotecaResponse
    {
        $query      = $this->mapper->fromIdToGetByIdQuery($id);
        $biblioteca = $this->getBibliotecaByIdUseCase->execute($query);

        return $this->mapper->fromModelToResponse($biblioteca);
    }

    public function store(CreateBibliotecaWebRequest $request): BibliotecaResponse
    {
        $command    = $this->mapper->fromCreateRequestToCommand($request);
        $biblioteca = $this->createBibliotecaUseCase->execute($command);

        return $this->mapper->fromModelToResponse($biblioteca);
    }

    public function update(UpdateBibliotecaWebRequest $request): BibliotecaResponse
    {
        $command    = $this->mapper->fromUpdateRequestToCommand($request);
        $biblioteca = $this->updateBibliotecaUseCase->execute($command);

        return $this->mapper->fromModelToResponse($biblioteca);
    }

    public function delete(string $id): void
    {
        $command = $this->mapper->fromIdToDeleteCommand($id);
        $this->deleteBibliotecaUseCase->execute($command);
    }
}
