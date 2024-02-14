<?php
include_once '../security.php';
include_once '../conexion.php';

header('Content-Type: text/html; charset=UTF-8');
header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');
header('Cache-Control: no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');

// Formulario actual
if (!empty($_POST['btn'])) {
	$view_form = $_POST['btn'] . '.php';

	if ($view_form == 'form_default.php') {
		include_once 'unset.php';
	}
} else {
	$view_form = 'form_default.php';
	include_once 'unset.php';
}

// Pagina actual
if (!empty($_POST['page'])) {
	$page = $_POST['page'];
} else {
	$page = 1;
}

// Numero de registros a visualizar
$max = 20;
$inicio = ($page - 1) * $max;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Ahora puedes utilizar $id en tu lógica de actualización
}
$_SESSION['Id_actividad1'] = array();
$_SESSION['CI1'] = array();
$_SESSION['Facultad1'] = array();
$_SESSION['Carrera1'] = array();
$_SESSION['Ciclo1'] = array();
$_SESSION['Malla1'] = array();
$_SESSION['Id_asignatura1'] = array();
$_SESSION['Id_tipoActividad1'] = array();
$_SESSION['Id_actividadEspecifica1'] = array();
$_SESSION['Id_Jornada1'] = array();
$_SESSION['ACD1'] = array();
$_SESSION['APE1'] = array();
$_SESSION['HVIR1'] = array();
$_SESSION['Total Horas Clases1']=array();

$_SESSION['OAD1'] = array();
$_SESSION['HG1'] = array();
$_SESSION['HI1'] = array();
$_SESSION['Total H.1'] =array();
$i = 0;
$sql="SELECT actividad.Id_actividad,actividad.CI,actividad.ACD,actividad.APE,actividad.HVIR,actividad.OAD,actividad.HG,
actividad.HI,actividad.HVHPP, 
asignaturaa.Nom_asignatura As asignatura_nombre, 
carrera.Nom_carrera As carrera_nombre, 
cilco.Ciclo AS ciclo_nombre,
cilco.paralelo AS ciclo_paralelo ,
malla.Nom_malla AS malla_nombre, 
tipoactividad.Nom_tipoActividad AS tipoActividadNom, 
actividadespecifica.Nom_actividadEspecifica AS actividadEspecifica_nombre,  
jornada.Nom_jornada AS jornada_nombre
FROM actividad 
LEFT JOIN asignaturaa ON actividad.Id_asignatura = asignaturaa.Id_asignatura 
LEFT JOIN docente ON actividad.CI = docente.CI
LEFT JOIN carrera ON asignaturaa.Id_carrera = carrera.Id_carrera
LEFT JOIN cilco ON asignaturaa.Id_cilco = cilco.Id_cilco 
LEFT JOIN malla ON asignaturaa.Id_malla = malla.Id_malla 
LEFT JOIN tipoactividad  ON actividad.Id_tipoActividad =tipoactividad.Id_tipoActividad
LEFT JOIN actividadespecifica   ON actividad.Id_actividadEspecifica= actividadespecifica.Id_actividadEspecifica
LEFT JOIN jornada  ON actividad.Id_Jornada =jornada.Id_Jornada
WHERE Id_actividad=$id";
//$sql="SELECT * From actividad  ORDER BY CI LIMIT $inicio, $max";
//$sql = "SELECT * FROM asignaturaa ORDER BY Id_cilco, Id_carrera,Id_malla,Nom_asignatura LIMIT $inicio, $max";

