<?php

declare(strict_types=1);

final class BibliotecaPersistenceDto
{
    private string $id;
    private string $nombre;
    private string $direccion;
    private string $ciudad;
    private string $pais;
    private string $telefono;
    private string $email;
    private string $horarioApertura;
    private string $horarioCierre;
    private int    $numLibros;
    private int    $numUsuarios;
    private bool   $esPublica;
    private string $web;

    public function __construct(
        string $id,
        string $nombre,
        string $direccion,
        string $ciudad,
        string $pais,
        string $telefono,
        string $email,
        string $horarioApertura,
        string $horarioCierre,
        int    $numLibros,
        int    $numUsuarios,
        bool   $esPublica,
        string $web
    ) {
        $this->id              = trim($id);
        $this->nombre          = trim($nombre);
        $this->direccion       = trim($direccion);
        $this->ciudad          = trim($ciudad);
        $this->pais            = trim($pais);
        $this->telefono        = trim($telefono);
        $this->email           = trim($email);
        $this->horarioApertura = trim($horarioApertura);
        $this->horarioCierre   = trim($horarioCierre);
        $this->numLibros       = $numLibros;
        $this->numUsuarios     = $numUsuarios;
        $this->esPublica       = $esPublica;
        $this->web             = trim($web);
    }

    public function id(): string              { return $this->id; }
    public function nombre(): string          { return $this->nombre; }
    public function direccion(): string       { return $this->direccion; }
    public function ciudad(): string          { return $this->ciudad; }
    public function pais(): string            { return $this->pais; }
    public function telefono(): string        { return $this->telefono; }
    public function email(): string           { return $this->email; }
    public function horarioApertura(): string { return $this->horarioApertura; }
    public function horarioCierre(): string   { return $this->horarioCierre; }
    public function numLibros(): int          { return $this->numLibros; }
    public function numUsuarios(): int        { return $this->numUsuarios; }
    public function esPublica(): bool         { return $this->esPublica; }
    public function web(): string             { return $this->web; }
}
