package com.softclass;

import javax.swing.JOptionPane;
import java.util.ArrayList;
import java.util.List;

class Libro {
    private String titulo;
    private String autor;
    private boolean disponible = true;

    public Libro(String titulo, String autor) {
        this.titulo = titulo;
        this.autor = autor;
    }

    public String getTitulo() { return titulo; }
    public boolean isDisponible() { return disponible; }

    public void prestar() { this.disponible = false; }
    public void devolver() { this.disponible = true; }

    @Override
    public String toString() {
        String estado = disponible ? "Disponible" : "Prestado";
        return titulo + " - " + autor + " (" + estado + ")";
    }
}

class Miembro {
    private String nombre;
    private List<Libro> librosPrestados = new ArrayList<>();

    public Miembro(String nombre) {
        this.nombre = nombre;
    }

    public String getNombre() { return nombre; }
    public List<Libro> getLibrosPrestados() { return librosPrestados; }

    public void agregarLibro(Libro libro) {
        librosPrestados.add(libro);
    }

    public void devolverLibro(Libro libro) {
        librosPrestados.remove(libro);
    }

    @Override
    public String toString() {
        return "Miembro: " + nombre + ", Libros prestados: " + librosPrestados.size();
    }
}

class Biblioteca {
    private String nombre;
    private List<Libro> libros = new ArrayList<>();
    private List<Miembro> miembros = new ArrayList<>();

    public Biblioteca(String nombre) {
        this.nombre = nombre;
    }

    public List<Libro> getLibros() { return libros; }
    public List<Miembro> getMiembros() { return miembros; }

    public void agregarLibro(Libro libro) {
        libros.add(libro);
        JOptionPane.showMessageDialog(null, "Libro agregado: " + libro.getTitulo(), "Libro Agregado", JOptionPane.INFORMATION_MESSAGE);
    }

    public void registrarMiembro(Miembro miembro) {
        miembros.add(miembro);
        JOptionPane.showMessageDialog(null, "Miembro registrado: " + miembro.getNombre(), "Miembro Registrado", JOptionPane.INFORMATION_MESSAGE);
    }

    public Miembro buscarMiembro(String nombre) {
        for (Miembro m : miembros) {
            if (m.getNombre().equalsIgnoreCase(nombre)) {
                return m;
            }
        }
        return null;
    }

    public void prestarLibro(String titulo, Miembro miembro) {
        for (Libro libro : libros) {
            if (libro.getTitulo().equalsIgnoreCase(titulo) && libro.isDisponible()) {
                libro.prestar();
                miembro.agregarLibro(libro);
                JOptionPane.showMessageDialog(null, "Libro '" + titulo + "' prestado a " + miembro.getNombre(), "Préstamo Exitoso", JOptionPane.INFORMATION_MESSAGE);
                return;
            }
        }
        JOptionPane.showMessageDialog(null, "El libro '" + titulo + "' no está disponible o no existe.", "Error de Préstamo", JOptionPane.ERROR_MESSAGE);
    }

    public void devolverLibro(String titulo, Miembro miembro) {
        Libro libroADevolver = null;
        for (Libro libro : miembro.getLibrosPrestados()) {
            if (libro.getTitulo().equalsIgnoreCase(titulo)) {
                libroADevolver = libro;
                break;
            }
        }

        if (libroADevolver != null) {
            libroADevolver.devolver();
            miembro.devolverLibro(libroADevolver);
            JOptionPane.showMessageDialog(null, "Libro '" + titulo + "' devuelto por " + miembro.getNombre(), "Devolución Exitosa", JOptionPane.INFORMATION_MESSAGE);
        } else {
            JOptionPane.showMessageDialog(null, miembro.getNombre() + " no tiene el libro '" + titulo + "' prestado.", "Error de Devolución", JOptionPane.WARNING_MESSAGE);
        }
    }

    public String obtenerCatalogo() {
        if (libros.isEmpty()) {
            return "El catálogo está vacío.";
        }
        StringBuilder sb = new StringBuilder("Catálogo de Libros:\n");
        for (Libro libro : libros) {
            sb.append("- ").append(libro.toString()).append("\n");
        }
        return sb.toString();
    }

    public String obtenerMiembros() {
        if (miembros.isEmpty()) {
            return "No hay miembros registrados.";
        }
        StringBuilder sb = new StringBuilder("Miembros Registrados:\n");
        for (Miembro miembro : miembros) {
            sb.append("- ").append(miembro.toString()).append("\n");
        }
        return sb.toString();
    }
}

