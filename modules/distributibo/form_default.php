<?php
require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');
?>
<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <title>Información Docente</title>
    <style>
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

    /* Estilos para tablas */
    .table-container {
        max-width: 1000px;
        overflow-x: auto; /* Habilita el desplazamiento horizontal si el contenido es más ancho que el contenedor */
        margin-top: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
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

    /* Estilos responsivos */
    @media (max-width: 600px) {
        ul.horizontal-list li {
            width: 100%;
        }
    }
    .cancel-edit-button {
        background-color: #e74c3c;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        display: none;
    }

    .cancel-edit-button i {
        margin-right: 8px;
    }

    .cancel-edit-button:hover {
        background-color: #c0392b;
    }
    .styled-button {
    background-color: #0074D9;
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
}

.styled-button:hover {
    background-color: #0056b3;
}

body {
    font-family: Arial, sans-serif;
}

h2 {
    color: #333;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"] {
    padding: 8px;
    width: 200px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

/* Estilo para los botones */
button[type="submit"],
button[type="button"] {
    padding: 8px 15px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

button[type="submit"]:hover,
button[type="button"]:hover {
    background-color: #0056b3;
}

/* Estilo para el contenedor de botones */
.button-container {
    display: flex;
    gap: 10px;
    align-items: center;
    margin-top: 5px;
}


    
</style>


</head>
<body>
       <script>
        function borrarDatos() {
            if (confirm("¿Estás seguro de que quieres borrar todos los datos de la tabla?")) {
                document.getElementById("borrar_form").submit();
            }
        }
        function funciona() {
            if (confirm("se cargaron los datos correctamente")) {
                
            }
        }
    </script>
<h2>Buscar Docente</h2>
<div class="button-container">
<form method="POST">
        <label for="dato">Ingresa el docente a buscar:</label>
        <input type="text" id="dato" name="dato" >
        <button type="submit">Buscar</button>
</form>
<form id="borrar_form" method="post" action="eliminartodo.php">
    <!-- Botón con estilo -->
    <button type="button" class="btn" onclick="borrarDatos()">Borrar Todos los Datos</button>
    <input type="hidden" name="borrar_datos" value="1">
</form>
<form id="form" action="../n/distributivo.html" method="POST">
    <button class="btn btn-load-data" name="btn" value="load_data" type="submit">Cargar Datos</button>
</form>

<script>
    document.querySelector('.btn-load-data').addEventListener('click', function(e) {
        e.preventDefault(); // Evitar que el formulario se envíe automáticamente
        
        // Mostrar mensaje de confirmación
        if (confirm('¿Estás seguro de que deseas borrar los distributivos registrados?')) {
            // Hacer solicitud AJAX para borrar datos
            var xhr = new XMLHttpRequest();
            xhr.open('GET', './eliminartodo.php', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    //alert(xhr.responseText); // Mostrar mensaje de éxito o error
                    document.getElementById('form').submit(); // Enviar el formulario después de borrar datos
                } else {
                    alert('Error al borrar datos');
                }
            };
            xhr.send();
        } else {
            // Si el usuario cancela, no hacemos nada
        }
    });
</script>

<form id="creardistri" method="post" action="crearactividad.php">
    <!-- Botón con estilo -->
    <button type="submit" id="crearBtn" class="btn <?php if (isTablaActividadVacia()) echo 'visible'; ?>">Crear distributivo</button>
</form>
    </div>
<?php
function isTablaActividadVacia() {
    // Configurar la conexión a la base de datos
  
    include  '../conexion.php';
    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    // Realizar una consulta para verificar si la tabla actividad está vacía
    $sql = "SELECT COUNT(*) as count FROM actividad";
    $result = $conexion->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row["count"] == 0) {
            return false; // La tabla está vacía
        }
    }

    
    return true; // La tabla no está vacía
}
?>

<?php
// Función para borrar todos los datos de la tabla "actividad"

