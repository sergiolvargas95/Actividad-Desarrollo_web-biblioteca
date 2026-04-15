<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Commands/DeleteBibliotecaCommand.php';

interface DeleteBibliotecaUseCase
{
    public function execute(DeleteBibliotecaCommand $command): void;
}
