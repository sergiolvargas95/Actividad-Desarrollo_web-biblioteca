<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Commands/CreateBibliotecaCommand.php';
require_once __DIR__ . '/../../../Domain/Models/BibliotecaModel.php';

interface CreateBibliotecaUseCase
{
    public function execute(CreateBibliotecaCommand $command): BibliotecaModel;
}
