<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Queries/GetBibliotecaByIdQuery.php';
require_once __DIR__ . '/../../../Domain/Models/BibliotecaModel.php';

interface GetBibliotecaByIdUseCase
{
    public function execute(GetBibliotecaByIdQuery $query): BibliotecaModel;
}
