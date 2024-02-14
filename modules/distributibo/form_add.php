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
	<div class="form-container">
<h2>Agregar actividad al distributivo</h2>
<form method="post" action="insert.php">
<?php
    // Realizar la consulta SQL para obtener el último Id_actividad
    $sql = "SELECT Id_actividad FROM actividad ORDER BY Id_actividad DESC LIMIT 1";
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastIdActividad = $row['Id_actividad']+1;
    } else {
        // Si no hay registros, asigna un valor por defecto
        $lastIdActividad = 0;
    }
    ?>
 <input type="hidden" name="id_actividad" value="<?php echo $lastIdActividad; ?>">
 <?php
if (isset($_POST['param'])) {
    $parametro =$_POST['param']; // Obtener el valor del parámetro "param"
    // Resto de tu código aquí
} else {
    echo "El parámetro 'param' no se ha pasado en la URL.";
}
?>
<!-- Dentro de tus etiquetas HTML -->
<input type="hidden" name="CI" value="<?php echo $parametro; ?>">
<div class="form-row">
    <label>Facultad / Extensión:</label>
	
	<input type="text" name="facultad_extension" value="<?php echo $_SESSION['Facultad'][0]; ?>" readonly><br>
    </div>
    <div class="form-row">
    <label>Asignatura / Actividad:</label>
    <input type="text" id="searchInput" placeholder="Buscar asignatura">
    </div>
    <div class="form-row">
    <select name="asignatura_actividad" id="asignatura_actividad">
    <?php
    // Realiza la consulta a la base de datos para obtener las asignaturas con información relacionada
    $sql = "SELECT a.Id_asignatura, a.Nom_asignatura, c.Nom_carrera, ci.Ciclo, ci.paralelo, m.Nom_malla
    FROM asignaturaa a
    LEFT JOIN carrera c ON a.Id_carrera = c.Id_carrera
    LEFT JOIN cilco ci ON a.Id_cilco = ci.Id_cilco
    LEFT JOIN malla m ON a.Id_malla = m.Id_malla";
    $result = $conexion->query($sql);

    // Rellena las opciones del select con las asignaturas y la información relacionada
    while ($row = $result->fetch_assoc()) {
       
        echo '<option value="' . $row['Id_asignatura'] . '" ' . $selected . '>'
            . $row['Nom_asignatura'] . ' - ' . $row['Nom_carrera'] . ' - '
            . $row['Ciclo'] . ' - '. $row['paralelo'] . ' - ' . $row['Nom_malla'] . '</option>';
    }
    
    ?>
</select><br>

<script>
document.getElementById("searchInput").addEventListener("keyup", function() {
    var input, filter, select, options, i, optionText;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    select = document.getElementById("asignatura_actividad");
    options = select.getElementsByTagName("option");
    
    for (i = 0; i < options.length; i++) {
        optionText = options[i].textContent || options[i].innerText;
        if (optionText.toUpperCase().indexOf(filter) > -1) {
            options[i].style.display = "";
        } else {
            options[i].style.display = "none";
        }
    }
});
</script>
</div>
<div class="form-row"> 
    <label>Actividad Específica:</label>
    <input type="text" id="searchInput2" placeholder="Buscar actividad específica">
    </div>
    <div class="form-row">
    <select name="actividadespecifica"  id="actividadespecifica">
			<?php
			// Realiza la consulta a la base de datos para obtener las asignaturas
			$sql = "SELECT Id_actividadEspecifica, Nom_actividadEspecifica FROM actividadespecifica";
			$result = $conexion->query($sql);

			// Rellena las opciones del select con las asignaturas
			while ($row = $result->fetch_assoc()) {
			echo '<option value="' . $row['Id_actividadEspecifica'] . '" ' . $selected . '>' . $row['Nom_actividadEspecifica'] . '</option>';
			}
			?>
		</select><br>
        
            <script>
            document.getElementById("searchInput2").addEventListener("keyup", function() {
                var input, filter, select, options, i, optionText;
                input = document.getElementById("searchInput2");
                filter = input.value.toUpperCase();
                select = document.getElementById("actividadespecifica");
                options = select.getElementsByTagName("option");
                
                for (i = 0; i < options.length; i++) {
                    optionText = options[i].textContent || options[i].innerText;
                    if (optionText.toUpperCase().indexOf(filter) > -1) {
                        options[i].style.display = "";
                    } else {
                        options[i].style.display = "none";
                    }
                }
            });
            </script>
            </div>
            <div class="form-row">
        <label>Tipo de Actividad:</label>
    <select name="tipoactividad" id="tipoactividad">
			<?php
			// Realiza la consulta a la base de datos para obtener las asignaturas
			$sql = "SELECT Id_tipoActividad, Nom_tipoActividad FROM tipoactividad";
			$result = $conexion->query($sql);

			// Rellena las opciones del select con las asignaturas
			while ($row = $result->fetch_assoc()) {
				
				echo '<option value="' . $row['Id_tipoActividad'] . '" ' . $selected . '>' . $row['Nom_tipoActividad'] . '</option>';
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
				echo '<option value="' . $row['Id_Jornada'] . '" ' . $selected . '>' . $row['Nom_jornada'] . '</option>';
			}
			?>
		</select><br>
        </div>
        <div class="form-row">  
    <label>Horas Teóricas (ACD):</label>
    <input type="number" name="horas_teoricas" value="0"><br>
    </div>
    <div class="form-row">
    <label>Horas Prácticas (APE):</label>
    <input type="number" name="horas_practicas" value="0"><br>
    </div>
    <div class="form-row">
    <label>Horas Virtuales (HVIR):</label>
    <input type="number" name="horas_virtuales" value="0"><br>
    </div>
    <div class="form-row">
    <label>OAD (Objetivos de Aprendizaje):</label>
    <input type="number" name="OAD" value="0"><br>
    </div>
    <div class="form-row">        
    <label>Horas de Grupo (HG):</label>
    <input type="number" name="horas_grupo" value="0"><br>
    </div>
    <div class="form-row">
    <label>Horas Individuales (HI):</label>
    <input type="number" name="horas_individuales" value="0"><br>
    <div class="form-row">       
    </div>
    <label>Horas de Vinculación con el Medio (HVHPP):</label>
    <input type="number" name="horas_vinculacion" value="0"><br>
    </div>
    <div class="form-row">        
    <input type="submit" value="Registrar"> 
    <button id="cancelButton" type="button">Cancelar</button>
    </div>
    <script>
        document.getElementById("cancelButton").addEventListener("click", function() {
            window.location.href = "../distributibo/index.php"; // Cambia esto por la URL de la página a la que deseas redirigir
        });
    </script>
</form>
</div>
	</section>
</body>

</html>