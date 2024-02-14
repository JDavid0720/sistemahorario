<?php
require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');

$_SESSION['subject'] = array();
$_SESSION['subject_name'] = array();
$_SESSION['subject_semester'] = array();
$_SESSION['subject_career'] = array();
$_SESSION['subject_malla'] = array();
$_SESSION['subject_paralelo'] = array();


	$sql="SELECT asignaturaa.Id_asignatura,asignaturaa.Nom_asignatura,carrera.Nom_carrera As carrera_nombre, cilco.Ciclo AS cilco_nombre, malla.Nom_malla AS malla_nombre
	,cilco.paralelo As paralelo
	FROM asignaturaa 
	INNER JOIN carrera ON asignaturaa.Id_carrera = carrera.Id_carrera 
	INNER JOIN cilco  ON asignaturaa.Id_cilco = cilco.Id_cilco
	INNER JOIN malla   ON asignaturaa.Id_malla= malla.Id_malla
    WHERE Id_asignatura='" . $_POST['txtsubject'] . "'
	ORDER BY cilco.Ciclo , carrera.Nom_carrera , asignaturaa.Nom_asignatura, malla.Nom_malla ";
    $i = 0;
    if ($result = $conexion->query($sql)) {
        while ($row = mysqli_fetch_array($result)) {
            $_SESSION['subject'][$i] = $row['Id_asignatura'];
            $_SESSION['subject_name'][$i] = $row['Nom_asignatura'];
            $_SESSION['subject_semester'][$i] = $row['cilco_nombre'];
            $_SESSION['subject_career'][$i] = $row['carrera_nombre'];
            $_SESSION['subject_malla'][$i] = $row['malla_nombre'];
            $_SESSION['subject_paralelo'][$i] = $row['paralelo'];
            
            $i++; // Incrementa el valor de $i en cada iteración
        }
    }
            

echo '<div class="content-aside">';
include_once "../sections/options-disabled.php";
echo '
</div>
<script src="/js/controls/dataexpandable.js"></script>
<script src="/js/modules/updatesubject.js"></script>
';
// ...

// Aquí va tu conexión a la base de datos
// $conexion = mysqli_connect(...);

// ...

// Verificamos si se ha enviado el formulario de actualización

?>
<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Actualización de Asignatura</title>
	<style>
        body {
            font-family: Arial, sans-serif;
        }

        #formulario-container {
            background-color: #f1f1f1; /* Gris claro */
            color: #000; /* Texto negro */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-gap: 20px;
        }

        #formulario-container h1 {
            color: #000; /* Texto negro */
            grid-column: 1 / -1;
            text-align: center;
            margin-bottom: 30px;
        }

        #formulario-container label {
            color: #000; /* Texto negro */
            display: block;
            margin-bottom: 5px;
        }

        /* Estilos para todos los inputs y selects */
        #formulario-container input[type="text"],
        #formulario-container select {
            background-color: #fff; /* Blanco */
            color: #000; /* Texto negro */
            border: 1px solid #000; /* Borde negro */
            padding: 10px; /* Ajustar el padding para aumentar el tamaño */
            border-radius: 5px;
            width: 100%;
            margin-bottom: 15px;
            box-sizing: border-box; /* Asegurar que el ancho incluya el padding */
        }

        /* Estilos para las opciones dentro del select */
        #formulario-container select option {
            background-color: #f1f1f1; /* Gris claro */
            color: #000; /* Texto negro */
        }

        #formulario-container input[type="submit"] {
            background-color: #000; /* Fondo negro */
            color: #fff; /* Texto blanco */
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            grid-column: 1 / -1;
            justify-self: center;
        }
    </style>
</head><body>
    <div id="formulario-container">
        <h1>ACTUALIZAR ASIGNATURA</h1>
        <form action="update.php" method="post">
            <label for="nombre">Nombre de la asignatura:</label>
            <input type="text" name="nombre" value="<?php echo $_SESSION['subject_name'][0]; ?>"><br>

            <label for="semestre">Semestre:</label>
            <select name="semestre">
                <?php
                // Conexión a la base de datos (asume que ya tienes la conexión)
                // Supongamos que tienes una tabla llamada "semestres" con un campo "nombre"
                $sql = "SELECT * FROM cilco";
                $result = mysqli_query($conexion, $sql);

                // Iterar sobre los resultados y crear las opciones del select
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['Id_cilco'] . '">' . $row['Ciclo'] . '  ' . $row['paralelo'] . '</option>';
                }
                ?>
            </select><br>

            <label for="carrera">Carrera:</label>
            <select name="carrera">
                <?php
                // Supongamos que tienes una tabla llamada "carreras" con un campo "nombre"
                $sql = "SELECT * FROM carrera";
                $result = mysqli_query($conexion, $sql);

                // Iterar sobre los resultados y crear las opciones del select
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['Id_carrera'] . '">' . $row['Nom_carrera'] . '</option>';
                }
                ?>
            </select><br>

            <label for="malla">Malla:</label>
            <select name="malla">
                <?php
                // Supongamos que tienes una tabla llamada "mallas" con un campo "nombre"
                $sql = "SELECT * FROM malla";
                $result = mysqli_query($conexion, $sql);

                // Iterar sobre los resultados y crear las opciones del select
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['Id_malla'] . '">' . $row['Nom_malla'] . '</option>';
                }
                ?>
            </select><br>


            <input type="submit" name="update" value="Actualizar">
        </form>
    </div>
</body>
</html>


