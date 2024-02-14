<?php
include_once '../conexion.php';

// Consulta para contar registros en la tabla
$query = "SELECT COUNT(*) as count FROM actividad";
$result = $conexion->query($query);

if ($result) {
    $row = $result->fetch_assoc();
    $rowCount = $row['count'];

    if ($rowCount == 0) {
        
$ultimaActividadId ='1';
// Realiza la consulta SQL para obtener los datos de CI de la tabla docente
$sqlDocente = "SELECT CI FROM docente"; // Ajusta la consulta según tu estructura de tabla
$resultDocente = mysqli_query($conexion, $sqlDocente);

// Verifica si la consulta se realizó correctamente
if ($resultDocente) {
   while ($rowDocente = mysqli_fetch_assoc($resultDocente)) {
       $ciDocente = $rowDocente['CI'];
      
       // Insertar una nueva actividad con el CI del docente
       $sqlact = "INSERT INTO actividad(Id_actividad, CI) VALUES('" . $ultimaActividadId . "','" . $ciDocente . "')";
       mysqli_query($conexion, $sqlact);
       $ultimaActividadId++;
   }

   // Cierra el resultado
   mysqli_free_result($resultDocente);
   echo '<script type="text/javascript">';
   echo 'alert("Distributivos agregados.");';
   echo 'window.location.href = "index.php";'; // Redirigir al usuario a index.php
   echo '</script>';
} else {
   // Maneja el error de la consulta
   echo "Error en la consulta docente: " . mysqli_error($conexion);
}

    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Ya estan agregados los distributivos.");';
        echo 'window.location.href = "index.php";'; // Redirigir al usuario a index.php
        echo '</script>';
    }
} else {
    echo "Error al ejecutar la consulta: " . $conexion->error;
}

					
?>