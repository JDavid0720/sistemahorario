<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tu código actual de procesamiento de archivos Excel

    // Aquí debes agregar la lógica para cargar los datos a la base de datos
    // Utiliza los valores procesados del archivo Excel y realiza las inserciones

    // Ejemplo de inserción (ajusta según tu estructura de base de datos y datos procesados)
    $sqlInsert = "INSERT INTO docente (CI, ApellidoNombre, Id_carrera, Titulo_tercer, Titulo_cuarto, Contrato, dedicacion, campus, actividad_complementaria, correo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("ssssssssss", $ci, $apellidoNombre, $idCarrera, $tituloTercer, $tituloCuarto, $contrato, $dedicacion, $campus, $actividadComplementaria, $correo);

    // Asigna valores a las variables (ajusta según las columnas de tu tabla)
    $ci = $sheet->getCell('A' . $row)->getValue();
    $apellidoNombre = $sheet->getCell('B' . $row)->getValue();
    $idCarrera = $sheet->getCell('C' . $row)->getValue();
    $tituloTercer = $sheet->getCell('D' . $row)->getValue();
    $tituloCuarto = $sheet->getCell('E' . $row)->getValue();
    $contrato = $sheet->getCell('F' . $row)->getValue();
    $dedicacion = $sheet->getCell('G' . $row)->getValue();
    $campus = $sheet->getCell('H' . $row)->getValue();
    $actividadComplementaria = $sheet->getCell('I' . $row)->getValue();
    $correo = $sheet->getCell('J' . $row)->getValue();

    $stmtInsert->execute();
    $stmtInsert->close();
}
?>