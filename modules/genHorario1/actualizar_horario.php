<?php
// Verificar si se recibieron los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $id_horario = $_POST['id_horario'];
    $hora_inicio = $_POST['hora_inicio'];
    $dia = $_POST['dia'];
    $cedula = $_POST['cedula'];
    $tp = $_POST['tipo'];
    $diasin=$_POST['diasin'];
    $horasin=$_POST['horasin'];
  /* echo '-----------------------';
echo $id_horario;
echo '-----------------------';
echo $hora_inicio;
echo '-----------------------';
echo$dia;
echo '-----------------------';
echo $cedula;
echo '-----------------------';
echo $tp;
echo '-----------------------';
echo $diasin;
echo '-----------------------';
echo $horasin;*/
include '../conexion.php';

$sql = "SELECT COUNT(*) AS count
	FROM horario 
	INNER JOIN actividad ON horario.Id_actividad = actividad.Id_actividad
	INNER JOIN docente ON actividad.CI = docente.CI
	INNER JOIN asignaturaa ON actividad.Id_asignatura = asignaturaa.Id_asignatura 
	INNER JOIN carrera ON asignaturaa.Id_carrera = carrera.Id_carrera
	INNER JOIN cilco ON asignaturaa.Id_cilco = cilco.Id_cilco 
	INNER JOIN malla ON asignaturaa.Id_malla = malla.Id_malla 
	INNER JOIN tipoactividad ON actividad.Id_tipoActividad = tipoactividad.Id_tipoActividad
	INNER JOIN actividadespecifica ON actividad.Id_actividadEspecifica = actividadespecifica.Id_actividadEspecifica
	INNER JOIN jornada ON actividad.Id_Jornada = jornada.Id_Jornada
	WHERE actividad.CI = '$cedula' AND horario.Id_tiempo = '$hora_inicio' AND horario.Id_dia = '$dia'";

$result = $conexion->query($sql);
$row = $result->fetch_assoc();
$count = $row['count'];
$conexion->close();

echo $count;

    // Realizar las validaciones y medidas de seguridad necesarias con los datos recibidos
    // ...

    include '../conexion.php';
    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error en la conexión: " . $conexion->connect_error);
    }

    // Realizar la consulta SQL para actualizar el horario con los nuevos datos
    $sql_update = "UPDATE horario SET Id_tiempo = '$hora_inicio', Id_dia = '$dia' WHERE Id_actividad ='$id_horario'  AND Id_tiempo='$horasin' AND Id_dia='$diasin'";

    // Ejecutar la consulta de actualización
    if ($conexion->query($sql_update) === TRUE) {
        // La actualización fue exitosa, redirige al usuario a la página de horarios o muestra un mensaje de éxito.
        header("Location: index.php?mensaje=Actualización exitosa");
        //exit();
    } else {
        // Si hay un error en la consulta, muestra un mensaje de error o redirige a una página de error.
        header("Location: error.php?mensaje=Error en la actualización: " . $conexion->error);
        exit();
    }

    // Cerrar la conexión a la base de datos
    //$conexion->close();
} else {
    // Si no se recibieron datos por POST, redirige a una página de error.
    header("Location: error.php?mensaje=Error en la solicitud.");
    exit();
}
?>
