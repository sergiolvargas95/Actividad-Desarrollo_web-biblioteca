<?php

declare(strict_types=1);

final class UpdateBibliotecaWebRequest
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
}
