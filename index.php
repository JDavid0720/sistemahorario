<?php
session_start();

header('Content-Type: text/html; charset=UTF-8');

include_once 'modules/conexion.php';
include_once 'modules/cookie.php';


if (!empty($_SESSION['authenticate']) == 'go-' . !empty($_SESSION['usuario'])) {
	header('Location: home');
	exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<div class="menu-mobile"> 
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1" />
		<meta name="google" value="notranslate">
		<link rel="icon" type="image/ico" href="/sistemaHorario/images/logoutc.ico" />
		<title>Sistema Horarios UTC</title>
		<meta name="description" content="Sistema Escolar, gestión de asistencias." />
		<meta name="keywords" content="Sistema Escolar, Asistencias, Alumnos, Docentes, Administrativos, Sistema de Asistencias, MySoftUP, Diego, Carmona, Bernal, Diego Carmona Bernal, Gestión de Asistencias" />
		<link rel="stylesheet" href="/sistemaHorario/css/style.css?v=<?php echo(rand()); ?>" media="screen, projection" type="text/css" />
		<link rel="stylesheet" href="/sistemaHorariocss/pretty-checkbox.css" media="screen, projection" type="text/css" />
		<script src="/sistemaHorario/js/external/jquery.min.js" type="text/javascript"></script>
		<script src="/sistemaHorario/js/external/prefixfree.min.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(window).load(function() {
				$(".loader").fadeOut("slow");
			});
		</script>
	</head>
</div>
<body class="login">
	<div class="loader"></div>
	<div class="wrap-title-login">
		<div class="title-login">
			<h1 class="title-login">SISTEMA GESTION DE HORARIOS</h1>
			
		</div>
	</div>
	<div class="form-login">
		<div class="logo-form-login">
		</div>
		<form name="form-login" action="" method="POST" autocapitalize="off" data-nosnippet>
			<?php
			include_once 'modules/login/logger.php';
			
			?>
		</form>
		
	</div>
	
</body>

<footer>
	"Creado por Bryan y Acxel"
</footer>
<script src="/sistemaHorario/js/controls/buttons.js" type="text/javascript"></script>

</html>