if ($result = $conexion->query($sql)) {
	
	while ($row = mysqli_fetch_array($result)) {
		$_SESSION['Id_actividad1'][$i] = $row['Id_actividad'];
		$_SESSION['CI1'][$i] = $row['CI'];
		$_SESSION['Facultad1'][$i] = "La Maná";
		$_SESSION['Carrera1'][$i] = $row['carrera_nombre'];
		$_SESSION['Ciclo1'][$i] = $row['ciclo_nombre'] . ' - ' . $row['ciclo_paralelo'];
		$_SESSION['Paralelo1'][$i]=$row['ciclo_paralelo'];
		$_SESSION['Malla1'][$i] = $row['malla_nombre'];
		$_SESSION['Id_asignatura1'][$i] = $row['asignatura_nombre'];
		$_SESSION['Id_actividadEspecifica1'][$i] = $row['actividadEspecifica_nombre'];
		$_SESSION['Id_Jornada1'][$i] = $row['jornada_nombre'];
		$_SESSION['ACD1'][$i] = $row['ACD'];
		$_SESSION['APE1'][$i] = $row['APE'];
		$_SESSION['HVIR1'][$i] = $row['HVIR'];
		$_SESSION['Total Horas Clases1'][$i]=$row['ACD']+$row['APE'];
		
		$_SESSION['OAD1'][$i] = $row['OAD'];
		$_SESSION['HG1'][$i] = $row['HG'];
		$_SESSION['HI1'][$i] = $row['HI'];
		$_SESSION['HVHPP1'][$i] = $row['HVHPP'];
		$_SESSION['Total H.1'] [$i]=$row['ACD']+$row['APE']+ $row['HVIR']+$row['OAD']+$row['HG']+$row['HI']+$row['HVHPP'];
	}
	
}
// Cargar datos de Asignaturas
include_once 'load_data.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1" />
	<meta name="robots" content="noindex">
	<meta name="google" value="notranslate">
	<link rel="icon" type="image/ico" href="/sistemaHorario/images/logoutc.ico" />
	<title>Editar distributivo | Sistema de Gestion de Horartios</title>
	<meta name="description" content="Sistema Escolar, gestión de asistencias." />
	<link rel="stylesheet" href="/sistemaHorario/css/style.css?v=<?php echo(rand()); ?>" media="screen, projection" type="text/css" />
	<link rel="stylesheet" href="/sistemaHorario/css/select2.css" media="screen, projection" type="text/css" />
	<script src="/sistemaHorario/js/external/jquery.min.js" type="text/javascript"></script>
    <script src="/sistemaHorario/js/external/prefixfree.min.js" type="text/javascript"></script>
	<script src="/sistemaHorario/js/controls/unsetnotif.js"  type="text/javascript"></script>
	<script src="/sistemaHorario/js/external/select2.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(window).load(function() {
			$(".loader").fadeOut("slow");
		});
	</script>
	     <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .form-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 10px;
    }

    .form-row label,
    .form-row input,
    .form-row select,
    .form-row button { /* Agregamos el estilo para el botón */
        flex: 1;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
        margin-right: 10px;
        margin-bottom: 10px;
        cursor: pointer; /* Cambiamos el cursor a pointer */
    }

    .form-row label {
        font-weight: bold;
        flex-basis: 150px;
    }

    .form-row input[type="submit"],
    .form-row button { /* Aplicamos el mismo estilo al botón */
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
    }

    .form-row input[type="submit"]:hover,
    .form-row button:hover { /* Aplicamos el mismo estilo al botón en hover */
        background-color: #0056b3;
    }

    select {
        width: 100%; /* Ajustar ancho del select al 100% */
    }

    input[type="text"],
    input[type="number"],
    textarea {
        width: calc(30% - 15px); /* Ajustar ancho de los inputs */
    }
</style>
</head>

<body>
	<div class="loader"></div>
	<header class="header">
		<?php
		include_once "../sections/section-info-title.php";
		?>
	</header>
	<aside>
		<?php
		if (!empty($_SESSION['section-admin']) == 'go-' . $_SESSION['user']) {
			include_once '../sections/section-admin.php';
		} elseif (!empty($_SESSION['section-editor']) == 'go-' . $_SESSION['user']) {
			include_once '../sections/section-editor.php';
		}
		?>
	</aside>
	<section class="content">
	
