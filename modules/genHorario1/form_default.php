<!DOCTYPE html>
<html>
<head>
    <title>Información Docente</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- CSS de Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- Librería jQuery (requerida por Bootstrap) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Scripts de Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <style>
    /* Estilos para el contenedor */
.containerbtn {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 20px;
  border-radius: 5px;
  text-align: center;
  background-color: #f2f2f2;
}

/* Estilos para los botones y select */
input[type="radio"], input[type="submit"], select {
  background-color: #005DA5;
  color: white;
  border: none;
  padding: 10px 20px;
  font-size: 16px;
  border-radius: 5px;
  cursor: pointer;
  margin: 5px;
}

/* Estilos para el botón al pasar el mouse por encima */
input[type="submit"]:hover {
  background-color: #00457c;
}

/* Estilos para el select y sus opciones */
select {
  padding: 8px;
  color: white;
  background-color: #005DA5;
}

select option {
  background-color: #005DA5;
}

/* Estilos para las etiquetas */
label {
  font-weight: bold;
  margin-right: 10px;
}

/* Consulta de medios para pantallas más pequeñas */
@media screen and (max-width: 768px) {
  .containerbtn {
    flex-direction: column; /* Cambiar el diseño a columna */
  }
}


table {
    width: 100%;
    /* Ancho total de la tabla (ajusta el tamaño de acuerdo al contenedor) */
    table-layout: fixed;
    /* Fija el ancho de las columnas */
}

table td {
    width: 100px;
    /* Ancho de las celdas (puedes cambiar el valor según tus necesidades) */
    padding: 8px;
    /* Espacio de relleno dentro de cada celda */
    border: 1px solid #ddd;
    /* Borde de las celdas */
    text-align: center;
    /* Alineación del contenido en el centro de las celdas */
    font-size: 10px;
    /* Puedes ajustar el tamaño de letra según tus necesidades */
    word-wrap: break-word;
    /* Evita que el texto se salga de las celdas */
}

/* Estilo para centrar los íconos en las celdas */
.icon-cell {
    display: flex;
    justify-content: center;
    /* Centra horizontalmente el contenido en la celda */
    align-items: center;
    /* Centra verticalmente el contenido en la celda */
    height: 50px;
    /* Ajusta la altura de la celda para centrar verticalmente el contenido */
}

/* Estilo para ajustar el tamaño de los íconos */
.icon-cell i {
    font-size: 24px;
    /* Tamaño del ícono, puedes ajustarlo según tus preferencias */
}

/* Estilos generales */
body {
    font-family: Arial, sans-serif;
    margin: 20px;
    background-color: #f5f5f5;
}

h1 {
    color: #005daa;
    text-align: center;
    margin-bottom: 30px;
}

h2 {
    color: #333;
    margin-top: 40px;
}

ul.horizontal-list {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    margin-bottom: 40px;
}

ul.horizontal-list li {
    width: 30%;
    margin-bottom: 20px;
}

input[type="text"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
    width: auto;
    /* Ajuste automático al contenido */
}

thead {
    background-color: #005daa;
    color: #fff;
}

tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

tbody tr:hover {
    background-color: #e5f6ff;
}

    </style>
</head>
<body>

<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generarBtn'])) {
      // Lógica para verificar la condición en el servidor
      // Por ejemplo, puedes definir una función condicionCumplida() y llamarla aquí
      // Consulta SQL para verificar si la tabla está vacía
$sql = "SELECT * FROM horario";
$result = $conexion->query($sql);

