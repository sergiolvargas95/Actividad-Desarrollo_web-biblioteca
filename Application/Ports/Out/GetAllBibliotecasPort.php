<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/BibliotecaModel.php';

interface GetAllBibliotecasPort
{
    public function getAll(): array;
}
