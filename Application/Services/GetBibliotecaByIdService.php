<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/GetBibliotecaByIdUseCase.php';
require_once __DIR__ . '/../Ports/Out/GetBibliotecaByIdPort.php';
require_once __DIR__ . '/Mappers/BibliotecaApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/BibliotecaNotFoundException.php';

final class GetBibliotecaByIdService implements GetBibliotecaByIdUseCase
{
    private GetBibliotecaByIdPort $getBibliotecaByIdPort;

    public function __construct(GetBibliotecaByIdPort $getBibliotecaByIdPort)
    {
        $this->getBibliotecaByIdPort = $getBibliotecaByIdPort;
    }

    public function execute(GetBibliotecaByIdQuery $query): BibliotecaModel
    {
        $id          = BibliotecaApplicationMapper::fromGetByIdQueryToBibliotecaId($query);
        $biblioteca  = $this->getBibliotecaByIdPort->getById($id);

        if ($biblioteca === null) {
            throw BibliotecaNotFoundException::becauseIdWasNotFound($id->value());
        }

        return $biblioteca;
    }
}