// Verifica si la consulta devuelve algún resultado
if ($result->num_rows > 0) {
    echo '<script>
            var respuesta = confirm("¿Quieres borrar los horarios?");
            if (respuesta) {
                // Si el usuario elige "Sí", redirige al archivo que realizará el borrado
                window.location.href = "delete.php";
               
            } else {
                // Si el usuario elige "No", redirige a otra página o muestra un mensaje
                alert("Has decidido no generar los horarios nuevamente.");
                window.location.href = "index.php";
            }
          </script>';
} else {
    
    require_once 'load_data.php';
// Obtener la cantidad de docentes
$totalDocentes = count($_SESSION["Id_actividad"]);
$ci_anterior = '';
    for ($i = 0; $i < $totalDocentes; $i++) {
        // Realizar la consulta SQL para obtener el nombre del docente según el CI
        $ci = $_SESSION['CI'][$i];
        $sql = "SELECT docente.ApellidoNombre, docente.Titulo_cuarto, docente.dedicacion, docente.Contrato, carrera.Nom_carrera AS carrera_nombre FROM docente INNER JOIN carrera ON carrera.Id_carrera = docente.Id_carrera WHERE docente.CI = '" . mysqli_real_escape_string($conexion, $ci) . "'";
        $result = mysqli_query($conexion, $sql);
        $row = mysqli_fetch_assoc($result);
        $nombreDocente = $row['ApellidoNombre'];
        $Titulo4 = $row['Titulo_cuarto'];
        $dedicacion = $row['dedicacion'];
        $Contrato = $row['Contrato'];
        $carrera = $row['carrera_nombre'];
   
     $currentCI = $_SESSION["CI"][$i];
     if($currentCI != $ci_anterior  )
     {
    
      
       ejecutar($ci);
      
   
    } 
   $ci_anterior = $currentCI;
   }
   echo '<script>
   // Si el usuario elige "No", redirige a otra página o muestra un mensaje
   alert("Horarios generados con exito.");
   window.location.href = "index.php";
   </script>';
}
     
  }
  
include '../conexion.php';
// Consulta SQL
$sqlper = "SELECT name FROM `school_periods` WHERE school_period='" . $_SESSION['school_period'] . "'";
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


?>
<div class="container">
<?php
require_once 'load_data.php';
// Obtener la cantidad de docentes
$totalDocentes = count($_SESSION["Id_actividad"]);
$ci_anterior = '';
echo '<div class="containerbtn">';
// Definir una variable para almacenar la opción seleccionada
$carreraSeleccionada = '';
$opcionSeleccionada = ''; // Variable para almacenar la opción de radio seleccionada

// Verificar si se envió el formulario y se seleccionó una carrera
if (isset($_POST['carrera'])) {
    // Obtener el valor seleccionado (ID de carrera)
    $idCarreraSeleccionada = $_POST['carrera'];

    // Consulta SQL para obtener el nombre de la carrera seleccionada
    $sql = "SELECT Nom_carrera FROM carrera WHERE Id_carrera = '$idCarreraSeleccionada'";
    $result = $conexion->query($sql);

    // Verificar si se encontró el resultado
    if ($result->num_rows > 0) {
        // Obtener el nombre de la carrera
        $row = $result->fetch_assoc();
        $carreraSeleccionada = $row["Nom_carrera"];
    }
}

// Verificar si se envió el formulario y se seleccionó una opción de radio
if (isset($_POST['opcion'])) {
    $opcionSeleccionada = $_POST['opcion'];
    
}

// Consulta SQL para obtener los datos de la tabla "carrera"
$sql = "SELECT Id_carrera, Nom_carrera FROM carrera";
$result = $conexion->query($sql);

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Generar la lista desplegable para mostrar los datos
    echo "<form method='post'>";
    echo "<select id='miSelect' name='carrera' onchange='habilitarRadioButtons()'>";
    echo "<option value='' selected>Todos</option>"; // Opción adicional
    while ($row = $result->fetch_assoc()) {
        $idCarrera = $row["Id_carrera"];
        $nomCarrera = $row["Nom_carrera"];
        $selected = ($idCarreraSeleccionada == $idCarrera) ? 'selected' : ''; // Verificar si la opción está seleccionada
        echo "<option value='$idCarrera' $selected>$nomCarrera</option>";
    }
    echo "</select>";

    // Agregar los radio buttons para "docente" y "cursos" con nombres distintos
    echo "<input type='radio' name='opcion' value='docente' onclick='habilitarRadioButtons()' " . ($opcionSeleccionada === 'docente' ? 'checked' : '') . "> Docente";
    echo "<input type='radio' name='opcion' value='cursos' onclick='habilitarRadioButtons()' " . ($opcionSeleccionada === 'cursos' ? 'checked' : '') . "> Cursos";

    // Agregar el botón de envío
    echo "<input class='estilo-boton' type='submit' value='Mostrar'>";
    echo "</form>";
    $nombreBoton = "Generar Horarios"; // Valor predeterminado
    $sql = "SELECT * FROM horario";
