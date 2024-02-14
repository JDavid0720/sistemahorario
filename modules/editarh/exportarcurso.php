<?php
require_once 'vendor/autoload.php';
require_once 'load_data.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Crear un nuevo libro de Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$rowIndex = 3; // Índice de fila inicial

// Iterar sobre todos los cursos
for ($curso = 1; $curso <= 20; $curso++) {
    // Imprimir el nombre del curso
    $sheet->getStyle('A' . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle('A' . $rowIndex)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$sheet->getStyle('A' . $rowIndex)->getFont()->setSize(16);
   $sheet->mergeCells("A$rowIndex:H$rowIndex"); // Fusionar celdas para el nombre del curso
    $sheet->setCellValue('A' . $rowIndex, 'Ingenieria en Sistemas Semestre:' . $curso);
    $rowIndex++; // Incrementar el índice de fila
     
   // $sheet->setCellValue('A' . $rowIndex, 'Curso ' . $curso); // Imprimir el nombre del curso en la columna A
   $weekDays = ['Hora', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

// Establecer los días de la semana en las columnas A hasta la H
for ($i = 0; $i < count($weekDays); $i++) {
    $sheet->setCellValueByColumnAndRow($i + 1, $rowIndex, $weekDays[$i]);

    // Aplicar estilo a las celdas de los días de la semana
    $sheet->getStyleByColumnAndRow($i + 1, $rowIndex)->applyFromArray([
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'color' => ['rgb' => 'd29bfd'], // Cambia el color a tu elección
        ],
        'font' => [
            'bold' => true, // Hace el texto en negrita
        ],
    ]);
}

$carer=$_POST['carrera'];
    // Imprimir las horas y generar las celdas de la tabla
    for ($hora = 7; $hora <= 22; $hora++) {

        $sheet->setCellValue('A' . ($rowIndex + $hora - 6), $hora . ':00'); // Imprimir la hora en la columna A

        // Recorrer los días y generar las celdas de la tabla
        for ($dia = 1; $dia <= 7; $dia++) {
            $horarioData = ''; // Variable para almacenar los datos del horario
            include '../conexion.php';
            // Realizar la consulta SQL para obtener los registros de horario que coincidan con el curso, hora y día actual
            $sql = "SELECT horario.Id_actividad, horario.Id_tiempo, horario.Id_dia, horario.Tipo,
            asignaturaa.Nom_asignatura AS asignatura_nombre,
            carrera.Nom_carrera AS carrera_nombre,
            cilco.Ciclo AS ciclo_nombre,
            cilco.paralelo AS ciclo_paralelo,
            malla.Nom_malla AS malla_nombre,
            tipoactividad.Nom_tipoActividad AS tipoActividadNom,
            actividadespecifica.Nom_actividadEspecifica AS actividadEspecifica_nombre,
            jornada.Nom_jornada AS jornada_nombre
            FROM horario
            INNER JOIN actividad ON horario.Id_actividad = actividad.Id_actividad
            INNER JOIN asignaturaa ON actividad.Id_asignatura = asignaturaa.Id_asignatura
            INNER JOIN carrera ON asignaturaa.Id_carrera = carrera.Id_carrera
            INNER JOIN cilco ON asignaturaa.Id_cilco = cilco.Id_cilco
            INNER JOIN malla ON asignaturaa.Id_malla = malla.Id_malla
            INNER JOIN tipoactividad ON actividad.Id_tipoActividad = tipoactividad.Id_tipoActividad
            INNER JOIN actividadespecifica ON actividad.Id_actividadEspecifica = actividadespecifica.Id_actividadEspecifica
            INNER JOIN jornada ON actividad.Id_Jornada = jornada.Id_Jornada
            WHERE carrera.Nom_carrera = '".$_POST['carrera']."'
            AND cilco.Id_cilco = '$curso'
            AND horario.Id_tiempo = '$hora'
            AND horario.Id_dia = '$dia'
            ORDER BY horario.Id_actividad";
            $result = $conexion->query($sql);

            // Verificar si hay resultados
            if ($result->num_rows > 0) {
                // Mostrar los datos de los registros encontrados
                while ($row = $result->fetch_assoc()) {
                    // Acceder a los campos de la tabla horario
                    $asignatura = $row['asignatura_nombre'];
                    $tp = $row['Tipo'];
                    $carrera = $row['carrera_nombre'];
                    $ciclo = $row['ciclo_nombre'];
                    $paralelo = $row['ciclo_paralelo'];
                    $horarioData .= "-- $asignatura, $tp, $carrera, $ciclo, $paralelo \n";
                }
            } else {
                // No se encontraron registros para esta hora y día
                $horarioData = 'Sin horario';
            }

            // Imprimir los datos del horario en la hoja de cálculo
            $sheet->setCellValueByColumnAndRow($dia + 1, $rowIndex + $hora - 6, $horarioData);

            // Ajustar el tamaño de la celda al contenido
            $sheet->getStyleByColumnAndRow($dia + 1, $rowIndex + $hora - 6)->getAlignment()->setWrapText(true);

            // Establecer estilo para la celda del horario
            $sheet->getStyleByColumnAndRow($dia + 1, $rowIndex + $hora - 6)->applyFromArray([
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => 'e2f0fb'], // Cambia el color a tu elección
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'], // Cambia el color a tu elección
                    ],
                ],
            ]);
        }
    }

    $rowIndex += 22; // Incrementar el índice de fila para el siguiente curso
}

// Establecer el ancho automático de las columnas
$sheet->getColumnDimension('A')->setAutoSize(true);
foreach (range('B', 'H') as $column) {
    $sheet->getColumnDimension($column)->setWidth(25); // Ajusta el ancho de la columna según tus necesidades
}

include '../conexion.php';
// Consulta SQL
$sqlper = "SELECT name FROM `school_periods` WHERE school_period='" . $_POST['periodo']. "'";
$result = $conexion->query($sqlper);

// Verificar si la consulta se realizó con éxito
if ($result === false) {
    die("Error en la consulta: " . $conexion->error);
}

// Inicializar la variable para almacenar el resultado
$nombrePeriodo = '';

// Obtener el resultado de la consulta
if ($result->num_rows > 0) {
    // Suponemos que la consulta solo devuelve una fila, ya que estamos filtrando por un valor específico
    $row = $result->fetch_assoc();
    $nombrePeriodo = $row['name'];
}

print  $nombrePeriodo;
// Guardar el archivo Excel en una ubicación temporal
if($_POST['carrera']=='')
{
    $excelFilePath ='Todos los horarios'.'-'.$nombrePeriodo.'.xlsx';    
}
else
{
    $excelFilePath = $carer.'-'.$nombrePeriodo . '.xlsx';
}

$writer = new Xlsx($spreadsheet);
$writer->save($excelFilePath);

// Establecer las cabeceras de respuesta para la descarga del archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $excelFilePath . '"');
header('Cache-Control: max-age=0');
header('Expires: 0');
header('Pragma: public');

// Enviar el archivo al cliente
readfile($excelFilePath);

// Eliminar el archivo temporal
unlink($excelFilePath);
exit();