// Obtener la cantidad de docentes
$totalDocentes = count($_SESSION['Id_actividad']);
$ci_anterior = '';
// Iterar sobre cada docente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $datoBuscado = $_POST["dato"];
}
if (!empty($datoBuscado)) 
{
           
        for ($i = 0; $i < 1; $i++) {
          
              
              
          
              $sql = "SELECT docente.CI, docente.ApellidoNombre, docente.Titulo_cuarto, docente.dedicacion, docente.Contrato, carrera.Nom_carrera AS carrera_nombre
              FROM docente
              INNER JOIN carrera ON carrera.Id_carrera = docente.Id_carrera
              WHERE docente.CI = '" . mysqli_real_escape_string($conexion, $datoBuscado) . "'
                 OR docente.ApellidoNombre LIKE '%" . mysqli_real_escape_string($conexion, $datoBuscado) . "%'";
                    $result = mysqli_query($conexion, $sql);
              $row = mysqli_fetch_assoc($result);
              if($row>0)
              {
                $ci = $row['CI'];
                echo '<h1>Información Docente</h1>';
              $rc=$row['CI'];
              $nombreDocente = $row['ApellidoNombre'];
              $Titulo4 = $row['Titulo_cuarto'];
              $dedicacion = $row['dedicacion'];
              $Contrato = $row['Contrato'];
              $carrera = $row['carrera_nombre'];
             
              echo '<h2>Encabezado</h2>';
              echo '<ul class="horizontal-list">';
              echo '<li>';
              echo 'Cédula de Identidad: <br>';
              echo '<input type="text" value="' .$rc. '"></li>';
              echo '</li>';
              echo '<li>';
              echo 'Docente:';
              echo '<br>';
              // Realizar la consulta SQL para obtener el nombre del docente según el CI
           
          
              // Mostrar el input con la información del docente
              echo '<input type="text" value="' . $nombreDocente . '">';
             
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
          $nombreBotonEditar = "Agregar Actividad";
          $paginaEdicion = "form_add"; // Cambia esto a la URL de la página de edición
          $parametro = $ci; // Cambia esto al valor del parámetro que deseas enviar
          
          echo '<form method="post" action="' . $paginaEdicion . '">';
          echo '<input type="hidden" name="param" value="' . $parametro . '">';
         /// echo '<button type="submit" class="styled-button">' . $nombreBotonEditar . '</button>';
          echo '</form>';
          
          
          echo '<div class="container">';
          echo '<div class="table-container">';
          echo '<table class="table-container ">';
          
          echo '
          <thead>
              <tr>
                  <th>Facultad / Extensión</th>
                  <th>Carrera</th>
                  <th>Ciclo / Nivel</th>
                  <th>Malla</th>
                  <th>Asignatura / Actividad</th>
                  <th>Actividad Específica</th>
                  <th>Jornada</th>
                  <th>Horas Teóricas (ACD)</th>
                  <th>Horas Prácticas (APE)</th>
                  <th>Horas Virtuales (HVIR)</th>
                  <th>Total Horas Clase</th>
                  <th>OAD</th>
                  <th>HG</th>
                  <th>HI</th>
                  <th>HVHPP</th>
                  <th>Total H.</th>
                  <th>Opciones.</th>
              </tr>
          </thead>';
          
          echo '<tbody>';
          
          // Iterar sobre las asignaturas del docente actual
          $totalAsignaturas = count($_SESSION["CI"]);
          for ($j = 0; $j < $totalAsignaturas; $j++) {
              if ($_SESSION["CI"][$j] === $ci) {
                  echo '
                  <tr>
                      <td>' . $_SESSION["Facultad"][$j] . '</td>
                      <td>' . $_SESSION["Carrera"][$j] . '</td>
                      <td>' . $_SESSION["Ciclo"][$j] . '</td>
                      <td>' . $_SESSION["Malla"][$j] . '</td>
                      <td>' . $_SESSION["Id_asignatura"][$j] . '</td>
                      <td>' . $_SESSION["Id_actividadEspecifica"][$j] . '</td>
                      <td>' . $_SESSION["Id_Jornada"][$j] . '</td>
                      <td>' . $_SESSION["ACD"][$j] . '</td>
                      <td>' . $_SESSION["APE"][$j] . '</td>
                      <td>' . $_SESSION["HVIR"][$j] . '</td>
                      <td>' . $_SESSION["Total Horas Clases"][$j] . '</td>
                      <td>' . $_SESSION["OAD"][$j] . '</td>
                      <td>' . $_SESSION["HG"][$j] . '</td>
                      <td>' . $_SESSION["HI"][$j] . '</td>
                      <td>' . $_SESSION["HVHPP"][$j] . '</td>
                      <td>' . $_SESSION["Total H."][$j] . '</td>
                      <td>
                      <button class="delete-button" data-id="' . $_SESSION["Id_actividad"][$j] . '"><span class="fas fa-trash"></span></button>            <a href="form_update.php?id=' . $_SESSION["Id_actividad"][$j] . '" class="edit-link"><span class="fas fa-edit"></span></a>
                      <button class="cancel-edit-button" style="display: none;">Cancelar</button>
                      <button class="save-button" style="display: none;">Guardar</button>
                  </td>
                  
                  </tr>';
              }
          }
          
          echo '</tbody>';
          echo '</table>';
          //echo '<button id="agregarFila">Agregar Fila</button>';
          
          echo '</div>';
          echo '</div>';
          
            }
        
           
          }
  
}
else
{
for ($i = 0; $i < $totalDocentes; $i++) {
    $currentCI = $_SESSION["CI"][$i];
    if($currentCI != $ci_anterior)
    {
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
  
      // Mostrar el input con la información del docente
      echo '<input type="text" value="' . $nombreDocente . '">';
     
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
  $nombreBotonEditar = "Agregar Actividad";
  $paginaEdicion = "form_add"; // Cambia esto a la URL de la página de edición
  $parametro = $ci; // Cambia esto al valor del parámetro que deseas enviar
  
  echo '<form method="post" action="' . $paginaEdicion . '">';
  echo '<input type="hidden" name="param" value="' . $parametro . '">';
 // echo '<button type="submit" class="styled-button">' . $nombreBotonEditar . '</button>';
  echo '</form>';
  
  
  echo '<div class="container">';
  echo '<div class="table-container">';
  echo '<table class="table-container ">';
  
  echo '
  <thead>
      <tr>
          <th>Facultad / Extensión</th>
          <th>Carrera</th>
          <th>Ciclo / Nivel</th>
          <th>Malla</th>
          <th>Asignatura / Actividad</th>
          <th>Actividad Específica</th>
          <th>Jornada</th>
          <th>Horas Teóricas (ACD)</th>
          <th>Horas Prácticas (APE)</th>
          <th>Horas Virtuales (HVIR)</th>
          <th>Total Horas Clase</th>
          <th>OAD</th>
          <th>HG</th>
          <th>HI</th>
          <th>HVHPP</th>
          <th>Total H.</th>
          <th>Opciones.</th>
      </tr>
  </thead>';
  
  echo '<tbody>';
  
  // Iterar sobre las asignaturas del docente actual
  $totalAsignaturas = count($_SESSION["CI"]);
  for ($j = 0; $j < $totalAsignaturas; $j++) {
      if ($_SESSION["CI"][$j] === $ci) {
          echo '
          <tr>
              <td>' . $_SESSION["Facultad"][$j] . '</td>
              <td>' . $_SESSION["Carrera"][$j] . '</td>
              <td>' . $_SESSION["Ciclo"][$j] . '</td>
              <td>' . $_SESSION["Malla"][$j] . '</td>
              <td>' . $_SESSION["Id_asignatura"][$j] . '</td>
              <td>' . $_SESSION["Id_actividadEspecifica"][$j] . '</td>
              <td>' . $_SESSION["Id_Jornada"][$j] . '</td>
              <td>' . $_SESSION["ACD"][$j] . '</td>
              <td>' . $_SESSION["APE"][$j] . '</td>
              <td>' . $_SESSION["HVIR"][$j] . '</td>
              <td>' . $_SESSION["Total Horas Clases"][$j] . '</td>
              <td>' . $_SESSION["OAD"][$j] . '</td>
              <td>' . $_SESSION["HG"][$j] . '</td>
              <td>' . $_SESSION["HI"][$j] . '</td>
              <td>' . $_SESSION["HVHPP"][$j] . '</td>
              <td>' . $_SESSION["Total H."][$j] . '</td>
              <td>
              <button class="delete-button" data-id="' . $_SESSION["Id_actividad"][$j] . '"><span class="fas fa-trash"></span></button>            <a href="form_update.php?id=' . $_SESSION["Id_actividad"][$j] . '" class="edit-link"><span class="fas fa-edit"></span></a>
              <button class="cancel-edit-button" style="display: none;">Cancelar</button>
              <button class="save-button" style="display: none;">Guardar</button>
          </td>
          
          </tr>';
      }
  }
  
  echo '</tbody>';
  echo '</table>';
  //echo '<button id="agregarFila">Agregar Fila</button>';
  
  echo '</div>';
  echo '</div>';
  $ci_anterior = $currentCI;
    }
   
  }
}
?>
<script>
    const deleteButtons = document.querySelectorAll('.delete-button');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = button.getAttribute('data-id');
            if (confirm('¿Estás seguro de que deseas borrar esta información?')) {
                window.location.href = 'delete.php?id=' + id;
            }
        });
    });
</script>
</body>
</html>