$result = $conexion->query($sql);
if ($result->num_rows > 0) {
    $nombreBoton = "Borrar horarios"; // Cambiar el valor si se cumple la condición
    }
    echo "<form method='post'>";
    echo "<input class='estilo-boton' type='submit' name='generarBtn' value='$nombreBoton'>";
    echo "</form>";
  echo '  <form method="post" action="exportar.php">
  <input type="hidden" name="carrera" value="' . $carreraSeleccionada . '">
  <input type="hidden" name="radiobtn" value="' . $opcionSeleccionada . '">
  <input type="hidden" name="periodo" value="' . $_SESSION['school_period'] . '">
  <input type="submit" name="generar" value="Exportar">
</form>';

} else {
    echo "No se encontraron resultados.";
}
echo '</div>';
echo '<div id="exportForm">';

if($opcionSeleccionada==''|| $opcionSeleccionada=='docente')
{
    // Iterar sobre cada docente
for ($i = 0; $i < $totalDocentes; $i++) {
     // Realizar la consulta SQL para obtener el nombre del docente según el CI
     $ci = $_SESSION['CI'][$i];
     $sql = "SELECT docente.ApellidoNombre, docente.Titulo_cuarto, docente.dedicacion, docente.Contrato, carrera.Nom_carrera AS carrera_nombre FROM docente INNER JOIN carrera ON carrera.Id_carrera = docente.Id_carrera WHERE docente.CI = '" . mysqli_real_escape_string($conexion, $ci) . "'";
     $result = mysqli_query($conexion, $sql);
     $row = mysqli_fetch_assoc($result);
     $nombreDocente = $row['ApellidoNombre'];
     $Titulo4 = $row['Titulo_cuarto'];
     $dedicacion = $row['dedicacion'];
     $Contrato = $row['Contrato'];
     $carrera = $row['carrera_nombre'];
if ( $carreraSeleccionada=='')
{
  $currentCI = $_SESSION["CI"][$i];
  if($currentCI != $ci_anterior  )
  {
  //  if ( $_SESSION["Carrera"][$i]=="SISTEMAS")
//{
    echo '<h1>Información Docente</h1>';

    echo '<h2>Encabezado</h2>';
    echo '<ul class="horizontal-list">';
    echo '<li>';
    echo 'Cédula de Identidad: <br>';
    echo '<input type="text" value="' . (isset($_SESSION['CI'][$i]) ? $_SESSION['CI'][$i] : '') . '"></li>';
    echo '</li>';
    echo '<li>';
    echo 'Docente:';
    echo '<br>';
   
    //ejecutar($ci);
    // Mostrar el input con la información del docente
    echo '<input type="text" value="' . $nombreDocente . '">';
    //proceso de generacion//
  
   
echo '</li>';
echo '<li>';
echo 'Tipología Docente: <br>';
echo '<input type="text" value="Tipología">';
echo '</li>';
echo '<li>';
echo 'Título de Cuarto Nivel: <br>';
echo '<input type="text" value="' . $Titulo4 . '" readonly>';
echo '</li>';
echo '<li>';
echo 'Dedicación: <br>';
echo '<input type="text" value="' . $dedicacion . '" readonly>';
echo '</li>';
echo '<li>';
echo 'Grado Escalafonario / Nombramiento: <br>';
echo '<input type="text" value="' . $Contrato . '" readonly>';
echo '</li>';
echo '<li>';
echo 'Carrera a la que Pertenece: <br>';
echo '<input type="text" value="' . $carrera . '" readonly>';
echo '</li>';
echo '</ul>';
//echo '<h2>Tabla</h2>';
echo '<div class="container">';
echo '<div class="table-container">';
echo "<table>";

// Generar la fila de encabezado con los días
echo "<tr>";
echo "<th>Hora</th>";
for ($dia = 1; $dia <= 7; $dia++) {
    echo "<th>" . obtenerNombreDia($dia) . "</th>";
}
echo "</tr>";

// Recorrer las horas y generar las filas de la tabla
for ($hora = 7; $hora <= 22; $hora++) {
    echo "<tr>";
    echo "<td>" . ($hora < 10 ? "0" : "") . $hora . ":00 - " . ($hora < 10 ? "0" : "") . $hora . ":59</td>";    

    // Recorrer los días y generar las celdas de la tabla
    for ($dia = 1; $dia <= 7; $dia++) {
        echo "<td>";

        // Realizar la consulta SQL para obtener los registros de horario que coincidan con la hora y el día actual
        $sql = "SELECT horario.Id_actividad,horario.Id_tiempo,horario.Id_dia,horario.Tipo,actividad.Id_actividad,actividad.CI,actividad.ACD,actividad.APE,actividad.HVIR,actividad.OAD,actividad.HG,
        actividad.HI,actividad.HVHPP, 
        asignaturaa.Nom_asignatura As asignatura_nombre, 
        actividad.CI AS cedula, 
        carrera.Nom_carrera As carrera_nombre, 
        cilco.Ciclo AS ciclo_nombre,
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
            WHERE actividad.CI='$currentCI'
            ORDER BY horario.Id_actividad";
        $result = $conexion->query($sql);

        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            // Mostrar los datos de los registros encontrados
            while ($row = $result->fetch_assoc()) {
                // Acceder a los campos de la tabla horario
              $jorna= $row['jornada_nombre'];
                $idActividad = $row['Id_actividad'];
                $cedula=$row['cedula'];
                $idTiempo = $row['Id_tiempo'];
                $idDia = $row['Id_dia'];
                $asignatura=$row['asignatura_nombre'];
                $ACD=$row['ACD'];
                $APE=$row['APE'];
                $tp=$row['Tipo'];
                $carrera=$row['carrera_nombre'];
                $ciclo=$row['ciclo_nombre'];
                
                if($hora== $idTiempo && $dia== $idDia)
                {
                    
                    echo " $asignatura <br>";
                    echo "$tp <br>";
                    echo "$carrera <br>";
                    echo "$ciclo <br>";
                   
                     // Agregar botones de edición y eliminación
                     echo "<br>";
                     
                     // Supongamos que tienes las variables $idActividad, $dias y $hora
                     
                     // Generar los enlaces con las variables adicionales
                    
                     
                     echo '<a href="#" class="edit-link" data-toggle="modal" data-target="#myModal" data-id="'.$idActividad .'" data-hora="' . $idTiempo . '" data-dia="' . $idDia . '" data-tipo="' . $tp . '" data-nombre="' . $asignatura . '" data-jornada="' . $jorna . '" data-carrera="' . $carrera . '" data-cedula="' . $cedula . '"><i class="fas fa-edit"></i> Edita </a>';
                                       
                     
           
                }

                // Mostrar los resultados en la celda de la tabla
               
            }
        } else {
            // No se encontraron registros para esta hora y día
          
        }

        echo "</td>";
    }

    echo "</tr>";
}

echo "</table>";

 }


echo '</div>';
echo '</div>';
 
$ci_anterior = $currentCI;
  }
  elseif($carrera==$carreraSeleccionada)
  {
    $currentCI = $_SESSION["CI"][$i];
    if($currentCI != $ci_anterior  )
    {
    //  if ( $_SESSION["Carrera"][$i]=="SISTEMAS")
  //{
      echo '<h1>Información Docente</h1>';
  
      echo '<h2>Encabezado</h2>';
      echo '<ul class="horizontal-list">';
      echo '<li>';
      echo 'Cédula de Identidad: <br>';
      echo '<input type="text" value="' . (isset($_SESSION['CI'][$i]) ? $_SESSION['CI'][$i] : '') . '"></li>';
      echo '</li>';
      echo '<li>';
      echo 'Docente:';
      echo '<br>';
     
    //ejecutar($ci);
      // Mostrar el input con la información del docente
      echo '<input type="text" value="' . $nombreDocente . '">';
      //proceso de generacion//
    
     
  echo '</li>';
  echo '<li>';
  echo 'Tipología Docente: <br>';
  echo '<input type="text" value="Tipología">';
  echo '</li>';
  echo '<li>';
  echo 'Título de Cuarto Nivel: <br>';
  echo '<input type="text" value="' . $Titulo4 . '" readonly>';
  echo '</li>';
  echo '<li>';
  echo 'Dedicación: <br>';
  echo '<input type="text" value="' . $dedicacion . '" readonly>';
  echo '</li>';
  echo '<li>';
  echo 'Grado Escalafonario / Nombramiento: <br>';
  echo '<input type="text" value="' . $Contrato . '" readonly>';
  echo '</li>';
  echo '<li>';
  echo 'Carrera a la que Pertenece: <br>';
  echo '<input type="text" value="' . $carrera . '" readonly>';
  echo '</li>';
  echo '</ul>';
  //echo '<h2>Tabla</h2>';
  echo '<div class="container">';
  echo '<div class="table-container">';
  echo "<table>";
  
  // Generar la fila de encabezado con los días
  echo "<tr>";
  echo "<th>Hora</th>";
  for ($dia = 1; $dia <= 7; $dia++) {
      echo "<th>" . obtenerNombreDia($dia) . "</th>";
  }
  echo "</tr>";
  
  // Recorrer las horas y generar las filas de la tabla
  for ($hora = 7; $hora <= 22; $hora++) {
      echo "<tr>";
      echo "<td>" . ($hora < 10 ? "0" : "") . $hora . ":00 - " . ($hora < 10 ? "0" : "") . $hora . ":59</td>";    
  
      // Recorrer los días y generar las celdas de la tabla
      for ($dia = 1; $dia <= 7; $dia++) {
          echo "<td>";
  
          // Realizar la consulta SQL para obtener los registros de horario que coincidan con la hora y el día actual
          $sql = "SELECT horario.Id_actividad,horario.Id_tiempo,horario.Id_dia,horario.Tipo,actividad.Id_actividad,actividad.CI,actividad.ACD,actividad.APE,actividad.HVIR,actividad.OAD,actividad.HG,
          actividad.HI,actividad.HVHPP, 
          asignaturaa.Nom_asignatura As asignatura_nombre,
          actividad.CI AS cedula, 
          carrera.Nom_carrera As carrera_nombre, 
          cilco.Ciclo AS ciclo_nombre,
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
              WHERE actividad.CI='$currentCI'
              ORDER BY horario.Id_actividad";
              
          $result = $conexion->query($sql);
  
          // Verificar si hay resultados
          if ($result->num_rows > 0) {
              // Mostrar los datos de los registros encontrados
              while ($row = $result->fetch_assoc()) {
                  // Acceder a los campos de la tabla horario
                  $jorna= $row['jornada_nombre'];
                  $idActividad = $row['Id_actividad'];
                  $cedula=$row['cedula'];
                  $idTiempo = $row['Id_tiempo'];
                  $idDia = $row['Id_dia'];
                  $asignatura=$row['asignatura_nombre'];
                  $ACD=$row['ACD'];
                  $APE=$row['APE'];
                  $tp=$row['Tipo'];
                  $carrera=$row['carrera_nombre'];
                  $ciclo=$row['ciclo_nombre'];
                  if($hora== $idTiempo && $dia== $idDia)
                  {
                      
                    echo " $asignatura <br>";
                    echo "$tp <br>";
                    echo "$carrera <br>";
                    echo "$ciclo  <br>";
             
                       // Agregar botones de edición y eliminación
                    echo "<br>";
                    echo '<a href="#" class="edit-link" data-toggle="modal" data-target="#myModal" data-id="'.$idActividad .'" data-hora="' . $idTiempo . '" data-dia="' . $idDia . '" data-tipo="' . $tp . '" data-nombre="' . $asignatura . '" data-jornada="' . $jorna . '" data-carrera="' . $carrera . '" data-cedula="' . $cedula . '"><i class="fas fa-edit"></i> Edita </a>';
          
                  }
  
                  // Mostrar los resultados en la celda de la tabla
                 
              }
          } else {
              // No se encontraron registros para esta hora y día
              echo "Sin horario";
          }
  
          echo "</td>";
      }
  
      echo "</tr>";
  }
  
  echo "</table>";
  
   }
  
  
  echo '</div>';
  echo '</div>';
   
  $ci_anterior = $currentCI;
  }
 
}
}
elseif($opcionSeleccionada=='cursos')
{
    for ($curso = 1; $curso <= 20; $curso++)
    {
       
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
        WHERE carrera.Nom_carrera = '$carreraSeleccionada'
        AND cilco.Id_cilco = '$curso'";
        
// Ejecutar la consulta y obtener el resultado
$resultado = mysqli_query($conexion, $sqlcont);

// Verificar si la consulta se ejecutó correctamente
if ($resultado) {
    // Obtener el valor del conteo de filas
    $fila = mysqli_fetch_assoc($resultado);
    $cantidadFilas = $fila['cantidad_filas'];

    // Verificar si el conteo es diferente de cero
    if ($cantidadFilas != 0) {
        echo '<div class="container">';
        
        echo '<div class="table-container">';
        $sql = "SELECT Ciclo FROM cilco WHERE Id_cilco = '$curso'";

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
        
        echo '<div style="display: flex; justify-content: center; align-items: center; height: 10vh;">
        <h style="font-weight: bold;">' . $carreraSeleccionada . '  ' . strtoupper($ciclo) . ' "'. $nombrePeriodo.'</h>
    </div>';

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
        // Hacer algo si el conteo es diferente de cero
 
    
    echo "<table>";
    
    // Generar la fila de encabezado con los días
    echo "<tr>";
    echo "<th>Hora</th>";
    for ($dia = 1; $dia <= 7; $dia++) {
        echo "<th>" . obtenerNombreDia($dia) . "</th>";
    }
    echo "</tr>";
    
    // Recorrer las horas y generar las filas de la tabla
    for ($hora = 7; $hora <= 22; $hora++) {
        echo "<tr>";
        echo "<td>" . ($hora < 10 ? "0" : "") . $hora . ":00 - " . ($hora < 10 ? "0" : "") . $hora . ":59</td>";    
        // Recorrer los días y generar las celdas de la tabla
        for ($dia = 1; $dia <= 7; $dia++) {
            echo "<td>";
    
            include '../conexion.php';
            // Realizar la consulta SQL para obtener los registros de horario que coincidan con el curso, hora y día actual
            $sql = "SELECT horario.Id_actividad,horario.Id_tiempo,horario.Id_dia,horario.Tipo,actividad.Id_actividad,actividad.CI,actividad.ACD,actividad.APE,actividad.HVIR,actividad.OAD,actividad.HG,
            actividad.HI,actividad.HVHPP, 
            asignaturaa.Nom_asignatura AS asignatura_nombre,
            actividad.CI AS cedula,
            carrera.Nom_carrera AS carrera_nombre,
            cilco.Ciclo AS ciclo_nombre,
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
            WHERE carrera.Nom_carrera = '$carreraSeleccionada'
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
                    $jorna= $row['jornada_nombre'];
                    $cedula=$row['cedula'];
                    $idActividad = $row['Id_actividad'];
                    $idTiempo = $row['Id_tiempo'];
                    $idDia = $row['Id_dia'];
                    $asignatura=$row['asignatura_nombre'];
                    $ACD=$row['ACD'];
                    $APE=$row['APE'];
                    $tp=$row['Tipo'];
                    $carrera=$row['carrera_nombre'];
                    $ciclo=$row['ciclo_nombre'];
                    if($hora== $idTiempo && $dia== $idDia)
                    {
                        
                        echo " $asignatura <br>";
                        echo "$tp <br>";
                        echo "$carrera <br>";
                        echo "$ciclo <br>";
                         
                                         
                         // Agregar botones de edición y eliminación
                         echo "<br>";
                         echo '<a href="#" class="edit-link" data-toggle="modal" data-target="#myModal" data-id="'.$idActividad .'" data-hora="' . $idTiempo . '" data-dia="' . $idDia . '" data-tipo="' . $tp . '" data-nombre="' . $asignatura . '" data-jornada="' . $jorna . '" data-carrera="' . $carrera . '" data-cedula="' . $cedula . '"><i class="fas fa-edit"></i> Edita </a>';
               
                    }
    
                    // Mostrar los resultados en la celda de la tabla
                   
                }
            } else {
                // No se encontraron registros para esta hora y día
                //echo "Sin horario";
            }
    
            echo "</td>";
        }
    
        echo "</tr>";
    }
    
    echo "</table>";
    } else {
        // Hacer algo si el conteo es cero
        
    }

    // Liberar los recursos del resultado
    mysqli_free_result($resultado);
} else {
    // Manejar el caso en que la consulta no se ejecutó correctamente
    echo "Error en la consulta: " . mysqli_error($conexion);
}


      
    
    
}
    
    
    echo '</div>';
    echo '</div>';
}
echo '</div>';
    

