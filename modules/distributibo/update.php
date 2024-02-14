<?php
include_once '../security.php';
include_once '../conexion.php';


require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtén los valores enviados desde el formulario
	$id_actividad = $_POST['id_actividad'];
    $asignatura_actividad = $_POST['asignatura_actividad'];
    $actividadespecifica = $_POST['actividadespecifica'];
    $jornada = $_POST['jornada'];
    $horas_teoricas = $_POST['horas_teoricas'];
    $horas_practicas = $_POST['horas_practicas'];
    $horas_virtuales = $_POST['horas_virtuales'];
    $OAD = $_POST['OAD'];
    $horas_grupo = $_POST['horas_grupo'];
    $horas_individuales = $_POST['horas_individuales'];
    $horas_vinculacion = $_POST['horas_vinculacion'];

    // Construye la consulta SQL de actualización
    $sql = "UPDATE actividad
            SET 
                Id_asignatura = '$asignatura_actividad',
                Id_actividadEspecifica = '$actividadespecifica',
                Id_Jornada = '$jornada',
                ACD = '$horas_teoricas',
                APE = '$horas_practicas',
                HVIR = '$horas_virtuales',
                OAD = '$OAD',
                HG = '$horas_grupo',
                HI = '$horas_individuales',
                HVHPP = '$horas_vinculacion'
            WHERE 
                Id_actividad =$id_actividad";

    // Ejecuta la consulta SQL
    if ($conexion->query($sql) === TRUE) {
		$mensaje = "Actualización exitosa";
		echo "<script>
				  alert('$mensaje');
				  window.location.href = '../distributibo';
			  </script>";
		exit;
    } else {
        echo "Error al actualizar: " . $conexion->error;
    }

}
?>