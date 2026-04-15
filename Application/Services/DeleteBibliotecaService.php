<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/DeleteBibliotecaUseCase.php';
require_once __DIR__ . '/../Ports/Out/DeleteBibliotecaPort.php';
require_once __DIR__ . '/../Ports/Out/GetBibliotecaByIdPort.php';
require_once __DIR__ . '/Mappers/BibliotecaApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/BibliotecaNotFoundException.php';

final class DeleteBibliotecaService implements DeleteBibliotecaUseCase
{
    private DeleteBibliotecaPort  $deleteBibliotecaPort;
    private GetBibliotecaByIdPort $getBibliotecaByIdPort;

    public function __construct(
        DeleteBibliotecaPort  $deleteBibliotecaPort,
        GetBibliotecaByIdPort $getBibliotecaByIdPort
    ) {
        $this->deleteBibliotecaPort  = $deleteBibliotecaPort;
        $this->getBibliotecaByIdPort = $getBibliotecaByIdPort;
    }

    public function execute(DeleteBibliotecaCommand $command): void
    {
        $id       = BibliotecaApplicationMapper::fromDeleteCommandToBibliotecaId($command);
        $existing = $this->getBibliotecaByIdPort->getById($id);

        if ($existing === null) {
            throw BibliotecaNotFoundException::becauseIdWasNotFound($id->value());
        }

        $this->deleteBibliotecaPort->delete($id);
    }
}