public class Main {
    public static void main(String[] args) {

        Biblioteca biblioteca = new Biblioteca("Biblioteca");

        biblioteca.agregarLibro(new Libro("Momo", "Michael Ende"));
        biblioteca.registrarMiembro(new Miembro("Pepito Perez"));

        while (true) {
            String opcionStr = JOptionPane.showInputDialog(null,
                    "**Gestión de Biblioteca**\n\n" +
                            "1. Agregar Libro\n" +
                            "2. Registrar Miembro\n" +
                            "3. Prestar Libro\n" +
                            "4. Devolver Libro\n" +
                            "5. Mostrar Libros\n" +
                            "6. Mostrar Miembros\n" +
                            "7. Salir\n\n" +
                            "Selecciona una opción:",
                    "Menú Principal",
                    JOptionPane.QUESTION_MESSAGE);

            if (opcionStr == null || opcionStr.equals("7")) {
                JOptionPane.showMessageDialog(null, "Gracias por usar la Biblioteca", "Salida", JOptionPane.INFORMATION_MESSAGE);
                break;
            }

            try {
                int opcion = Integer.parseInt(opcionStr);

                switch (opcion) {
                    case 1:
                        agregarLibro(biblioteca);
                        break;
                    case 2:
                        registrarMiembro(biblioteca);
                        break;
                    case 3:
                        prestarLibro(biblioteca);
                        break;
                    case 4:
                        devolverLibro(biblioteca);
                        break;
                    case 5:
                        JOptionPane.showMessageDialog(null, biblioteca.obtenerCatalogo(), "Catálogo de Libros", JOptionPane.PLAIN_MESSAGE);
                        break;
                    case 6:
                        JOptionPane.showMessageDialog(null, biblioteca.obtenerMiembros(), "Miembros Registrados", JOptionPane.PLAIN_MESSAGE);
                        break;
                    default:
                        JOptionPane.showMessageDialog(null, "Opción no válida. Inténtalo de nuevo.", "Error", JOptionPane.ERROR_MESSAGE);
                }
            } catch (NumberFormatException e) {
                JOptionPane.showMessageDialog(null, "Por favor, introduce un número válido.", "Error de Formato", JOptionPane.ERROR_MESSAGE);
            }
        }
    }

    private static void agregarLibro(Biblioteca biblioteca) {
        String titulo = JOptionPane.showInputDialog(null, "Introduce el título del libro:", "Agregar Libro", JOptionPane.QUESTION_MESSAGE);
        if (titulo == null || titulo.trim().isEmpty()) return;

        String autor = JOptionPane.showInputDialog(null, "Introduce el autor de '" + titulo + "':", "Agregar Libro", JOptionPane.QUESTION_MESSAGE);
        if (autor == null || autor.trim().isEmpty()) return;

        biblioteca.agregarLibro(new Libro(titulo.trim(), autor.trim()));
    }

    private static void registrarMiembro(Biblioteca biblioteca) {
        String nombre = JOptionPane.showInputDialog(null, "Introduce el nombre del nuevo miembro:", "Registrar Miembro", JOptionPane.QUESTION_MESSAGE);
        if (nombre == null || nombre.trim().isEmpty()) return;

        biblioteca.registrarMiembro(new Miembro(nombre.trim()));
    }

    private static void prestarLibro(Biblioteca biblioteca) {
        String nombreMiembro = JOptionPane.showInputDialog(null, "Nombre del miembro que presta el libro:", "Prestar Libro", JOptionPane.QUESTION_MESSAGE);
        if (nombreMiembro == null || nombreMiembro.trim().isEmpty()) return;

        Miembro miembro = biblioteca.buscarMiembro(nombreMiembro.trim());

        if (miembro == null) {
            JOptionPane.showMessageDialog(null, "Miembro no encontrado: " + nombreMiembro, "Error", JOptionPane.ERROR_MESSAGE);
            return;
        }

        String tituloLibro = JOptionPane.showInputDialog(null, "Título del libro a prestar a " + miembro.getNombre() + ":", "Prestar Libro", JOptionPane.QUESTION_MESSAGE);
        if (tituloLibro == null || tituloLibro.trim().isEmpty()) return;

        biblioteca.prestarLibro(tituloLibro.trim(), miembro);
    }

    private static void devolverLibro(Biblioteca biblioteca) {
        String nombreMiembro = JOptionPane.showInputDialog(null, "Nombre del miembro que devuelve el libro:", "Devolver Libro", JOptionPane.QUESTION_MESSAGE);
        if (nombreMiembro == null || nombreMiembro.trim().isEmpty()) return;

        Miembro miembro = biblioteca.buscarMiembro(nombreMiembro.trim());

        if (miembro == null) {
            JOptionPane.showMessageDialog(null, "Miembro no encontrado: " + nombreMiembro, "Error", JOptionPane.ERROR_MESSAGE);
            return;
        }

        String tituloLibro = JOptionPane.showInputDialog(null, "Título del libro a devolver por " + miembro.getNombre() + ":", "Devolver Libro", JOptionPane.QUESTION_MESSAGE);
        if (tituloLibro == null || tituloLibro.trim().isEmpty()) return;

        biblioteca.devolverLibro(tituloLibro.trim(), miembro);
    }
}