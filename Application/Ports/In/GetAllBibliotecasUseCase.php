<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Queries/GetAllBibliotecasQuery.php';
require_once __DIR__ . '/../../../Domain/Models/BibliotecaModel.php';

interface GetAllBibliotecasUseCase
{
    public function execute(GetAllBibliotecasQuery $query): array;
}
