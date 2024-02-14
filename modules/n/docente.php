
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos Transformados</title>
    <!-- Agregamos los estilos de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        <style>
    body {
        padding: 20px;
        background: linear-gradient(to right, #0000FF, #FF0000); /* Degradado de azul a rojo */
        color: #ffffff; /* Texto blanco para contrastar */
    }

    .container {
        background-color: rgba(255, 255, 255, 0.8); /* Fondo blanco semitransparente para mejorar la legibilidad del contenido */
        padding: 20px;
        border-radius: 10px; /* Bordes redondeados */
        color: #000000; /* Texto negro para contrastar en el contenedor */
    }
</style>

    </style>
    

</head>
<body>
<form method="post" enctype="multipart/form-data">
    <button type="submit" name="loadToDatabase" class="btn btn-success">Cargar Datos a la Base de Datos</button>
</form>
<?php

// Ajusta la ruta relativa según la ubicación específica de tu transformador.php
require_once __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Establece la conexión con la base de datos (ajusta las credenciales según tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "utchorario";

// Crea la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        die('Error al subir el archivo.');
    }

    // Procesa el archivo Excel
    $file = $_FILES['file']['tmp_name'];

    $spreadsheet = IOFactory::load($file);
    $sheet = $spreadsheet->getActiveSheet();

    $highestRow = $sheet->getHighestRow();
// Crear un array para rastrear valores únicos
$registrosUnicos = array();

    // Recorre cada fila del Excel
    for ($row = 2; $row <= $highestRow; $row++) {
        // Obtiene el valor actual en la columna "carrera" del Excel
        $carreraExcel = $sheet->getCell('D' . $row)->getValue();

        // Consulta para obtener la clave primaria de la carrera desde la base de datos
        $sql = "SELECT Id_carrera FROM carrera WHERE Nom_carrera = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $carreraExcel);
        $stmt->execute();
        $stmt->bind_result($clavePrimaria);

        // Si encuentra una coincidencia, actualiza el valor en la columna "carrera" del Excel con la clave primaria
        if ($stmt->fetch()) {
            $sheet->setCellValueExplicit('D' . $row, $clavePrimaria, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        }

        $stmt->close();
        // Aquí debes agregar la lógica para cargar los datos a la base de datos
    // Utiliza los valores procesados del archivo Excel y realiza las inserciones

    // Ejemplo de inserción (ajusta según tu estructura de base de datos y datos procesados)
   
    // Asigna valores a las variables (ajusta según las columnas de tu tabla)
    $ci = $sheet->getCell('B' . $row)->getValue();
    $apellidoNombre = $sheet->getCell('C' . $row)->getValue();
    $idCarrera = $sheet->getCell('D' . $row)->getValue();
    $tituloTercer = $sheet->getCell('E' . $row)->getValue();
    $tituloCuarto = $sheet->getCell('F' . $row)->getValue();
    $contrato = $sheet->getCell('G' . $row)->getValue();
    $dedicacion = $sheet->getCell('H' . $row)->getValue();
    $campus = $sheet->getCell('I' . $row)->getValue();
    $actividadComplementaria = $sheet->getCell('J' . $row)->getValue();
    $correo = $sheet->getCell('K' . $row)->getValue();
    
    if (!empty($ci)) {
        $sqlInsert = "INSERT INTO docente (CI, ApellidoNombre, Id_carrera, Titulo_tercer, Titulo_cuarto, Contrato, dedicacion, campus, actividad_complementaria, correo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("ssssssssss", $ci, $apellidoNombre, $idCarrera, $tituloTercer, $tituloCuarto, $contrato, $dedicacion, $campus, $actividadComplementaria, $correo);
    
        $stmtInsert->execute();
        $stmtInsert->close();
    }
    
    }
    // Muestra mensaje de éxito
    echo '<script>';
    echo 'window.onload = function() {';
    echo 'alert("Carga de datos exitosa");';
    echo 'window.location.href = "../teachers";'; // Redirige después de cerrar la alerta
    echo '};';
    echo '</script>';
    // Redirige a la página principal después de 2 segundos
    header("refresh:2;url=../teachers");
    exit();
    
   
} else {
    // Redirige a la página de inicio si se intenta acceder directamente a este script
    header('Location: index.php');
    exit();
}

// Cierra la conexión con la base de datos al final de tu script
$conn->close();


?>
</body>
</html>