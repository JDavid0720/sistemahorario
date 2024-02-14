<?php
require 'vendor/autoload.php';
require_once 'load_data.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Crear un nuevo libro de Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Establecer estilo para los encabezados de columna
$headerStyle = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'color' => ['rgb' => '92c5fc'], // Cambia el color a tu elección
    ],
    'font' => [
        'bold' => true,
        'color' => ['rgb' => '000000'], // Cambia el color a tu elección
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['rgb' => '000000'], // Cambia el color a tu elección
        ],
    ],
];
$headerStyle1 = [
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'color' => ['rgb' => 'ffffff'], // Cambia el color a tu elección
    ],
    'font' => [
        'bold' => true,
        'color' => ['rgb' => '000000'], // Cambia el color a tu elección
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['rgb' => '000000'], // Cambia el color a tu elección
        ],
    ],
];

if($_POST['radiobtn']=='' ||$_POST['radiobtn']=='docente'  ){

// Obtener la cantidad de docentes
$totalDocentes = count($_SESSION["Id_actividad"]);
$ci_anterior = '';
// Iterar sobre cada docente
$rowIndex = 1; // Índice de fila actual, comenzando desde la fila 1
for ($i = 0; $i < $totalDocentes; $i++) {
    include '../conexion.php';
        // Realizar la consulta SQL para obtener la información del docente
        $ci = $_SESSION['CI'][$i];
        $sql = "SELECT docente.ApellidoNombre, docente.Titulo_cuarto, docente.dedicacion, docente.Contrato, carrera.Nom_carrera AS carrera_nombre FROM docente INNER JOIN carrera ON carrera.Id_carrera = docente.Id_carrera WHERE docente.CI = '" . mysqli_real_escape_string($conexion, $ci) . "'";
        $result = mysqli_query($conexion, $sql);
        $row = mysqli_fetch_assoc($result);
        $nombreDocente = $row['ApellidoNombre'];
        $tituloCuarto = $row['Titulo_cuarto'];
        $tipologia = $row['dedicacion'];
        $contrato = $row['Contrato'];
        $carrera = $row['carrera_nombre'];
    $currentCI = $_SESSION["CI"][$i];
    if ( $_POST['carrera']=='' )
    {
    if ($currentCI != $ci_anterior) {
        $ci_anterior = $currentCI;
        

        // Imprimir la información del docente en el encabezado
        $rowIndex++;
        $sheet->setCellValue('A' . $rowIndex, 'CI:');
        $sheet->setCellValue('B' . $rowIndex, $ci);
        $rowIndex++;
        $sheet->setCellValue('C' . $rowIndex-1, 'Nombre:');
        $sheet->setCellValue('D' . $rowIndex-1, $nombreDocente);
        $sheet->mergeCells('D' . $rowIndex-1 . ':E' . $rowIndex-1);
        $rowIndex++;
        $sheet->setCellValue('F' . $rowIndex-2, 'Tipologia:');
        $sheet->setCellValue('G' . $rowIndex-2, $tipologia);
        $rowIndex++;
        $sheet->setCellValue('A' . $rowIndex, 'Titulo Cuarto:');
        $sheet->setCellValue('B' . $rowIndex, $tituloCuarto);
        $sheet->mergeCells('B' . $rowIndex . ':E' . $rowIndex);
        $rowIndex++;
        $sheet->setCellValue('F' . $rowIndex-1, 'Dedicacion:');
        $sheet->setCellValue('G' . $rowIndex-1, $tipologia);
        $rowIndex++;
        $sheet->setCellValue('A' . $rowIndex, 'Contrato:');
        $sheet->setCellValue('B' . $rowIndex, $contrato);
        $rowIndex++;
        $sheet->setCellValue('F' . $rowIndex-1, 'Carrera:');
        $sheet->setCellValue('G' . $rowIndex-1, $carrera);
        $sheet->mergeCells('G' . $rowIndex-1 . ':H' . $rowIndex-1); 

        // Establecer estilo para el encabezado del docente
        $sheet->getStyle('A' . ($rowIndex - 7) . ':H' . $rowIndex)->applyFromArray($headerStyle1);

        // Generar las filas de la tabla de horarios
        $rowIndex++;
        $sheet->setCellValue('A' . $rowIndex, 'Hora');
        $days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        $columnIndex = 2;
        foreach ($days as $day) {
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $day);
            $sheet->getStyleByColumnAndRow($columnIndex, $rowIndex)->applyFromArray($headerStyle);
            $columnIndex++;
        }
        $rowIndex++;

       
        for ($hora = 7; $hora <= 22; $hora++) {
            $sheet->setCellValue('A' . $rowIndex, ($hora < 10 ? "0" : "") . $hora . ':00');

            for ($dia = 1; $dia <= 7; $dia++) {
                $horarioData = ''; // Variable para almacenar los datos del horario

                // Realizar la consulta SQL para obtener los registros de horario que coincidan con la hora y el día actual
                $sql = "SELECT horario.Id_actividad,horario.Id_tiempo,horario.Id_dia,horario.Tipo,actividad.Id_actividad,actividad.CI,actividad.ACD,actividad.APE,actividad.HVIR,actividad.OAD,actividad.HG,
                    actividad.HI,actividad.HVHPP, 
                    asignaturaa.Nom_asignatura As asignatura_nombre, 
                    carrera.Nom_carrera As carrera_nombre, 
                    cilco.Ciclo AS ciclo_nombre,
                    cilco.paralelo AS ciclo_paralelo ,
                    malla.Nom_malla AS malla_nombre, 
                    tipoactividad.Nom_tipoActividad AS tipoActividadNom, 
                    actividadespecifica.Nom_actividadEspecifica AS actividadEspecifica_nombre,  
                    jornada.Nom_jornada AS jornada_nombre
                    FROM horario 
                    INNER JOIN actividad ON horario.Id_actividad = actividad.Id_actividad
                    INNER JOIN docente ON actividad.CI=docente.CI
                    INNER JOIN asignaturaa ON actividad.Id_asignatura = asignaturaa.Id_asignatura 
                    INNER JOIN carrera ON asignaturaa.Id_carrera = carrera.Id_carrera
                    INNER JOIN cilco ON asignaturaa.Id_cilco = cilco.Id_cilco 
                    INNER JOIN malla ON asignaturaa.Id_malla = malla.Id_malla 
                    INNER JOIN tipoactividad ON actividad.Id_tipoActividad = tipoactividad.Id_tipoActividad
                    INNER JOIN actividadespecifica ON actividad.Id_actividadEspecifica = actividadespecifica.Id_actividadEspecifica
                    INNER JOIN jornada ON actividad.Id_Jornada = jornada.Id_Jornada
                    WHERE actividad.CI='$currentCI' AND horario.Id_tiempo='$hora' AND horario.Id_dia='$dia'
                    ORDER BY horario.Id_actividad";
                $result = $conexion->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $asignatura = $row['asignatura_nombre'];
                        $tp = $row['Tipo'];
                        $carrera = $row['carrera_nombre'];
                        $ciclo = $row['ciclo_nombre'];
                        $paralelo = $row['ciclo_paralelo'];
                        $horarioData .= "-- $asignatura, $tp, $carrera, $ciclo, $paralelo \n";
                    }
                } else {
                    $horarioData = ' ';
                }

                // Imprimir los datos del horario en la hoja de cálculo
                $cell = $sheet->getCellByColumnAndRow($dia + 1, $rowIndex);
                $cell->setValue($horarioData);

                // Ajustar el tamaño de la celda al contenido
                $sheet->getStyle($cell->getCoordinate())->getAlignment()->setWrapText(true);

                // Establecer estilo para la celda del horario
                $sheet->getStyle($cell->getCoordinate())->applyFromArray([
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

            $rowIndex++; // Incrementar el índice de fila para la siguiente hora
        }

        // Ajustar el tamaño de la fila al contenido
        $sheet->getRowDimension($rowIndex - 1)->setRowHeight(-1);
    

    }
}
elseif($carrera==$_POST['carrera'])
{
    if ($currentCI != $ci_anterior) {
        $ci_anterior = $currentCI;
        

        // Imprimir la información del docente en el encabezado
        $rowIndex++;
        $sheet->setCellValue('A' . $rowIndex, 'CI:');
        $sheet->setCellValue('B' . $rowIndex, $ci);
        $rowIndex++;
        $sheet->setCellValue('C' . $rowIndex-1, 'Nombre:');
        $sheet->setCellValue('D' . $rowIndex-1, $nombreDocente);
        $sheet->mergeCells('D' . $rowIndex-1 . ':E' . $rowIndex-1);
        $rowIndex++;
        $sheet->setCellValue('F' . $rowIndex-2, 'Tipologia:');
        $sheet->setCellValue('G' . $rowIndex-2, $tipologia);
        $rowIndex++;
        $sheet->setCellValue('A' . $rowIndex, 'Titulo Cuarto:');
        $sheet->setCellValue('B' . $rowIndex, $tituloCuarto);
        $sheet->mergeCells('B' . $rowIndex . ':E' . $rowIndex);
        $rowIndex++;
        $sheet->setCellValue('F' . $rowIndex-1, 'Dedicacion:');
        $sheet->setCellValue('G' . $rowIndex-1, $tipologia);
        $rowIndex++;
        $sheet->setCellValue('A' . $rowIndex, 'Contrato:');
        $sheet->setCellValue('B' . $rowIndex, $contrato);
        $rowIndex++;
        $sheet->setCellValue('F' . $rowIndex-1, 'Carrera:');
        $sheet->setCellValue('G' . $rowIndex-1, $carrera);
        $sheet->mergeCells('G' . $rowIndex-1 . ':H' . $rowIndex-1); 

        // Establecer estilo para el encabezado del docente
        $sheet->getStyle('A' . ($rowIndex - 7) . ':H' . $rowIndex)->applyFromArray($headerStyle1);

        // Generar las filas de la tabla de horarios
        $rowIndex++;
        $sheet->setCellValue('A' . $rowIndex, 'Hora');
        $days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        $columnIndex = 2;
        foreach ($days as $day) {
            $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $day);
            $sheet->getStyleByColumnAndRow($columnIndex, $rowIndex)->applyFromArray($headerStyle);
            $columnIndex++;
        }
        $rowIndex++;

       
        for ($hora = 7; $hora <= 22; $hora++) {
            $sheet->setCellValue('A' . $rowIndex, ($hora < 10 ? "0" : "") . $hora . ':00');

            for ($dia = 1; $dia <= 7; $dia++) {
                $horarioData = ''; // Variable para almacenar los datos del horario

                // Realizar la consulta SQL para obtener los registros de horario que coincidan con la hora y el día actual
                $sql = "SELECT horario.Id_actividad,horario.Id_tiempo,horario.Id_dia,horario.Tipo,actividad.Id_actividad,actividad.CI,actividad.ACD,actividad.APE,actividad.HVIR,actividad.OAD,actividad.HG,
                    actividad.HI,actividad.HVHPP, 
                    asignaturaa.Nom_asignatura As asignatura_nombre, 
                    carrera.Nom_carrera As carrera_nombre, 
                    cilco.Ciclo AS ciclo_nombre,
                    cilco.paralelo AS ciclo_paralelo ,
                    malla.Nom_malla AS malla_nombre, 
                    tipoactividad.Nom_tipoActividad AS tipoActividadNom, 
                    actividadespecifica.Nom_actividadEspecifica AS actividadEspecifica_nombre,  
                    jornada.Nom_jornada AS jornada_nombre
                    FROM horario 
                    INNER JOIN actividad ON horario.Id_actividad = actividad.Id_actividad
                    INNER JOIN docente ON actividad.CI=docente.CI
                    INNER JOIN asignaturaa ON actividad.Id_asignatura = asignaturaa.Id_asignatura 
                    INNER JOIN carrera ON asignaturaa.Id_carrera = carrera.Id_carrera
                    INNER JOIN cilco ON asignaturaa.Id_cilco = cilco.Id_cilco 
                    INNER JOIN malla ON asignaturaa.Id_malla = malla.Id_malla 
                    INNER JOIN tipoactividad ON actividad.Id_tipoActividad = tipoactividad.Id_tipoActividad
                    INNER JOIN actividadespecifica ON actividad.Id_actividadEspecifica = actividadespecifica.Id_actividadEspecifica
                    INNER JOIN jornada ON actividad.Id_Jornada = jornada.Id_Jornada
                    WHERE actividad.CI='$currentCI' AND horario.Id_tiempo='$hora' AND horario.Id_dia='$dia'
                    ORDER BY horario.Id_actividad";
                $result = $conexion->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $asignatura = $row['asignatura_nombre'];
                        $tp = $row['Tipo'];
                        $carrera = $row['carrera_nombre'];
                        $ciclo = $row['ciclo_nombre'];
                        $paralelo = $row['ciclo_paralelo'];
                        $horarioData .= "-- $asignatura, $tp, $carrera, $ciclo, $paralelo \n";
                    }
                } else {
                    $horarioData = ' ';
                }

                // Imprimir los datos del horario en la hoja de cálculo
                $cell = $sheet->getCellByColumnAndRow($dia + 1, $rowIndex);
                $cell->setValue($horarioData);

                // Ajustar el tamaño de la celda al contenido
                $sheet->getStyle($cell->getCoordinate())->getAlignment()->setWrapText(true);

                // Establecer estilo para la celda del horario
                $sheet->getStyle($cell->getCoordinate())->applyFromArray([
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

            $rowIndex++; // Incrementar el índice de fila para la siguiente hora
        }

        // Ajustar el tamaño de la fila al contenido
        $sheet->getRowDimension($rowIndex - 1)->setRowHeight(-1);
    

    }
}

}
}
elseif($_POST['radiobtn']=='cursos')
{
    
$rowIndex = 3; // Índice de fila inicial

// Iterar sobre todos los cursos
for ($curso = 1; $curso <= 20; $curso++) {
    $sqlcont="SELECT COUNT(*) AS cantidad_filas
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
    AND cilco.Id_cilco = '$curso'";
    
// Ejecutar la consulta y obtener el resultado
$resultado = mysqli_query($conexion, $sqlcont);
if ($resultado) {
    $fila = mysqli_fetch_assoc($resultado);
    $cantidadFilas = $fila['cantidad_filas'];
     // Imprimir el nombre del curso
     $sheet->getStyle('A' . $rowIndex)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
     $sheet->getStyle('A' . $rowIndex)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
     $sheet->getStyle('A' . $rowIndex)->getFont()->setSize(16);
        $sheet->mergeCells("A$rowIndex:H$rowIndex"); // Fusionar celdas para el nombre del curso
    if ($cantidadFilas != 0) {
        $sql = "SELECT Ciclo, paralelo FROM cilco WHERE Id_cilco = '$curso'";

// Ejecutar la consulta
$resultado = mysqli_query($conexion, $sql);

// Verificar si la consulta se ejecutó correctamente
if ($resultado) {
    // Obtener los valores del resultado
    $fila = mysqli_fetch_assoc($resultado);

    // Verificar si se encontró un registro
    if ($fila) {
        // Guardar los valores en variables separadas (opcional)
        $ciclo = $fila['Ciclo'];
        $paralelo = $fila['paralelo'];
        $sheet->setCellValue('A' . $rowIndex, $_POST['carrera'] . ' ' . strtoupper($ciclo) . ' "' . strtoupper($paralelo).'"');

        // O simplemente guardar el resultado completo en una variable
        $resultadoConsulta = $fila;

        // Hacer algo con los valores obtenidos
        // Por ejemplo, imprimirlos:
        //echo "Ciclo: " . $fila['Ciclo'] . "<br>";
        //echo "Paralelo: " . $fila['paralelo'] . "<br>";
    } else {
        // Manejar el caso cuando no se encontró ningún registro
        //echo "No se encontró ningún registro.";
    }

    
} else {
    // Manejar el caso en que la consulta no se ejecutó correctamente
    echo "Error en la consulta: " . mysqli_error($conexion);
}
   
    
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
                    $horarioData .= "$asignatura \n";
                    $horarioData .= "$tp \n";
                    $horarioData .= "$carrera \n";
                    $horarioData .= "$ciclo \n";
                    $horarioData .="$paralelo \n";    
                }
            } else {
                // No se encontraron registros para esta hora y día
                //$horarioData = 'Sin horario';
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
}

}

}

// Establecer el ancho de la columna A
$columnAWidth = 12; // Ancho en píxeles
$sheet->getColumnDimension('A')->setWidth($columnAWidth);

// Establecer el ancho automático de las columnas restantes
$columnWidth = 25; // Ancho en píxeles
foreach (range('B', 'H') as $column) {
    $sheet->getColumnDimension($column)->setWidth($columnWidth);


}
include '../conexion.php';
// Consulta SQL
$sqlper = "SELECT name FROM `school_periods` WHERE school_period='" . $_POST['periodo'] . "'";
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


// Guardar el archivo Excel en una ubicación temporal
if($_POST['carrera']=='')
{
    $excelFilePath ='Todos los horarios'.'-'.$nombrePeriodo.'.xlsx';    
}
elseif($_POST['radiobtn']=='docente'||$_POST['radiobtn']=='')
{
    $excelFilePath = 'Horarios Docentes'.$_POST['carrera'].'-'.$nombrePeriodo . '.xlsx';
}
elseif($_POST['radiobtn']=='cursos')
{
    $excelFilePath = 'Horarios cursos '.$_POST['carrera'].'-'.$nombrePeriodo . '.xlsx';    
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
?>
