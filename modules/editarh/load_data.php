<?php
//require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php')

function duplicado($t, $d,$CI) {
    
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
	WHERE actividad.CI = '$CI' AND horario.Id_tiempo = '$t' AND horario.Id_dia = '$d'";

$result = $conexion->query($sql);
$row = $result->fetch_assoc();
$count = $row['count'];
$conexion->close();

return $count;


}
//-------------------------------------------------------------------///
function duplicadocurso($t, $d,$ca,$cil) {
    
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
	WHERE carrera.Nom_carrera='$ca' AND cilco.Id_cilco='$cil' AND horario.Id_tiempo='$t' AND horario.Id_dia='$d'";
	
	$result = $conexion->query($sql);
	$row = $result->fetch_assoc();
	$count = $row['count'];
	$conexion->close();
	
	return $count;
	
	
	}
/*
function  duplicado($t, $d, $act) {
    include '../conexion.php';

    $sql = "SELECT COUNT(*) AS count
        FROM horario
        WHERE Id_actividad = '$act' AND Id_tiempo = '$t' AND Id_dia = '$d'";

    $result = $conexion->query($sql);
    $row = $result->fetch_assoc();
    $count = intval($row['count']);
    $conexion->close();

    return $count;
}*/




function Numaleatorios($jorn)
{
    $cantidad = 3;
    $numeros = [];

    if ($jorn == 'MATUTINO') {
        $min = 7;
        $max = 10;
    } elseif ($jorn == 'VESPERTINO') {
        $min = 12;
        $max = 15;
    } elseif ($jorn == 'NOCTURNO') {
        $min = 17;
        $max = 20;
    } else {
        return $numeros; // Retorna una matriz vacía si la jornada no es válida
    }

    while (count($numeros) < $cantidad) {
        $numero = mt_rand($min, $max);

        if (!in_array($numero, $numeros)) {
            $numeros[] = $numero;
        }
    }

    return $numeros;
}
function numDia()
{
    $cantidad = 5;
    $diasSemana = [1, 2, 3, 4, 5];
    $numerosDia = [];

    for ($i = 0; $i < $cantidad; $i++) {
        // Obtiene un índice aleatorio dentro del rango de los días disponibles
        $indice = array_rand($diasSemana);

        // Obtiene el día correspondiente al índice aleatorio y lo guarda en el arreglo
        $numeroDia = $diasSemana[$indice];
        $numerosDia[] = $numeroDia;

        // Elimina el día seleccionado del arreglo para evitar repeticiones
        unset($diasSemana[$indice]);

        // Reindexa el arreglo de días disponibles
        $diasSemana = array_values($diasSemana);
    }

    return $numerosDia;
}


//funcion ver si tiene el ci //

function obtenerNombreDia($numeroDia) {
    $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
    return $dias[$numeroDia - 1];
}
//------------------------funcion ingresar datos a la base de datos de los horarios--------------------

function ejecutar($ci)
{
    // Obtiene el número total de asignaturas en la sesión
    $totalAsignaturas = count($_SESSION["Id_actividad"]);

    // Incluye el archivo de conexión a la base de datos
    include '../conexion.php';

    // Itera sobre las asignaturas en la sesión
    for ($j = 0; $j < $totalAsignaturas; $j++) {
        // Comprueba si el CI coincide
        if ($_SESSION["CI"][$j] === $ci) {
            // Extrae los valores de las variables
            $act = $_SESSION["Id_actividad"][$j];
            $jornada = $_SESSION["Id_Jornada"][$j];
            $ACD = $_SESSION["ACD"][$j];
            $APE = $_SESSION["APE"][$j];
			$carreraM=$_SESSION["Carrera"][$j];
			$ciclo=$_SESSION["Id_Ciclo"][$j];
            // Verifica si el valor de ACD está en el rango permitido
            if ($ACD >0 && $ACD <6) {
                generarHorarios($act, $ACD, $jornada, "ACD", $ci,$carreraM,$ciclo);
            }

            // Verifica si el valor de APE está en el rango permitido
            if ($APE >0 && $APE <6) {
                generarHorarios($act, $APE, $jornada, "APE", $ci,$carreraM,$ciclo);
            }
        }
    }
}

