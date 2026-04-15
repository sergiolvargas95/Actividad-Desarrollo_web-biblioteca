<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Commands/UpdateBibliotecaCommand.php';
require_once __DIR__ . '/../../../Domain/Models/BibliotecaModel.php';

interface UpdateBibliotecaUseCase
{
    public function execute(UpdateBibliotecaCommand $command): BibliotecaModel;
}
