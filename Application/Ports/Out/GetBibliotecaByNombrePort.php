<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/BibliotecaModel.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/BibliotecaNombre.php';

interface GetBibliotecaByNombrePort
{
    public function getByNombre(BibliotecaNombre $nombre): ?BibliotecaModel;
}
