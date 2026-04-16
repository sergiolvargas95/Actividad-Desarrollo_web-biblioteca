<?php

declare(strict_types=1);

final class BibliotecaResponse
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
        $this->id              = $id;
        $this->nombre          = $nombre;
        $this->direccion       = $direccion;
        $this->ciudad          = $ciudad;
        $this->pais            = $pais;
        $this->telefono        = $telefono;
        $this->email           = $email;
        $this->horarioApertura = $horarioApertura;
        $this->horarioCierre   = $horarioCierre;
        $this->numLibros       = $numLibros;
        $this->numUsuarios     = $numUsuarios;
        $this->esPublica       = $esPublica;
        $this->web             = $web;
    }

    public function getId(): string              { return $this->id; }
    public function getNombre(): string          { return $this->nombre; }
    public function getDireccion(): string       { return $this->direccion; }
    public function getCiudad(): string          { return $this->ciudad; }
    public function getPais(): string            { return $this->pais; }
    public function getTelefono(): string        { return $this->telefono; }
    public function getEmail(): string           { return $this->email; }
    public function getHorarioApertura(): string { return $this->horarioApertura; }
    public function getHorarioCierre(): string   { return $this->horarioCierre; }
    public function getNumLibros(): int          { return $this->numLibros; }
    public function getNumUsuarios(): int        { return $this->numUsuarios; }
    public function getEsPublica(): bool         { return $this->esPublica; }
    public function getWeb(): string             { return $this->web; }

    public function toArray(): array
    {
        return array(
            'id'              => $this->id,
            'nombre'          => $this->nombre,
            'direccion'       => $this->direccion,
            'ciudad'          => $this->ciudad,
            'pais'            => $this->pais,
            'telefono'        => $this->telefono,
            'email'           => $this->email,
            'horarioApertura' => $this->horarioApertura,
            'horarioCierre'   => $this->horarioCierre,
            'numLibros'       => $this->numLibros,
            'numUsuarios'     => $this->numUsuarios,
            'esPublica'       => $this->esPublica,
            'web'             => $this->web,
        );
    }
}
