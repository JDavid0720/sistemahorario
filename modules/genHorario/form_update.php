<?php
//require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');

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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
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
            margin-top: 10px;
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
		 /* Estilos para el formulario */
		 .form-container {
            display: flex; /* Mostrar los elementos en línea */
            flex-wrap: wrap; /* Permitir que los elementos se envuelvan en pantallas pequeñas */
            justify-content: space-between; /* Espacio entre los elementos en la dirección principal */
        }

        .form-container label,
        .form-container input[type="text"],
        .form-container input[type="submit"] {
            width: calc(33.33% - 10px); /* 33.33% de ancho para cada input con espacio entre ellos */
            margin-bottom: 10px; /* Espacio entre los elementos en la dirección secundaria */
        }

        .form-container input[type="submit"] {
            width: 100%; /* Ancho completo para el botón de enviar */
        }

        /* Estilo para la tabla */
        .horarios-table-container {
            margin-top: 10px; /* Ajustar el margen superior */
            width: 100%; /* Ancho de la tabla al 100% */
        }

        .horarios-table {
            width: 100%; /* Ancho de la tabla al 100% */
            table-layout: fixed; /* Fijar el ancho de las columnas */
        }

        .horarios-table th,
        .horarios-table td {
            width: calc(100% / 8); /* Distribuir el ancho de las celdas uniformemente en 8 columnas */
            padding: 8px; /* Aumentar el tamaño de las celdas */
            text-align: center; /* Alinear el contenido al centro */
            border: 1px solid #ddd; /* Borde de las celdas */
            font-size: 10px; /* Ajustar el tamaño de la fuente */
        }

        /* Estilo para centrar los íconos en las celdas */
        .icon-cell {
            /* ... */
        }

        /* Estilo para ajustar el tamaño de los íconos */
        .icon-cell i {
            /* ... */
        }

        /* Estilo adicional si es necesario */
        @media screen and (max-width: 768px) {
            /* ... */
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