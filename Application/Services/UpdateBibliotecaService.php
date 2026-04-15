<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/UpdateBibliotecaUseCase.php';
require_once __DIR__ . '/../Ports/Out/UpdateBibliotecaPort.php';
require_once __DIR__ . '/../Ports/Out/GetBibliotecaByIdPort.php';
require_once __DIR__ . '/../Ports/Out/GetBibliotecaByNombrePort.php';
require_once __DIR__ . '/Mappers/BibliotecaApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/BibliotecaNotFoundException.php';
require_once __DIR__ . '/../../Domain/Exceptions/BibliotecaAlreadyExistsException.php';
require_once __DIR__ . '/../../Domain/ValueObjects/BibliotecaId.php';
require_once __DIR__ . '/../../Domain/ValueObjects/BibliotecaNombre.php';

final class UpdateBibliotecaService implements UpdateBibliotecaUseCase
{
    private UpdateBibliotecaPort      $updateBibliotecaPort;
    private GetBibliotecaByIdPort     $getBibliotecaByIdPort;
    private GetBibliotecaByNombrePort $getBibliotecaByNombrePort;

    public function __construct(
        UpdateBibliotecaPort      $updateBibliotecaPort,
        GetBibliotecaByIdPort     $getBibliotecaByIdPort,
        GetBibliotecaByNombrePort $getBibliotecaByNombrePort
    ) {
        $this->updateBibliotecaPort      = $updateBibliotecaPort;
        $this->getBibliotecaByIdPort     = $getBibliotecaByIdPort;
        $this->getBibliotecaByNombrePort = $getBibliotecaByNombrePort;
    }

    public function execute(UpdateBibliotecaCommand $command): BibliotecaModel
    {
        $id      = new BibliotecaId($command->getId());
        $current = $this->getBibliotecaByIdPort->getById($id);

        if ($current === null) {
            throw BibliotecaNotFoundException::becauseIdWasNotFound($id->value());
        }

        $newNombre        = new BibliotecaNombre($command->getNombre());
        $withSameNombre   = $this->getBibliotecaByNombrePort->getByNombre($newNombre);

        if ($withSameNombre !== null && !$withSameNombre->id()->equals($id)) {
            throw BibliotecaAlreadyExistsException::becauseNombreAlreadyExists($newNombre->value());
        }

        $updated = BibliotecaApplicationMapper::fromUpdateCommandToModel($command);

        return $this->updateBibliotecaPort->update($updated);
    }
}