function generarHorarios($act, $cantidad, $jornada, $tipo, $ci,$carr,$cicl)
{
    // Genera números aleatorios y números de día
    $numerosAleatorios = Numaleatorios($jornada);
    $numerosDia = numDia();

    // Verifica si hay suficientes números aleatorios y números de día disponibles
    if (count($numerosAleatorios) < $cantidad || count($numerosDia) < $cantidad) {
        $numerosAleatorios = Numaleatorios($jornada);
    $numerosDia = numDia();
		echo "nuevos numeors ";
        
    }

    // Restringe los arrays de números aleatorios y números de día a la cantidad deseada
    $numerosAleatorios = array_slice($numerosAleatorios, 0, $cantidad);
    $numerosDia = array_slice($numerosDia, 0, $cantidad);

    // Incluye el archivo de conexión a la base de datos
    include '../conexion.php';

    // Genera un horario para cada tipo (ACD o APE)
    for ($i = 0; $i < $cantidad; $i++) {
		$vau=$i;
        // Asigna el número aleatorio y el número de día
		if($vau>=3)
		{
			$vau=$vau%3;
		}
        $num = $numerosAleatorios[$vau];
        $dia = $numerosDia[$vau];

         // Verifica si ya existe un horario para la misma actividad, tiempo y día
		 while (duplicado($num, $dia, $ci) > 0 || duplicadocurso($num, $dia,$carr,$cicl)>0){
            // Incrementa el número aleatorio y el número de día
            
			$num++;
            //$dia++;
			if ($dia > 5) {
				$dia = 1;
			}
        }
		
        // Construye la consulta SQL para insertar un nuevo registro en la tabla horario
        $sql = "INSERT INTO horario (Id_actividad, Id_tiempo, Id_dia, Tipo) VALUES ('$act', '$num', '$dia', '$tipo')";

        // Ejecuta la consulta
        if (mysqli_query($conexion, $sql)) {
            echo "Horario ingresado correctamente." . $carr;
        } else {
            echo "Error al ejecutar la consulta: " . mysqli_error($conexion);
        }
    }
}


include '../conexion.php';
//---------------------------------------------------------------------------------------------------------//
//---------------------------------------Ingresar  datos APE------------------------------------
$sql = "SELECT COUNT(Id_actividad) AS total FROM actividad";

if ($result = $conexion->query($sql)) {
	if ($row = mysqli_fetch_array($result)) {
	
	}
}

