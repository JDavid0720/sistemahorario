
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
        // Obtiene el valor actual en la columna "nombre_docente" del Excel
        $nombreDocenteExcel = $sheet->getCell('B' . $row)->getValue();

   // Elimina todos los espacios en blanco del nombre del docente en el Excel
$nombreDocenteExcel = str_replace(' ', '', $nombreDocenteExcel);

// Consulta para obtener la clave primaria del docente desde la base de datos
$sqlDocente = "SELECT CI FROM docente WHERE REPLACE(ApellidoNombre, ' ', '') = ?";


        $stmtDocente = $conn->prepare($sqlDocente);
        $stmtDocente->bind_param("s", $nombreDocenteExcel);
        $stmtDocente->execute();
        $stmtDocente->bind_result($clavePrimariaDocente);

        // Si encuentra una coincidencia, actualiza el valor en la columna "nombre_docente" del Excel con la clave primaria
        if ($stmtDocente->fetch()) {
            $sheet->setCellValueExplicit('B' . $row, $clavePrimariaDocente, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        }

        $stmtDocente->close();
          // Obtiene el valor actual en la columna "asignatura" del Excel
          $asignaturaExcel = $sheet->getCell('C' . $row)->getValue();

          // Consulta para obtener la clave primaria de la asignatura desde la base de datos
          $sqlAsignatura = "SELECT Id_asignatura FROM asignaturaa WHERE Nom_asignatura = ?";
          $stmtAsignatura = $conn->prepare($sqlAsignatura);
          $stmtAsignatura->bind_param("s", $asignaturaExcel);
          $stmtAsignatura->execute();
          $stmtAsignatura->bind_result($clavePrimariaAsignatura);
  
          // Si encuentra una coincidencia, actualiza el valor en la columna "asignatura" del Excel con la clave primaria
          if ($stmtAsignatura->fetch()) {
              $sheet->setCellValueExplicit('C' . $row, $clavePrimariaAsignatura, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
          }
  
          $stmtAsignatura->close();
          // Obtiene el valor actual en la columna "ciclo" del Excel
        $cicloExcel = $sheet->getCell('E' . $row)->getValue();

        // Consulta para obtener la clave primaria del ciclo desde la base de datos
        $sqlCiclo = "SELECT Id_cilco FROM cilco WHERE Ciclo= ?";
        $stmtCiclo = $conn->prepare($sqlCiclo);
        $stmtCiclo->bind_param("s", $cicloExcel);
        $stmtCiclo->execute();
        $stmtCiclo->bind_result($clavePrimariaCiclo);

        // Si encuentra una coincidencia, actualiza el valor en la columna "ciclo" del Excel con la clave primaria
        if ($stmtCiclo->fetch()) {
            $sheet->setCellValueExplicit('E' . $row, $clavePrimariaCiclo, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        }

        $stmtCiclo->close();
   // Obtiene el valor actual en la columna "malla" del Excel
   $mallaExcel = $sheet->getCell('F' . $row)->getValue();

   // Consulta para obtener la clave primaria del ciclo desde la base de datos
   $sqlmalla= "SELECT Id_malla FROM malla WHERE Nom_malla = ?";
   $stmtmalla = $conn->prepare($sqlmalla);
   $stmtmalla->bind_param("s", $mallaExcel);
   $stmtmalla->execute();
   $stmtmalla->bind_result($clavePrimariaMalla);

   // Si encuentra una coincidencia, actualiza el valor en la columna "ciclo" del Excel con la clave primaria
   if ($stmtmalla->fetch()) {
       $sheet->setCellValueExplicit('F' . $row, $clavePrimariaMalla, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
   }

   $stmtmalla->close();
        // ... Repite el mismo proceso para las demás tablas

        // Obtiene el valor actual en la columna "tipo_actividad" del Excel
        $tipoActividadExcel = $sheet->getCell('G' . $row)->getValue();

        // Consulta para obtener la clave primaria del tipo de actividad desde la base de datos
        $sqlTipoActividad = "SELECT Id_tipoActividad FROM tipoactividad WHERE Nom_tipoActividad = ?";
        $stmtTipoActividad = $conn->prepare($sqlTipoActividad);
        $stmtTipoActividad->bind_param("s", $tipoActividadExcel);
        $stmtTipoActividad->execute();
        $stmtTipoActividad->bind_result($clavePrimariaTipoActividad);

        // Si encuentra una coincidencia, actualiza el valor en la columna "tipo_actividad" del Excel con la clave primaria
        if ($stmtTipoActividad->fetch()) {
            $sheet->setCellValueExplicit('G' . $row, $clavePrimariaTipoActividad, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        }

        $stmtTipoActividad->close();

        // Obtiene el valor actual en la columna "actividad_especifica" del Excel
        $actividadEspecificaExcel = $sheet->getCell('H' . $row)->getValue();

        // Consulta para obtener la clave primaria de la actividad específica desde la base de datos
        $sqlActividadEspecifica = "SELECT Id_actividadEspecifica FROM actividadespecifica WHERE Nom_actividadEspecifica = ?";
        $stmtActividadEspecifica = $conn->prepare($sqlActividadEspecifica);
        $stmtActividadEspecifica->bind_param("s", $actividadEspecificaExcel);
        $stmtActividadEspecifica->execute();
        $stmtActividadEspecifica->bind_result($clavePrimariaActividadEspecifica);

        // Si encuentra una coincidencia, actualiza el valor en la columna "actividad_especifica" del Excel con la clave primaria
        if ($stmtActividadEspecifica->fetch()) {
            $sheet->setCellValueExplicit('H' . $row, $clavePrimariaActividadEspecifica, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        }

        $stmtActividadEspecifica->close();

        // Obtiene el valor actual en la columna "jornada" del Excel
        $jornadaExcel = $sheet->getCell('I' . $row)->getValue();

        // Consulta para obtener la clave primaria de la jornada desde la base de datos
        $sqlJornada = "SELECT Id_Jornada FROM jornada WHERE Nom_jornada = ?";
        $stmtJornada = $conn->prepare($sqlJornada);
        $stmtJornada->bind_param("s", $jornadaExcel);
        $stmtJornada->execute();
        $stmtJornada->bind_result($clavePrimariaJornada);

        // Si encuentra una coincidencia, actualiza el valor en la columna "jornada" del Excel con la clave primaria
        if ($stmtJornada->fetch()) {
            $sheet->setCellValueExplicit('I' . $row, $clavePrimariaJornada, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        }

        $stmtJornada->close();

        // Utiliza los valores procesados del archivo Excel y realiza las inserciones

    
    // Asigna valores a las variables (ajusta según las columnas de tu tabla)
$ci = $sheet->getCell('B' . $row)->getValue();
$idAsignatura =  $sheet->getCell('C' . $row)->getValue();
$idTipoActividad = $sheet->getCell('G' . $row)->getValue();
$idActividadEspecifica = $sheet->getCell('H' . $row)->getValue();
$idJornada = $sheet->getCell('I' . $row)->getValue();
$ACD = $sheet->getCell('J' . $row)->getValue();
$APE =  $sheet->getCell('K' . $row)->getValue();
$HVIR = $sheet->getCell('L' . $row)->getValue();
$OAD = $sheet->getCell('N' . $row)->getValue();
$HG = $sheet->getCell('O' . $row)->getValue();
$HI = $sheet->getCell('P' . $row)->getValue();
$HVHPP = $sheet->getCell('Q' . $row)->getValue();
  if(!empty($ci))
  {
    // Ejemplo de inserción (ajusta según tu estructura de base de datos y datos procesados)
$sqlInsert = "INSERT INTO actividad (CI, Id_asignatura, Id_tipoActividad, Id_actividadEspecifica, Id_Jornada, ACD, APE, HVIR, OAD, HG, HI, HVHPP) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
";

$stmtInsert = $conn->prepare($sqlInsert);
$stmtInsert = $conn->prepare($sqlInsert);
$stmtInsert->bind_param("ssssssssssss", $ci, $idAsignatura, $idTipoActividad, $idActividadEspecifica, $idJornada, $ACD, $APE, $HVIR, $OAD, $HG, $HI, $HVHPP);

    $stmtInsert->execute();
    $stmtInsert->close();
  }  


    }
        // Muestra mensaje de éxito
        echo '<script>';
        echo 'window.onload = function() {';
        echo 'alert("Carga de datos exitosa");';
        echo 'window.location.href = "../distributibo";'; // Redirige después de cerrar la alerta
        echo '};';
        echo '</script>';
    
        // Redirige a la página principal después de 2 segundos
        header("refresh:2;url=../distributibo");
        exit();
    // Elimina las columnas A y D
$sheet->removeColumn('A');
$sheet->removeColumn('C');
    // Guarda el Excel actualizado
    $rutaUsuario = isset($_POST['ruta']) ? $_POST['ruta'] : __DIR__;
    if (!is_dir($rutaUsuario)) {
        mkdir($rutaUsuario, 0777, true);
    }

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save($rutaUsuario . '/distributivo.xlsx');

        // Muestra la tabla transformada (opcional)
        echo '<div class="container mt-5">';
        echo '<h2 class="mb-4">Datos Transformados</h2>';
        echo '<div class="table-responsive">';
        echo '<table class="table table-bordered">';
        echo '<thead class="thead-dark">';
        echo '<tr>';
        for ($col = 'A'; $col <= 'Q'; $col++) {
            echo '<th scope="col">' . $col . '</th>';
        }
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        for ($row = 1; $row <= $highestRow; $row++) {
            echo '<tr>';
            for ($col = 'A'; $col <= 'Q'; $col++) {
                $value = $sheet->getCell($col . $row)->getValue();
                echo '<td>' . $value . '</td>';
            }
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        echo '</div>';
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