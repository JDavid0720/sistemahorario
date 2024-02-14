<?php
include_once '../security.php';
include_once '../conexion.php';
include_once '../notif_info_msgbox.php';

require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');

$_POST['txtCI'] = trim($_POST['txtCI']);

if (empty($_POST['txtCI'])) {
	header('Location: /');
	exit();
}
if ($_POST['txtCI'] == '') {
	Error('Ingrese un ID correcto.');
	header('Location: /modules/teachers');
	exit();
}

$sql = "SELECT * FROM docente WHERE CI = '" . $_POST['txtCI'] . "'";

if ($result = $conexion->query($sql)) {
	if ($row = mysqli_fetch_array($result)) {
		Error('Este docente ya esta registrado');
		header('Location: /modules/teachers');
		exit();
	} else {
		$date = date('Y-m-d H:i:s');
		$carrera =trim($_POST['selectlevelstudies']);


		$sql_insert_user = "INSERT INTO users(user, pass, permissions, image, created_at) VALUES('" . trim($_POST['txtCI']) . "', '" . trim($_POST['txtCI']) . "', 'teacher', 'user.png','" . $date . "')";

		if (mysqli_query($conexion, $sql_insert_user)) {
			$sql_insert_teacher = "INSERT INTO docente(CI,ApellidoNombre, Id_carrera,Titulo_tercer, Titulo_cuarto, Contrato,dedicacion, campus,actividad_complementaria) VALUES('" . trim($_POST['txtCI']) . "', '" . trim($_POST['txtname']) . "', '" . $carrera . "', '" . trim($_POST['txtT3']) . "', '" . trim($_POST['txtT4']) . "', '" . trim($_POST['selecContrato']) . "', '" . trim($_POST['selecDedicacion']) . "', '" . trim($_POST['selecCampus']) . "', '" . trim($_POST['txtactividad']) . "')";
			
			if (mysqli_query($conexion, $sql_insert_teacher)) {
				Info('Personal docente agregado.');
			} else {
				$sql_delete_users = "DELETE FROM users WHERE user = '" . trim($_POST['txtCI']) . "'";

				if (mysqli_query($conexion, $sql_delete_users)) {
					Error('Error al guardar.');
				}
			}
		} else {
			Error('Error al guardar.');
		}
		
					// Realiza la consulta SQL
					$sql = "SELECT Id_actividad FROM actividad ORDER BY Id_actividad DESC, CI DESC LIMIT 1";
					$result = mysqli_query($conexion, $sql); // Reemplaza "conexion" por el nombre de tu conexión

					// Verifica si la consulta se realizó correctamente
					if ($result) {
						// Obtiene el resultado como un arreglo asociativo
						$row = mysqli_fetch_assoc($result);

						// Guarda el valor en una variable
						$ultimaActividadId = $row['Id_actividad']+1;

						// Cierra el resultado
						mysqli_free_result($result);
					} else {
						// Maneja el error de la consulta
						echo "Error en la consulta: " . mysqli_error($conexion); // Reemplaza "conexion" por el nombre de tu conexión
					}
					$sqlact = "INSERT INTO actividad(Id_actividad, CI) VALUES('" . $ultimaActividadId . "','" . trim($_POST['txtCI']) . "')";
					mysqli_query($conexion, $sqlact);
		header('Location:../teachers');
		exit();
	}
}