if (!empty($_POST['search'])) {
	$_POST['search'] = trim($_POST['search']);
	$_POST['search'] = mysqli_real_escape_string($conexion, $_POST['search']);
	$_SESSION['Id_actividad'] = array();
	$_SESSION['CI'] = array();
	$_SESSION['Facultad'] = array();
	$_SESSION['Carrera'] = array();
	$_SESSION['Ciclo'] = array();
	$_SESSION['Malla'] = array();
	$_SESSION['Id_asignatura'] = array();
	$_SESSION['Id_tipoActividad'] = array();
	$_SESSION['Id_actividadEspecifica'] = array();
	$_SESSION['Id_Jornada'] = array();
	$_SESSION['ACD'] = array();
	$_SESSION['APE'] = array();
	$_SESSION['HVIR'] = array();
	$_SESSION['Total Horas Clases']=array();
	$_SESSION['HVIR'] = array();
	$_SESSION['OAD'] = array();
	$_SESSION['HG'] = array();
	$_SESSION['HI'] = array();
	//$_SESSION['HVHPP'] = array();
	$_SESSION['Total H.'] =array();

	$i = 0;

	$sql = "SELECT * FROM actividad WHERE CI LIKE '%" . $_POST['search'] . "%' OR CI LIKE '%" . $_POST['search'] . "%' OR Id_actividad  LIKE '%" . $_POST['search'] . "%' ORDER BY CI";

	if ($result = $conexion->query($sql)) {
		while ($row = mysqli_fetch_array($result)) {
			$_SESSION['Id_actividad'][$i] = $row['Id_actividad'];
			$_SESSION['CI'][$i] = $row['CI'];
			$_SESSION['Facultad'][$i] = "La Maná";
			$_SESSION['Carrera'][$i] = $row['carrera_nombre'];
			$_SESSION['Ciclo'][$i] = $row['ciclo_nombre'];
			$_SESSION['Malla'][$i] = $row['malla_nombre'];
			$_SESSION['Id_asignatura'][$i] = $row['asignatura_nombre'];
			$_SESSION['Id_actividadEspecifica'][$i] = $row['actividadEspecifica_nombre'];
			$_SESSION['Id_Jornada'][$i] = $row['jornada_nombre'];
			$_SESSION['ACD'][$i] = $row['ACD'];
			$_SESSION['APE'][$i] = $row['APE'];
			$_SESSION['HVIR'][$i] = $row['HVIR'];
			$_SESSION['Total Horas Clases'][$i]=0;
			$_SESSION['HVIR'][$i] = $row['HVIR'];
			$_SESSION['OAD'][$i] = $row['OAD'];
			$_SESSION['HG'][$i] = $row['HG'];
			$_SESSION['HI'][$i] = $row['HI'];
			//$_SESSION['HVHPP'][$i] = $row['HVHPP'];
			$_SESSION['Total H.'] [$i]=$row['ACD']+$row['APE']+ $row['HVIR']+$row['OAD']+$row['HG']+$row['HI']+$row['HVHPP'];

			$i += 1;
		}
	}
	$_SESSION['total_docente'] = count($_SESSION['Id_actividad']);
} else {
	$_SESSION['Id_actividad'] = array();
	$_SESSION['CI'] = array();
	$_SESSION['Facultad'] = array();
	$_SESSION['Carrera'] = array();
	$_SESSION['Ciclo'] = array();
	$_SESSION['Paralelo'] = array();
	$_SESSION['Malla'] = array();
	$_SESSION['Id_asignatura'] = array();
	$_SESSION['Id_tipoActividad'] = array();
	$_SESSION['Id_actividadEspecifica'] = array();
	$_SESSION['Id_Jornada'] = array();
	$_SESSION['ACD'] = array();
	$_SESSION['APE'] = array();
	$_SESSION['HVIR'] = array();
	$_SESSION['Total Horas Clases']=array();
	
	$_SESSION['OAD'] = array();
	$_SESSION['HG'] = array();
	$_SESSION['HI'] = array();
	$_SESSION['Total H.'] =array();
	$i = 0;
	$sql = "SELECT actividad.Id_actividad, actividad.CI, actividad.ACD, actividad.APE, actividad.HVIR, actividad.OAD, actividad.HG,
        actividad.HI, actividad.HVHPP, 
        asignaturaa.Nom_asignatura AS asignatura_nombre, 
        carrera.Nom_carrera AS carrera_nombre, 
        cilco.Ciclo AS ciclo_nombre,
        cilco.paralelo AS ciclo_paralelo,
        malla.Nom_malla AS malla_nombre, 
        tipoactividad.Nom_tipoActividad AS tipoActividadNom, 
        actividadespecifica.Nom_actividadEspecifica AS actividadEspecifica_nombre,  
        jornada.Nom_jornada AS jornada_nombre,
        cilco.Id_cilco AS Id_cilco
        FROM actividad 
        INNER JOIN asignaturaa ON actividad.Id_asignatura = asignaturaa.Id_asignatura 
		INNER JOIN docente ON actividad.CI = docente.CI
        INNER JOIN carrera ON asignaturaa.Id_carrera = carrera.Id_carrera
        INNER JOIN cilco ON asignaturaa.Id_cilco = cilco.Id_cilco 
        INNER JOIN malla ON asignaturaa.Id_malla = malla.Id_malla 
        INNER JOIN tipoactividad ON actividad.Id_tipoActividad = tipoactividad.Id_tipoActividad
        INNER JOIN actividadespecifica ON actividad.Id_actividadEspecifica = actividadespecifica.Id_actividadEspecifica
        INNER JOIN jornada ON actividad.Id_Jornada = jornada.Id_Jornada
		ORDER BY docente.ApellidoNombre, actividad.Id_actividad";

	//$sql="SELECT * From actividad  ORDER BY CI LIMIT $inicio, $max";
	//$sql = "SELECT * FROM asignaturaa ORDER BY Id_cilco, Id_carrera,Id_malla,Nom_asignatura LIMIT $inicio, $max";
	
	if ($result = $conexion->query($sql)) {
		while ($row = mysqli_fetch_array($result)) {
			$_SESSION['Id_actividad'][$i] = $row['Id_actividad'];
			$_SESSION['CI'][$i] = $row['CI'];
			$_SESSION['Facultad'][$i] = "La Maná";
			$_SESSION['Carrera'][$i] = $row['carrera_nombre'];
			$_SESSION['Id_Ciclo'][$i] = $row['Id_cilco'] ;
			$_SESSION['Ciclo'][$i] = $row['ciclo_nombre'] ;
			$_SESSION['Paralelo'][$i] = $row['ciclo_paralelo'] ;
			$_SESSION['Malla'][$i] = $row['malla_nombre'];
			$_SESSION['Id_asignatura'][$i] = $row['asignatura_nombre'];
			$_SESSION['Id_actividadEspecifica'][$i] = $row['actividadEspecifica_nombre'];
			$_SESSION['Id_Jornada'][$i] = $row['jornada_nombre'];
			$_SESSION['ACD'][$i] = $row['ACD'];
			$_SESSION['APE'][$i] = $row['APE'];
			$_SESSION['HVIR'][$i] = $row['HVIR'];
			$_SESSION['Total Horas Clases'][$i]=$row['ACD']+$row['APE'];
			
			$_SESSION['OAD'][$i] = $row['OAD'];
			$_SESSION['HG'][$i] = $row['HG'];
			$_SESSION['HI'][$i] = $row['HI'];
			$_SESSION['HVHPP'][$i] = $row['HVHPP'];
			$_SESSION['Total H.'] [$i]=$row['ACD']+$row['APE']+ $row['HVIR']+$row['OAD']+$row['HG']+$row['HI']+$row['HVHPP'];
			$i += 1;
		}
	}
	$_SESSION['total_docente'] = count($_SESSION['Id_actividad']);
}