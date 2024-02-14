<?php
require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');
?>
<div class="form-gridview">
    <!-- Contenedor del botón "Cargar Datos" -->
    <div class="load-data-container">
    <form id="form" action="../n/index.html" method="POST">
    <button class="btn btn-load-data" name="btn" value="load_data" type="submit">Cargar Datos</button>
</form>

<script>
    document.querySelector('.btn-load-data').addEventListener('click', function(e) {
        e.preventDefault(); // Evitar que el formulario se envíe automáticamente
        
        // Mostrar mensaje de confirmación
        if (confirm('¿Estás seguro de que deseas borrar los datos de las asignaturas registradas?')) {
            // Hacer solicitud AJAX para borrar datos
            var xhr = new XMLHttpRequest();
            xhr.open('GET', './borrarasignatura.php', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert(xhr.responseText); // Mostrar mensaje de éxito o error
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
    </div>

    <!-- Contenedor del GridView -->
    <div class="gridview-container">
        <table class="default">
            <?php
            if ($_SESSION['total_subjects'] != 0) {
                echo '
                        <tr>
                            <th>Id asignatura</th>
                            <th>Nombre</th>
                            <th>Carrera</th>
                            <th class="center">Semestre</th>
                            <th>Malla</th>
                            <th class="center"><a class="icon">visibility</a></th>
                            <th class="center"><a class="icon">edit</a></th>
                ';
                if ($_SESSION['permissions'] != 'editor') {
                    echo '<th class="center"><a class="icon">delete</a></th>';
                }
                echo '
                        </tr>
                ';
            }
            ?>
            <?php
            for ($i = 0; $i < $_SESSION['total_subjects']; $i++) {
                echo '
                        <tr>
                            <td>' . $_SESSION["subject"][$i] . '</td>
                            <td>' . $_SESSION["subject_name"][$i] . '</td>
                            <td>' . $_SESSION["subject_career"][$i] . '</td>
                            <td class="center">' . $_SESSION["subject_semester"][$i] . '</td>
                            <td>' . $_SESSION["subject_malla"][$i] . '</td>
                            <td>
                                <form action="" method="POST">
                                    <input style="display:none;" type="text" name="txtsubject" value="' . $_SESSION["subject"][$i] . '"/>
                                    <button class="btnview" name="btn" value="form_consult" type="submit"></button>
                                </form>
                            </td>
                            <td>
                                <form action="" method="POST">
                                    <input style="display:none;" type="text" name="txtsubject" value="' . $_SESSION["subject"][$i] . '"/>
                                    <button class="btnedit" name="btn" value="form_update" type="submit"></button>
                                </form>
                            </td>';
                if ($_SESSION['permissions'] != 'editor') {
                    echo '
                                    <td>
                                        <form action="" method="POST">
                                            <input style="display:none;" type="text" name="txtsubject" value="' . $_SESSION["subject"][$i] . '"/>
                                            <button class="btndelete" name="btn" value="form_delete" type="submit"></button>
                                        </form>
                                    </td>
                                ';
                }
                echo '
                        </tr>
                    ';
            }
            ?>
        </table>
        <?php
        if ($_SESSION['total_subjects'] == 0) {
            echo '
                    <img src="/images/404.svg" class="data-not-found" alt="404">
            ';
        }
        if ($_SESSION['total_subjects'] != 0) {
            echo '
                    <div class="pagina">
                        <ul>
                ';
            for ($n = 1; $n <= $tpages; $n++) {
                if ($page == $n) {
                    echo '<li class="active"><form name="form-pages" action="" method="POST"><button type="submit" name="page" value="' . $n . '">' . $n . '</button></form></li>';
                } else {
                    echo '<li><form name="form-pages" action="" method="POST"><button type="submit" name="page" value="' . $n . '">' . $n . '</button></form></li>';
                }
            }
            echo '
                        </ul>
                    </div>
                    
            ';
        }
        
        ?>
        <style>
            /* Estilos para la lista de números de página */
            .pagina ul {
                list-style: none;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 0;
                margin: 0;
            }

            /* Estilos para los elementos de la lista */
            .pagina li {
                margin: 0.5px;
            }

            /* Estilos para los botones de número de página */
            .pagina button {
                background-color: #888;
                color: white;
                border: none;
                padding: 3px 5px;
                font-size: 14px;
                border-radius: 5px;
                cursor: pointer;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            /* Estilos para el botón de página activa */
            .pagina .active button {
                background-color: #888;
                color: white;
            }
        </style>

    </div>

    <style>
        /* Estilos para el contenedor del botón "Cargar Datos" */
        .load-data-container {
            margin-bottom: -10px;
            margin-left: 20px;
            margin-top: 20px;
        }

        /* Estilos para el contenedor del GridView */
        .gridview-container {
            width: 100%;
            overflow-x: auto;
        }

        /* Estilos para el botón de carga de datos */
        .btn-load-data {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-load-data:hover {
            background-color: #45a049;
        }
    </style>
</div>
<div class="content-aside">
    <?php
    include_once '../notif_info.php';
    include_once "../sections/options.php";
    ?>
</div>
