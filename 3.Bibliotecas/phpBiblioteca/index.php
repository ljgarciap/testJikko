<?php
require_once 'Biblioteca.class.php';

$biblioteca_sistema = new Biblioteca();
$mensaje_alerta = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregar_libro'])) {
        $mensaje_alerta = $biblioteca_sistema->agregarLibro($_POST['titulo'], $_POST['autor']);
    }
    
    elseif (isset($_POST['registrar_miembro'])) {
        $mensaje_alerta = $biblioteca_sistema->registrarMiembro($_POST['nombre_miembro']);
    }
    
    elseif (isset($_POST['prestar_libro'])) {
        $mensaje_alerta = $biblioteca_sistema->prestarLibro($_POST['libro_prestar'], $_POST['miembro_prestar']);
    }
    
    elseif (isset($_POST['devolver_libro'])) {
        $mensaje_alerta = $biblioteca_sistema->devolverLibro($_POST['libro_devolver'], $_POST['miembro_devolver']);
    }

    header("Location: index.php?msg=" . urlencode($mensaje_alerta));
    exit;
}

if (isset($_GET['msg']) && !empty($_GET['msg'])) {
    $mensaje_alerta = htmlspecialchars($_GET['msg']);
}

$libros = $biblioteca_sistema->obtenerLibros();
$miembros = $biblioteca_sistema->obtenerMiembros();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Biblioteca</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .tab { margin-bottom: 20px; border: 1px solid #eee; padding: 15px; border-radius: 5px; }
        .list-item { border: 1px solid #ccc; padding: 10px; margin: 5px 0; }
        .prestado { background: #ffe6e6; }
    </style>
</head>
<body>
    <h1>Biblioteca</h1>

    <?php if (!empty($mensaje_alerta)): ?>
        <script>alert("<?php echo $mensaje_alerta; ?>");</script>
    <?php endif; ?>

    <div class="tab">
        <h2>Agregar Libro</h2>
        <form method="POST"><input type="text" name="titulo" placeholder="Título" required><input type="text" name="autor" placeholder="Autor" required><button type="submit" name="agregar_libro">Agregar</button></form>
    </div>
    
    <div class="tab">
        <h2>Registrar Miembro</h2>
        <form method="POST"><input type="text" name="nombre_miembro" placeholder="Nombre" required><button type="submit" name="registrar_miembro">Registrar</button></form>
    </div>
    
    <div class="tab">
        <h2>Prestar Libro</h2>
        <form method="POST">
            <select name="libro_prestar" required>
                <option value="">Seleccionar libro</option>
                <?php foreach ($libros as $libro): ?>
                    <?php if ($libro->disponible): ?>
                        <option value="<?php echo $libro->id; ?>"><?php echo $libro->titulo; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
            <select name="miembro_prestar" required>
                <option value="">Seleccionar miembro</option>
                <?php foreach ($miembros as $miembro): ?>
                    <option value="<?php echo $miembro->id; ?>"><?php echo $miembro->nombre; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" name="prestar_libro">Prestar</button>
        </form>
    </div>
    
    <div class="tab">
        <h2>Devolver Libro</h2>
        <form method="POST" id="devolverForm">
            <select name="miembro_devolver" required onchange="cargarLibrosPrestadosSimple(this.value)">
                <option value="">Seleccionar miembro</option>
                <?php foreach ($miembros as $miembro): ?>
                    <option value="<?php echo $miembro->id; ?>"><?php echo $miembro->nombre; ?></option>
                <?php endforeach; ?>
            </select>
            <select name="libro_devolver" id="libroDevolverSelect" required>
                <option value="">Seleccionar libro</option>
            </select>
            <button type="submit" name="devolver_libro">Devolver</button>
        </form>
    </div>

    <hr>

    <div class="tab">
        <h2>Libros</h2>
        <?php foreach ($libros as $libro): ?>
            <?php $estado = $libro->disponible ? 'Disponible' : 'Prestado'; ?>
            <?php $clase = $libro->disponible ? '' : 'prestado'; ?>
            <div class="list-item <?php echo $clase; ?>">
                <strong><?php echo $libro->titulo; ?></strong> - <?php echo $libro->autor; ?> (<?php echo $estado; ?>)
            </div>
        <?php endforeach; ?>
    </div>
    
    <div class="tab">
        <h2>Miembros</h2>
        <?php foreach ($miembros as $miembro): ?>
            <div class="list-item">
                <strong><?php echo $miembro->nombre; ?></strong> - Libros prestados: <?php echo count($miembro->librosPrestados); ?>
            </div>
        <?php endforeach; ?>
    </div>

<script>
    const bibliotecaDatos = <?php echo json_encode(['libros' => $libros, 'miembros' => $miembros]); ?>;

    function cargarLibrosPrestadosSimple(miembroId) {
        const selectLibro = document.getElementById('libroDevolverSelect');
        selectLibro.innerHTML = '<option value="">Seleccionar libro</option>';

        const miembro = bibliotecaDatos.miembros.find(m => m.id === miembroId);
        
        if (miembro && miembro.librosPrestados && miembro.librosPrestados.length > 0) {
            miembro.librosPrestados.forEach(libroId => {
                const libro = bibliotecaDatos.libros.find(l => l.id === libroId);
                if (libro) {
                    selectLibro.innerHTML += `<option value="${libro.id}">${libro.titulo}</option>`;
                }
            });
        }
    }
</script>
</body>
</html>