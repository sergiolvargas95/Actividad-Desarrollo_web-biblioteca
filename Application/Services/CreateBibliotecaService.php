<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/CreateBibliotecaUseCase.php';
require_once __DIR__ . '/../Ports/Out/SaveBibliotecaPort.php';
require_once __DIR__ . '/../Ports/Out/GetBibliotecaByNombrePort.php';
require_once __DIR__ . '/Mappers/BibliotecaApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/BibliotecaAlreadyExistsException.php';
require_once __DIR__ . '/../../Domain/ValueObjects/BibliotecaNombre.php';

final class CreateBibliotecaService implements CreateBibliotecaUseCase
{
    private SaveBibliotecaPort           $saveBibliotecaPort;
    private GetBibliotecaByNombrePort    $getBibliotecaByNombrePort;

    public function __construct(
        SaveBibliotecaPort        $saveBibliotecaPort,
        GetBibliotecaByNombrePort $getBibliotecaByNombrePort
    ) {
        $this->saveBibliotecaPort        = $saveBibliotecaPort;
        $this->getBibliotecaByNombrePort = $getBibliotecaByNombrePort;
    }

    public function execute(CreateBibliotecaCommand $command): BibliotecaModel
    {
        $nombre   = new BibliotecaNombre($command->getNombre());
        $existing = $this->getBibliotecaByNombrePort->getByNombre($nombre);

        if ($existing !== null) {
            throw BibliotecaAlreadyExistsException::becauseNombreAlreadyExists($nombre->value());
        }

        $biblioteca = BibliotecaApplicationMapper::fromCreateCommandToModel($command);

        return $this->saveBibliotecaPort->save($biblioteca);
    }
}