?>

<?php
print  $nombrePeriodo;
?>
<!-- Modal para editar el horario -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Editar Horario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm" action="actualizar_horario.php" method="post">
                    <input type="hidden" name="id_horario" id="id_horario" value="">
                    <input type="hidden" name="cedula" id="cedula" value="">
                    <input type="hidden" name="horasin" id="horasin" value="">
                    <input type="hidden" name="diasin" id="diasin" value="">
                    <input type="hidden" name="tipo" id="tipo" value="">
                    <label for="hora_inicio">Hora de inicio:</label>
                    <input type="text" name="hora_inicio" id="hora_inicio" value="">
                    <label for="dia">Dia:</label>
                    <input type="text" name="dia" id="dia" value="">
                    <label for="nomb">Nombre:</label>
                    <input type="text" name="nomb" id="nomb" value="" readonly>

                    <label for="jornada">Jornada:</label>
                    <input type="text" name="jornada" id="jornada" value="" readonly>

                    <label for="carrera">Carrera:</label>
                    <input type="text" name="carrera" id="carrera" value="" readonly>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="submitForm()">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Función para enviar el formulario cuando se haga clic en "Guardar cambios"
    function submitForm() {
        document.getElementById("editForm").submit();
    }

    // Función para mostrar los datos del horario en el modal cuando se haga clic en "Edita"
    $(document).on("click", ".edit-link", function () {
        // Obtener los datos del enlace usando los atributos data
        var idHorario = $(this).data("id");
        var horaInicio = $(this).data("hora");
        var horaFin = $(this).data("hora"); // Puedes cambiarlo a $(this).data("hora_fin") si es necesario
        var idDia = $(this).data("dia");
        var tp = $(this).data("tipo");
        var asignatura = $(this).data("nombre");
        var jornada = $(this).data("jornada");
        var carrera=$(this).data("carrera");
        var cedula=$(this).data("cedula");
        var tipo=$(this).data("tipo");

        // Asignar los datos al formulario del modal
        $("#id_horario").val(idHorario);
        $("#diasin").val(idDia);
        $("#dia").val(idDia);
        $("#hora_inicio").val(horaFin);
        $("#horasin").val(horaFin);
        $("#nomb").val(asignatura);
        $("#jornada").val(jornada);
        $("#carrera").val(carrera);
        $("#cedula").val(cedula);
        $("#tipo").val(tipo);

        // Aquí puedes hacer lo mismo para otros campos del formulario si es necesario

    });
</script>


 <script>
function habilitarRadioButtons() {
    var selectCarrera = document.getElementsByName('carrera')[0];
    var radioButtons = document.getElementsByName('opcion');

    if (selectCarrera.value !== '') {
        for (var i = 0; i < radioButtons.length; i++) {
            radioButtons[i].disabled = false;
        }
    } else {
        for (var i = 0; i < radioButtons.length; i++) {
            radioButtons[i].disabled = true;
        }
    }
}

</script>



<!--Con este código, los radio buttons estarán deshabilitados inicialmente, y se habilitarán automáticamente una vez que el usuario seleccione una carrera del menú desplegable. Si no se selecciona ninguna carrera, los radio buttons permanecerán deshabilitados.-->
 <form method="post" action="exportar.php">
    <input type="hidden" name="carrera" value="<?php echo $carreraSeleccionada; ?>">
    <input type="hidden" name="radiobtn" value="<?php echo $opcionSeleccionada; ?>">
    <input type="hidden" name="periodo" value="<?php echo $_SESSION['school_period']; ?>">
    <input type="submit" name="generar" value="EXPORTAR">
</form>
</body>
</html>

