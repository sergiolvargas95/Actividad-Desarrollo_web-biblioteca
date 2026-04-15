<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/BibliotecaModel.php';

interface UpdateBibliotecaPort
{
    public function update(BibliotecaModel $biblioteca): BibliotecaModel;
}
