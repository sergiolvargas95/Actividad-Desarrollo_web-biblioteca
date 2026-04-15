<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/BibliotecaModel.php';

interface SaveBibliotecaPort
{
    public function save(BibliotecaModel $biblioteca): BibliotecaModel;
}
