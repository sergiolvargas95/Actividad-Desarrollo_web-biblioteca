<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/GetAllBibliotecasUseCase.php';
require_once __DIR__ . '/../Ports/Out/GetAllBibliotecasPort.php';

final class GetAllBibliotecasService implements GetAllBibliotecasUseCase
{
    private GetAllBibliotecasPort $getAllBibliotecasPort;

    public function __construct(GetAllBibliotecasPort $getAllBibliotecasPort)
    {
        $this->getAllBibliotecasPort = $getAllBibliotecasPort;
    }

    public function execute(GetAllBibliotecasQuery $query): array
    {
        return $this->getAllBibliotecasPort->getAll();
    }
}
