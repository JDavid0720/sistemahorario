<?php
include_once '../security.php';
include_once '../conexion.php';


require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');


// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Recibir los datos del formulario
$CI=$_POST['CI'];
$id_actividad = $_POST['id_actividad'];
$facultad_extension = $_POST['facultad_extension'];
$asignatura_actividad = $_POST['asignatura_actividad'];
$actividadespecifica = $_POST['actividadespecifica'];
$tipoactividad=$_POST['tipoactividad'];
$jornada = $_POST['jornada'];
$horas_teoricas = $_POST['horas_teoricas'];
$horas_practicas = $_POST['horas_practicas'];
$horas_virtuales = $_POST['horas_virtuales'];
$OAD = $_POST['OAD'];
$horas_grupo = $_POST['horas_grupo'];
$horas_individuales = $_POST['horas_individuales'];
$horas_vinculacion = $_POST['horas_vinculacion'];

// Construir la consulta SQL para insertar los datos en la tabla actividad
$sql = "INSERT INTO actividad (Id_actividad, CI, Id_asignatura, Id_tipoActividad, Id_actividadEspecifica, Id_Jornada, ACD, APE, HVIR, OAD, HG, HI, HVHPP)
        VALUES ('$id_actividad','$CI','$asignatura_actividad','$tipoactividad', '$actividadespecifica', '$jornada', '$horas_teoricas', '$horas_practicas', '$horas_virtuales', '$OAD', '$horas_grupo', '$horas_individuales', '$horas_vinculacion')";

if ($conexion->query($sql) === TRUE) {
  
	$mensaje = "Datos insertados correctamente";
		echo "<script>
				  alert('$mensaje');
				  window.location.href = '../distributibo';
			  </script>";
		exit;
} else {
    echo "Error al insertar datos: " . $conexion->error;
}

// Cerrar la conexión
$conexion->close();
?>