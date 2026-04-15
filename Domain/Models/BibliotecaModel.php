<?php

declare(strict_types=1);

require_once __DIR__ . '/../ValueObjects/BibliotecaId.php';
require_once __DIR__ . '/../ValueObjects/BibliotecaNombre.php';
require_once __DIR__ . '/../ValueObjects/BibliotecaDireccion.php';
require_once __DIR__ . '/../ValueObjects/BibliotecaCiudad.php';
require_once __DIR__ . '/../ValueObjects/BibliotecaPais.php';
require_once __DIR__ . '/../ValueObjects/BibliotecaTelefono.php';
require_once __DIR__ . '/../ValueObjects/BibliotecaEmail.php';
require_once __DIR__ . '/../ValueObjects/BibliotecaHorario.php';
require_once __DIR__ . '/../ValueObjects/BibliotecaWeb.php';

final class BibliotecaModel
{
    private BibliotecaId       $id;
    private BibliotecaNombre   $nombre;
    private BibliotecaDireccion $direccion;
    private BibliotecaCiudad   $ciudad;
    private BibliotecaPais     $pais;
    private BibliotecaTelefono $telefono;
    private BibliotecaEmail    $email;
    private BibliotecaHorario  $horarioApertura;
    private BibliotecaHorario  $horarioCierre;
    private int                $numLibros;
    private int                $numUsuarios;
    private bool               $esPublica;
    private BibliotecaWeb      $web;

    public function __construct(
        BibliotecaId        $id,
        BibliotecaNombre    $nombre,
        BibliotecaDireccion $direccion,
        BibliotecaCiudad    $ciudad,
        BibliotecaPais      $pais,
        BibliotecaTelefono  $telefono,
        BibliotecaEmail     $email,
        BibliotecaHorario   $horarioApertura,
        BibliotecaHorario   $horarioCierre,
        int                 $numLibros,
        int                 $numUsuarios,
        bool                $esPublica,
        BibliotecaWeb       $web
    ) {
        if ($numLibros < 0) {
            throw new InvalidArgumentException('El número de libros no puede ser negativo.');
        }

        if ($numUsuarios < 0) {
            throw new InvalidArgumentException('El número de usuarios no puede ser negativo.');
        }

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

    // Factory: crea una nueva biblioteca con los datos iniciales
    public static function create(
        BibliotecaId        $id,
        BibliotecaNombre    $nombre,
        BibliotecaDireccion $direccion,
        BibliotecaCiudad    $ciudad,
        BibliotecaPais      $pais,
        BibliotecaTelefono  $telefono,
        BibliotecaEmail     $email,
        BibliotecaHorario   $horarioApertura,
        BibliotecaHorario   $horarioCierre,
        int                 $numLibros,
        int                 $numUsuarios,
        bool                $esPublica,
        BibliotecaWeb       $web
    ): self {
        return new self(
            $id, $nombre, $direccion, $ciudad, $pais,
            $telefono, $email, $horarioApertura, $horarioCierre,
            $numLibros, $numUsuarios, $esPublica, $web
        );
    }

    // Getters
    public function id(): BibliotecaId               { return $this->id; }
    public function nombre(): BibliotecaNombre        { return $this->nombre; }
    public function direccion(): BibliotecaDireccion  { return $this->direccion; }
    public function ciudad(): BibliotecaCiudad        { return $this->ciudad; }
    public function pais(): BibliotecaPais            { return $this->pais; }
    public function telefono(): BibliotecaTelefono    { return $this->telefono; }
    public function email(): BibliotecaEmail          { return $this->email; }
    public function horarioApertura(): BibliotecaHorario { return $this->horarioApertura; }
    public function horarioCierre(): BibliotecaHorario   { return $this->horarioCierre; }
    public function numLibros(): int                  { return $this->numLibros; }
    public function numUsuarios(): int                { return $this->numUsuarios; }
    public function esPublica(): bool                 { return $this->esPublica; }
    public function web(): BibliotecaWeb              { return $this->web; }

    // Comportamiento de dominio: inmutable, retorna nuevo objeto
    public function update(
        BibliotecaNombre    $nombre,
        BibliotecaDireccion $direccion,
        BibliotecaCiudad    $ciudad,
        BibliotecaPais      $pais,
        BibliotecaTelefono  $telefono,
        BibliotecaEmail     $email,
        BibliotecaHorario   $horarioApertura,
        BibliotecaHorario   $horarioCierre,
        int                 $numLibros,
        int                 $numUsuarios,
        bool                $esPublica,
        BibliotecaWeb       $web
    ): self {
        return new self(
            $this->id, $nombre, $direccion, $ciudad, $pais,
            $telefono, $email, $horarioApertura, $horarioCierre,
            $numLibros, $numUsuarios, $esPublica, $web
        );
    }
}
