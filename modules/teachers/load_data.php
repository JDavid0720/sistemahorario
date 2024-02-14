<?php
include_once '../notif_info_msgbox.php';

require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');

// Verificar si hay docentes creados
$sql = "SELECT COUNT(CI) AS total FROM docente";
$result = $conexion->query($sql);


		// Calcular el número total de páginas para la paginación
		$max = 100; // Cantidad de elementos a mostrar por página (ajusta según tus necesidades)
		$sql = "SELECT COUNT(CI) AS total FROM docente";
		$result = $conexion->query($sql);
		
		if ($result) {
			$row = mysqli_fetch_array($result);
			$tpages = ceil($row['total'] / $max);
		}

		// Realizar la búsqueda si se envió el formulario con un valor en 'search'
		if (!empty($_POST['search'])) {
			$_POST['search'] = trim($_POST['search']);
			$_POST['search'] = mysqli_real_escape_string($conexion, $_POST['search']);
			$searchQuery = "WHERE CI LIKE '%" . $_POST['search'] . "%' OR ApellidoNombre LIKE '%" . $_POST['search'] . "%' ORDER BY ApellidoNombre, CI";
		} else {
			$searchQuery = "ORDER BY CI DESC, ApellidoNombre LIMIT $inicio, $max";
		}

		// Realizar la consulta para obtener los datos de los docentes
		$_SESSION['CI'] = array();
		$_SESSION['ApellidoNombre'] = array();
		$_SESSION['Titulo_tercer'] = array();
		$_SESSION['Titulo_cuarto'] = array();
		$i = 0;

		$sql = "SELECT * FROM docente $searchQuery";
		$result = $conexion->query($sql);

		if ($result) {
			while ($row = mysqli_fetch_array($result)) {
				$_SESSION['CI'][$i] = $row['CI'];
				$_SESSION['ApellidoNombre'][$i] = $row['ApellidoNombre'];
				$_SESSION['Titulo_tercer'][$i] = $row['Titulo_tercer'];
				$_SESSION['Titulo_cuarto'][$i] = $row['Titulo_cuarto'];
				$i++;
			}
			$_SESSION['total_users'] = count($_SESSION['CI']);
		}
	

?>
