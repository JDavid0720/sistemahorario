<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos Transformados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }
    </style>
</head>
<body>

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
        $carreraExcel = $sheet->getCell('C' . $row)->getValue();

        // Consulta para obtener la clave primaria de la carrera desde la base de datos
        $sql = "SELECT Id_carrera FROM carrera WHERE Nom_carrera = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $carreraExcel);
        $stmt->execute();
        $stmt->bind_result($clavePrimaria);

        // Si encuentra una coincidencia, actualiza el valor en la columna "carrera" del Excel con la clave primaria
        if ($stmt->fetch()) {
            $sheet->setCellValueExplicit('C' . $row, $clavePrimaria, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        }

        $stmt->close();
        // Obtiene el valor actual en la columna "Ciclo" del Excel
        $nombreDocenteExcel = $sheet->getCell('D' . $row)->getValue();

   // Elimina todos los espacios en blanco del nombre del docente en el Excel
$nombreDocenteExcel = str_replace(' ', '', $nombreDocenteExcel);

// Consulta para obtener la clave primaria del docente desde la base de datos
// Obtiene el valor actual en la columna "Malla" del Excel
$asignaturaExcel = $sheet->getCell('D' . $row)->getValue();

// Consulta para obtener la clave primaria de la asignatura desde la base de datos
$sqlAsignatura = "SELECT Id_cilco FROM cilco WHERE Ciclo = ?";
$stmtAsignatura = $conn->prepare($sqlAsignatura);
$stmtAsignatura->bind_param("s", $asignaturaExcel);
$stmtAsignatura->execute();
$stmtAsignatura->bind_result($clavePrimariaAsignatura);

// Si encuentra una coincidencia, actualiza el valor en la columna "asignatura" del Excel con la clave primaria
if ($stmtAsignatura->fetch()) {
    $sheet->setCellValueExplicit('D' . $row, $clavePrimariaAsignatura, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
}

$stmtAsignatura->close();
          // Obtiene el valor actual en la columna "Malla" del Excel
          $asignaturaExcel = $sheet->getCell('E' . $row)->getValue();

          // Consulta para obtener la clave primaria de la asignatura desde la base de datos
          $sqlAsignatura = "SELECT Id_malla FROM malla WHERE Nom_malla = ?";
          $stmtAsignatura = $conn->prepare($sqlAsignatura);
          $stmtAsignatura->bind_param("s", $asignaturaExcel);
          $stmtAsignatura->execute();
          $stmtAsignatura->bind_result($clavePrimariaAsignatura);
  
          // Si encuentra una coincidencia, actualiza el valor en la columna "asignatura" del Excel con la clave primaria
          if ($stmtAsignatura->fetch()) {
              $sheet->setCellValueExplicit('E' . $row, $clavePrimariaAsignatura, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
          }
  
          $stmtAsignatura->close();
        // Ejemplo de inserción (ajusta según tu estructura de base de datos y datos procesados)
        
   

    // Asigna valores a las variables (ajusta según las columnas de tu tabla)
 

    $nomAsignatura = $sheet->getCell('A' . $row)->getValue();
    $idCarrera = $sheet->getCell('C' . $row)->getValue();
    $idCiclo = $sheet->getCell('D' . $row)->getValue();
    $idMalla = $sheet->getCell('E' . $row)->getValue();
    if (!empty($nomAsignatura)) {
        $sqlInsert ="INSERT INTO asignaturaa (Id_carrera, Id_cilco, Id_malla, Nom_asignatura) VALUES (?, ?, ?, ?)";

        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("ssss", $idCarrera, $idCiclo, $idMalla, $nomAsignatura);
    $stmtInsert->execute();
    $stmtInsert->close(); 
    }
    }
    // Muestra mensaje de éxito
    echo '<script>';
    echo 'window.onload = function() {';
    echo 'alert("Carga de datos exitosa");';
    echo 'window.location.href = "../subjects";'; // Redirige después de cerrar la alerta
    echo '};';
    echo '</script>';

    // Redirige a la página principal después de 2 segundos
    header("refresh:2;url=../subjects");
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