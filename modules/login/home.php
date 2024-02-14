<?php
header('Content-Type: text/html; charset=UTF-8');

if (include_once './modules/security.php') {
    $_SESSION['raiz'] = dirname(__FILE__);
}
include_once './modules/conexion.php';
include_once './modules/notif_info_unset.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1" />
    <meta name="robots" content="noindex">
    <meta name="google" value="notranslate">
    <link rel="icon" type="image/ico" href="/sistemaHorario/images/logoutc.ico" />
    <title>Sistema de Horarios</title>
    <style>
        .container_uni {
            text-align: center;
        }
        .container_uni img {
            max-width: 100%;
            height: auto;
        }
        .container_uni h1 {
            margin: 20px 0;
        }
        
        .container_uni h1 {
            color: darkblue;
            margin: 20px 0;
        }

        .container_uni h2 {
            color: darkblue;
        }
        .container_uni p {
            text-align: justify;
        }
    </style>
    <meta name="description" content="Sistema Escolar, gestión de asistencias." />
    <link rel="stylesheet" href="/sistemaHorario/css/style.css?v=<?php echo (rand()); ?>" media="screen, projection" type="text/css" />
    <script src="/sistemaHorario/js/external/jquery.min.js" type="text/javascript"></script>
    <script src="/sistemaHorario/js/external/prefixfree.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(window).load(function() {
            $(".loader").fadeOut("slow");
        });
    </script>
</head>

<body>
    <div class="loader"></div>
    <header class="header">
        <?php
        include_once "./modules/sections/section-info-title.php";
        ?>
          <div class="container_uni">
        <h1>Universidad Tecnica de Cotopaxi Extension La Maná</h1>
        <h2>Aplicativo web para la gestion de horarios</h2>
        <a href="https://www.utc.edu.ec/utc/lamana" target="_blank">
            <img src="https://www.utc.edu.ec/Portals/0/BELEN/PDF/BANNERS%202020/laMANA.jpg" alt="Imagen de la universidad">
        </a>
        <h2>Misión:</h2>
        <p>La Universidad Técnica de Cotopaxi, forma profesionales de excelencia, humanistas e investigadores; genera ciencia y tecnología; vinculada con la sociedad mediante la transferencia y difusión del conocimiento, arte y cultura para contribuir en la transformación social y económica del país.</p>

        <h2>Visión:</h2>
        <p>Ser una universidad de docencia con liderazgo nacional en la formación de profesionales, generación científica, tecnológica y de vinculación con la sociedad; en un marco de alianzas estratégicas nacionales e internacionales.</p>
    </div>
    </header>
    <aside class="aside">
        <?php
        if (!empty($_SESSION['section-admin']) == 'go-' . $_SESSION['user']) {
            include_once './modules/sections/section-admin.php';
        } elseif (!empty($_SESSION['section-editor']) == 'go-' . $_SESSION['user']) {
            include_once './modules/sections/section-editor.php';
        }
        ?>
    </aside>
</body>
<script src="/sistemaHorario/js/controls/buttons.js" type="text/javascript"></script>

</html>