<h2>Actualizacion de distributivo</h2>
<form method="post" action="update.php">
<input type="hidden" name="id_actividad" value="<?php echo $_SESSION['Id_actividad1'][0]; ?>">
<div class="form-row">     
<label>Facultad / Extensión:</label>
	
	<input type="text" name="facultad_extension" value="<?php echo $_SESSION['Facultad1'][0]; ?>" readonly><br>
	</div>
	<div class="form-row"> 
    <label>Carrera:</label>
	<input type="text" name="carrera" value="<?php echo $_SESSION['Carrera1'][0]; ?>" readonly><br>
	</div>
	<div class="form-row"> 
    <label>Ciclo / Nivel:</label>
	<input type="text" name="ciclo_nivel" value="<?php echo $_SESSION['Ciclo1'][0]  ; ?>" readonly><br>
	</div>
	<div class="form-row"> 
    <label>Malla:</label>
    <input type="text" name="malla" value="<?php echo $_SESSION['Malla1'][0]  ; ?>" readonly><br>
	</div>
	<div class="form-row"> 
    <label>Asignatura / Actividad:</label>
	</div>
	<div class="form-row"> 
		<select name="asignatura_actividad">
			<?php
			// Realiza la consulta a la base de datos para obtener las asignaturas
			$sql = "SELECT Id_asignatura, Nom_asignatura FROM asignaturaa";
			$result = $conexion->query($sql);

			// Rellena las opciones del select con las asignaturas
			while ($row = $result->fetch_assoc()) {
				$selected = ($row['Nom_asignatura'] == $_SESSION['Id_asignatura1'][0]) ? 'selected' : '';
				echo '<option value="' . $row['Id_asignatura'] . '" ' . $selected . '>' . $row['Nom_asignatura'] . '</option>';
			}
			?>
		</select><br>
		</div>
		<div class="form-row"> 
    <label>Actividad Específica:</label>
	</div>
	<div class="form-row"> 
    <select name="actividadespecifica">
			<?php
			// Realiza la consulta a la base de datos para obtener las asignaturas
			$sql = "SELECT Id_actividadEspecifica, Nom_actividadEspecifica FROM actividadespecifica";
			$result = $conexion->query($sql);

			// Rellena las opciones del select con las asignaturas
			while ($row = $result->fetch_assoc()) {
				$selected = ($row['Nom_actividadEspecifica'] == $_SESSION['Id_actividadEspecifica1'][0]) ? 'selected' : '';
				echo '<option value="' . $row['Id_actividadEspecifica'] . '" ' . $selected . '>' . $row['Nom_actividadEspecifica'] . '</option>';
			}
			?>
		</select><br>
		</div>
		<div class="form-row"> 
    <label>Jornada:</label>
    <select name="jornada">
			<?php
			// Realiza la consulta a la base de datos para obtener las asignaturas
			$sql = "SELECT Id_Jornada, Nom_jornada FROM jornada";
			$result = $conexion->query($sql);

			// Rellena las opciones del select con las asignaturas
			while ($row = $result->fetch_assoc()) {
				$selected = ($row['Nom_jornada'] == $_SESSION['Id_jornada1'][0]) ? 'selected' : '';
				echo '<option value="' . $row['Id_Jornada'] . '" ' . $selected . '>' . $row['Nom_jornada'] . '</option>';
			}
			?>
		</select><br>
		</div>
		<div class="form-row"> 
    <label>Horas Teóricas (ACD):</label>
    <input type="number" name="horas_teoricas" value="<?php echo $_SESSION['ACD1'][0]  ; ?>"><br>
	</div>
	<div class="form-row"> 
    <label>Horas Prácticas (APE):</label>
    <input type="number" name="horas_practicas" value="<?php echo $_SESSION['APE1'][0]  ; ?>"><br>
	</div>
	<div class="form-row"> 
    <label>Horas Virtuales (HVIR):</label>
    <input type="number" name="horas_virtuales" value="<?php echo $_SESSION['HVIR1'][0]  ; ?>"><br>
	</div>
	<div class="form-row"> 
    <label>OAD (Objetivos de Aprendizaje):</label>
    <input type="number" name="OAD" value="<?php echo $_SESSION['OAD1'][0]  ; ?>"><br>
	</div>
	<div class="form-row"> 
    <label>Horas de Grupo (HG):</label>
    <input type="number" name="horas_grupo" value="<?php echo $_SESSION['HG1'][0]  ; ?>"><br>
	</div>
	<div class="form-row"> 
    <label>Horas Individuales (HI):</label>
    <input type="number" name="horas_individuales" value="<?php echo $_SESSION['HI1'][0]  ; ?>"><br>
	</div>
	<div class="form-row"> 
    <label>Horas de Vinculación con el Medio (HVHPP):</label>
    <input type="number" name="horas_vinculacion" value="<?php echo $_SESSION['HVHPP1'][0]  ; ?>"><br>
	</div>
	<div class="form-row"> 
    <input type="submit" value="Enviar">
	<button id="cancelButton" type="button">Cancelar</button>
    </div>
    <script>
        document.getElementById("cancelButton").addEventListener("click", function() {
            window.location.href = "../distributibo/index.php"; // Cambia esto por la URL de la página a la que deseas redirigir
        });
    </script>
</form>
	</section>
</body>
<script src="/sistemaHorario/js/controls/buttons.js" type="text/javascript"></script>

</html>