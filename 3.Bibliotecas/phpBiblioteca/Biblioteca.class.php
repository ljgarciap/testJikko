<?php

class Libro {
    public $id;
    public $titulo;
    public $autor;
    public $disponible;

    public function __construct($titulo, $autor, $id = null, $disponible = true) {
        $this->id = $id ?? uniqid();
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->disponible = $disponible;
    }

    public function __toArray() {
        return (array)$this;
    }
}

class Miembro {
    public $id;
    public $nombre;
    public $librosPrestados;

    public function __construct($nombre, $id = null, $librosPrestados = []) {
        $this->id = $id ?? uniqid();
        $this->nombre = $nombre;
        $this->librosPrestados = $librosPrestados;
    }

    public function __toArray() {
        return (array)$this;
    }
}

class Biblioteca {
    private $archivo_datos = 'biblioteca_data.json';
    private $libros = [];
    private $miembros = [];

    public function __construct() {
        $this->cargarDatos();
    }

    private function inicializarDatos() {
        return [
            'libros' => [
                (new Libro('La historia interminable', 'Michael Ende', 'l1'))->__toArray()
            ],
            'miembros' => [
                (new Miembro('Pepito Pérez', 'm1'))->__toArray()
            ]
        ];
    }

    private function cargarDatos() {
        if (file_exists($this->archivo_datos)) {
            $data = json_decode(file_get_contents($this->archivo_datos), true);
            if ($data === null) $data = $this->inicializarDatos();
        } else {
            $data = $this->inicializarDatos();
        }

        foreach ($data['libros'] as $l) {
            $this->libros[] = new Libro($l['titulo'], $l['autor'], $l['id'], $l['disponible']);
        }
        foreach ($data['miembros'] as $m) {
            $this->miembros[] = new Miembro($m['nombre'], $m['id'], $m['librosPrestados'] ?? []);
        }
        $this->guardarDatos();
    }

    private function guardarDatos() {
        $data = [
            'libros' => array_map(function($l) { return $l->__toArray(); }, $this->libros),
            'miembros' => array_map(function($m) { return $m->__toArray(); }, $this->miembros),
        ];
        file_put_contents($this->archivo_datos, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function agregarLibro($titulo, $autor) {
        $libro = new Libro($titulo, $autor);
        $this->libros[] = $libro;
        $this->guardarDatos();
        return "Libro agregado: {$titulo}";
    }

    public function registrarMiembro($nombre) {
        $miembro = new Miembro($nombre);
        $this->miembros[] = $miembro;
        $this->guardarDatos();
        return "Miembro registrado: {$nombre}";
    }

    public function prestarLibro($libro_id, $miembro_id) {
        $libro = $this->obtenerLibroPorId($libro_id);
        $miembro = $this->obtenerMiembroPorId($miembro_id);

        if ($libro && $miembro && $libro->disponible) {
            $libro->disponible = false;
            $miembro->librosPrestados[] = $libro_id;
            $this->guardarDatos();
            return "Libro prestado exitosamente";
        }
        return "ERROR: No se pudo realizar el préstamo.";
    }

    public function devolverLibro($libro_id, $miembro_id) {
        $libro = $this->obtenerLibroPorId($libro_id);
        $miembro = $this->obtenerMiembroPorId($miembro_id);

        if ($libro && $miembro) {
            $libro->disponible = true;
            $miembro->librosPrestados = array_values(array_filter($miembro->librosPrestados, function($id) use ($libro_id) {
                return $id !== $libro_id;
            }));
            $this->guardarDatos();
            return "Libro devuelto exitosamente";
        }
        return "ERROR: No se pudo realizar la devolución.";
    }

    public function obtenerLibros() {
        return $this->libros;
    }

    public function obtenerMiembros() {
        return $this->miembros;
    }

    public function obtenerLibroPorId($id) {
        foreach ($this->libros as $libro) {
            if ($libro->id === $id) return $libro;
        }
        return null;
    }

    public function obtenerMiembroPorId($id) {
        foreach ($this->miembros as $miembro) {
            if ($miembro->id === $id) return $miembro;
        }
        return null;
    }
}
?>