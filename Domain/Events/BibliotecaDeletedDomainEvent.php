<?php

declare(strict_types=1);

require_once __DIR__ . '/EventDomian.php';
require_once __DIR__ . '/../Models/BibliotecaModel.php';

final class BibliotecaDeletedDomainEvent extends DomainEvent
{
    private BibliotecaModel $biblioteca;

    public function __construct(BibliotecaModel $biblioteca)
    {
        parent::__construct('biblioteca.deleted');
        $this->biblioteca = $biblioteca;
    }

    public function biblioteca(): BibliotecaModel
    {
        return $this->biblioteca;
    }

    public function payload(): array
    {
        return array(
            'id' => $this->biblioteca->id()->value(),
        );
    }
}
