<?php
include_once 'security.php';

require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');

$url_actual = $_SERVER["REQUEST_URI"];

if (strpos($url_actual, 'modules')) {
    $input = $url_actual;
    preg_match('~modules/(.*?)/~', $input, $name_page);
    $name_page[1];

    if ($name_page[1] == 'school_periods') {
        $_SESSION['title_form_section'] = 'Periodo Academico';
    } elseif ($name_page[1] == 'school_period') {
        $_SESSION['title_form_section'] = 'Periodo Academico';
    } elseif ($name_page[1] == 'users') {
        $_SESSION['title_form_section'] = 'Usuarios';
    } elseif ($name_page[1] == 'administratives') {
        $_SESSION['title_form_section'] = 'Administrativos';
    } elseif ($name_page[1] == 'teachers') {
        $_SESSION['title_form_section'] = 'Docentes';
    } elseif ($name_page[1] == 'students') {
        $_SESSION['title_form_section'] = 'Alumnos';
    } elseif ($name_page[1] == 'subjects') {
        $_SESSION['title_form_section'] = 'Asignaturas';
    } elseif ($name_page[1] == 'careers') {
        $_SESSION['title_form_section'] = 'Carreras';
    } elseif ($name_page[1] == 'distributibo') {
        $_SESSION['title_form_section'] = 'Distributivos';
    } elseif ($name_page[1] == 'genHorario') {
        $_SESSION['title_form_section'] = 'Horarios';
    }
} elseif (strpos($url_actual, 'attendance')) {
    $name_page[1] = 'attendance';

    if ($name_page[1] == 'attendance') {
        $_SESSION['title_form_section'] = 'Asistencia';
    }
} elseif (strpos($url_actual, 'user')) {
    $name_page[1] = 'user';

    if ($name_page[1] == 'user') {
        $_SESSION['title_form_section'] = 'Configuración';
    }
} else {
    $name_page[1] = 'home';

    if ($name_page[1] == 'home') {
        $_SESSION['title_form_section'] = 'Inicio';
    }
}
?>
<div class="info-title">
    <span class="title">
        <?php
        echo $_SESSION['title_form_section'];
        ?>
    </span>
</div>
<div class="info-school-period">
    <span class="school-period">
        Periodo Academico /
        <a id="schoolPeriod" href="/sistemaHorario/modules/school_period"><?php print $_SESSION['school_period']; ?></a>
    </span>
</div>