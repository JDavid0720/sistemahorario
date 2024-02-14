<?php
include_once '../security.php';
include_once '../conexion.php';

header('Content-Type: text/html; charset=UTF-8');
header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');
header('Cache-Control: no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');


?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1" />
	<meta name="robots" content="noindex">
	<meta name="google" value="notranslate">
	<link rel="icon" type="image/ico" href="/sistemaHorario/images/logoutc.ico" />
	<title> Editar Horarios | Sistema de Gestion de Horarios</title>
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
     <title>Editar Materia</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

   
    <style>
        body {
            margin: 0;
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .content {
            width: 70vw; /* Ocupar el 50% del ancho de la ventana */
            display: flex;
            flex-wrap: wrap; /* Permitir que los elementos se envuelvan en pantallas pequeñas */
            justify-content: space-around; /* Espacio entre los elementos en la dirección principal */
            align-items: flex-start; /* Alinear los elementos arriba */
        }

        .form-container {
            max-width: 250px;
            padding: 15px;
        }

        .form-container h2 {
            margin-bottom: 15px;
            color: #007BFF;
        }

        .form-container label {
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        .form-container input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-container input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 16px;
        }

        .form-container input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .horarios-table-container {
            flex: 1;
            width: 70%; /* Ancho de la tabla ajustado al 70% del contenedor */
            max-width: 800px; /* Ancho máximo de la tabla */
            margin: 20px; /* Agregar un margen para separar de otros elementos */
        }

        .horarios-table {
            border-collapse: collapse;
            width: 100%;
        }

        .horarios-table th,
        .horarios-table td {
            border: 1px solid #ccc;
            padding: 12px; /* Aumentar el tamaño de las celdas */
            text-align: center;
            background-color: #fff;
            font-size: 16px; /* Aumentar el tamaño del texto */
        }

        .horarios-table th {
            background-color: #007BFF;
            color: #fff;
        }

        @media screen and (max-width: 800px) {
            .content {
                width: 100%; /* En pantallas pequeñas, ocupa todo el ancho */
                padding: 10px; /* Agregar un poco de espacio entre los elementos */
            }

            .horarios-table-container {
                margin-top: 20px; /* Ajustar el margen superior */
                width: 100%; /* Ancho de la tabla al 100% en pantallas pequeñas */
                max-width: none; /* Eliminar el ancho máximo en pantallas pequeñas */
            }
        }
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
		
		
<?php
// Tu código PHP aquí
?>

<div class="container">
    <div class="content">
        <div class="form-container">
            <h2>Editar Materia</h2>
            <form method="post">
                <label>Nombre:</label>
                <input type="text" name="nom_carrera" value="<?php echo $_GET['nombre']; ?>">
                <label>ID Tiempo:</label>
                <input type="text" name="id_tiempo" value="<?php echo $_GET['hora']; ?>">
                <label>ID Día:</label>
                <input type="text" name="id_dia" value="<?php echo $_GET['dia']; ?>">
                <label>Tipo:</label>
                <input type="text" name="tipo" value="<?php echo $_GET['tipo']; ?>">
                <input type="submit" value="Guardar Cambios">
            </form>
        </div>

        <div class="horarios-table-container">
            <table class="horarios-table">
                <tr>
                    <th>Hora</th>
                    <th>Lunes</th>
                    <th>Martes</th>
                    <th>Miércoles</th>
                    <th>Jueves</th>
                    <th>Viernes</th>
                    <th>Sábado</th>
                    <th>Domingo</th>
                </tr>
                <?php
                // Generar filas con las horas de 7 a 22
                for ($hora = 7; $hora <= 22; $hora++) {
                    echo "<tr>";
                    echo "<td>$hora:00</td>";
                    // Generar celdas vacías para cada día de la semana
                    for ($dia = 1; $dia <= 7; $dia++) {
                        echo "<td>
                        </td>";
                        
                        
                    }
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>
</div>


	</section>
</body>
<script src="/sistemaHorario/js/controls/buttons.js" type="text/javascript"></script>

</html>