<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/BibliotecaModel.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/BibliotecaId.php';

interface GetBibliotecaByIdPort
{
    public function getById(BibliotecaId $id): ?BibliotecaModel;
}
