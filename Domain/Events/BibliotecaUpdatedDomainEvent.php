<?php

declare(strict_types=1);

require_once __DIR__ . '/EventDomian.php';
require_once __DIR__ . '/../Models/BibliotecaModel.php';

final class BibliotecaUpdatedDomainEvent extends DomainEvent
{
    private BibliotecaModel $biblioteca;

    public function __construct(BibliotecaModel $biblioteca)
    {
        parent::__construct('biblioteca.updated');
        $this->biblioteca = $biblioteca;
    }

    public function biblioteca(): BibliotecaModel
    {
        return $this->biblioteca;
    }

    public function payload(): array
    {
        return array(
            'id'               => $this->biblioteca->id()->value(),
            'nombre'           => $this->biblioteca->nombre()->value(),
            'ciudad'           => $this->biblioteca->ciudad()->value(),
            'pais'             => $this->biblioteca->pais()->value(),
            'email'            => $this->biblioteca->email()->value(),
            'esPublica'        => $this->biblioteca->esPublica(),
        );
    }
}
