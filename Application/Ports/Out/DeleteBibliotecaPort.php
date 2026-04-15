<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/ValueObjects/BibliotecaId.php';

interface DeleteBibliotecaPort
{
    public function delete(BibliotecaId $id): void;
}
