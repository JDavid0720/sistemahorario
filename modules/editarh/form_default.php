<!DOCTYPE html>
<html>
<head>
    <title>Información Docente</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    
    <style>
           table {
        width: 100%; /* Ancho total de la tabla (ajusta el tamaño de acuerdo al contenedor) */
        table-layout: fixed; /* Fija el ancho de las columnas */
    }

    table td {
        width: 100px; /* Ancho de las celdas (puedes cambiar el valor según tus necesidades) */
        padding: 8px; /* Espacio de relleno dentro de cada celda */
        border: 1px solid #ddd; /* Borde de las celdas */
        text-align: center; /* Alineación del contenido en el centro de las celdas */
        font-size: 10px; /* Puedes ajustar el tamaño de letra según tus necesidades */
    }
       /* Estilo para centrar los íconos en las celdas */
    .icon-cell {
        display: flex;
        justify-content: center; /* Centra horizontalmente el contenido en la celda */
        align-items: center; /* Centra verticalmente el contenido en la celda */
        height: 50px; /* Ajusta la altura de la celda para centrar verticalmente el contenido */
    }

    /* Estilo para ajustar el tamaño de los íconos */
    .icon-cell i {
        font-size: 24px; /* Tamaño del ícono, puedes ajustarlo según tus preferencias */
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
<!-- Campos de entrada (input) para mostrar la información -->
<h2>Información Docente</h2>
<ul class="horizontal-list">
    <li>
        Cédula de Identidad: <br>
        <input type="text" id="id-actividad" readonly>
    </li>
    <li>
        Docente: <br>
        <input type="text" id="hora-seleccionada" readonly>
    </li>
    <!-- Otros campos de entrada para la información del docente -->
</ul>

<!-- Agregar el script JavaScript -->
<script>
    // Función que se ejecuta al hacer clic en una celda del horario
    function onClickHorario(idActividad, hora, dia) {
        // Obtener la celda haciendo referencia a la hora y el día
        var celda = document.querySelector(`#horario-${hora}-${dia}`);

        // Obtener la información de la celda (por ejemplo, el contenido de la celda)
        var contenidoCelda = celda.innerText;

        // Actualizar los campos de entrada con la información obtenida
        document.getElementById('id-actividad').value = idActividad;
        document.getElementById('hora-seleccionada').value = hora;
        //document.getElementById('dia-seleccionado').value = dia;
        //document.getElementById('contenido-celda').value = contenidoCelda;
    }
</script>
<?php 
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
    echo "<td>" . ($hora < 10 ? "0" : "") . $hora . ":00</td>";

    // Recorrer los días y generar las celdas de la tabla
    for ($dia = 1; $dia <= 7; $dia++) {
        echo "<td>";

        // Realizar la consulta SQL para obtener los registros de horario que coincidan con la hora y el día actual
        $sql = "SELECT horario.Id_actividad,horario.Id_tiempo,horario.Id_dia,horario.Tipo,actividad.Id_actividad,actividad.CI,actividad.ACD,actividad.APE,actividad.HVIR,actividad.OAD,actividad.HG,
        actividad.HI,actividad.HVHPP,
        docente.CI AS ciDo, 
        asignaturaa.Nom_asignatura As asignatura_nombre, 
        carrera.Nom_carrera As carrera_nombre, 
        cilco.Ciclo AS ciclo_nombre,
        cilco.paralelo AS ciclo_paralelo ,
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
            WHERE actividad.CI='1719715375'
            ORDER BY horario.Id_actividad";
        $result = $conexion->query($sql);

        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            // Mostrar los datos de los registros encontrados
            while ($row = $result->fetch_assoc()) {
                // Acceder a los campos de la tabla horario
                $ciDo=$row['ciDo'];
                $idActividad = $row['Id_actividad'];
                $idTiempo = $row['Id_tiempo'];
                $idDia = $row['Id_dia'];
                $asignatura=$row['asignatura_nombre'];
                $ACD=$row['ACD'];
                $APE=$row['APE'];
                $tp=$row['Tipo'];
                $carrera=$row['carrera_nombre'];
                $ciclo=$row['ciclo_nombre'];
                $paralelo=$row['ciclo_paralelo'];
                if($hora== $idTiempo && $dia== $idDia)
                {
                    
                    echo " $asignatura <br>";
                    echo "$tp <br>";
                    echo "$carrera <br>";
                    echo "$ciclo,-- $paralelo  <br>";
                    
                     // Agregar botones de edición y eliminación
                     echo "<br>";
                     
                     // Supongamos que tienes las variables $idActividad, $dias y $hora
                     
                     // Generar los enlaces con las variables adicionales
                     
                     
           
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

 


echo '</div>';
echo '</div>';
 


    
    echo '</div>';
    echo '</div>';

echo '</div>';
    

?>
<!-- Formulario para enviar la información al servidor -->
<form method="post" action="guardar_informacion.php">
    <!-- Campos ocultos para enviar la información seleccionada al servidor -->
    <input type="hidden" name="id_actividad" id="id-actividad-enviar">
    <input type="hidden" name="hora_seleccionada" id="hora-seleccionada-enviar">

    <!-- Agregar aquí otros campos de entrada necesarios para el formulario -->
    
    <input type="submit" value="Guardar">
</form>

<?php
print  $nombrePeriodo;
?>
 </div>

</html>

