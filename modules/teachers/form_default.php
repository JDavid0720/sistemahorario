<?php
require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');
?>
<div class="form-gridview">
    <!-- Contenedor del botón "Cargar Datos" -->
	<br>
    <div class="load-data-container">
    <form id="form" action="../n/docente.html" method="POST">
    <button class="btn btn-load-data" name="btn" value="load_data" type="submit">Cargar Datos</button>
</form>

<script>
    document.querySelector('.btn-load-data').addEventListener('click', function(e) {
        e.preventDefault(); // Evitar que el formulario se envíe automáticamente
        
        // Mostrar mensaje de confirmación
        if (confirm('¿Estás seguro de que deseas borrar los datos de los docentes registrados?')) {
            // Hacer solicitud AJAX para borrar datos
            var xhr = new XMLHttpRequest();
            xhr.open('GET', './borrar_datos_docente.php', true);
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
            if ($_SESSION['total_users'] != 0) {
                echo '
                        <tr>
                            <th>CI</th>
                            <th>Nombres</th>
                            <th>Titulo Tercer N</th>
                            <th>Titulo Cuarto N</th>
                            <th class="center"><a class="icon">visibility</a></th>
                            <th class="center"><a class="icon">edit</a></th>
                            <th class="center"><a class="icon">delete</a></th>
                        </tr>
                ';
            }
            for ($i = 0; $i < $_SESSION['total_users']; $i++) {
                echo '
                        <tr>
                            <td>' . $_SESSION["CI"][$i] . '</td>
                            <td>' . $_SESSION["ApellidoNombre"][$i] . '</td>
                            <td>' . $_SESSION["Titulo_tercer"][$i] . '</td>
                            <td>' . $_SESSION["Titulo_cuarto"][$i] . '</td>
                            <td>
                                <form action="" method="POST">
                                    <input style="display:none;" type="text" name="txtuserid" value="' . $_SESSION["CI"][$i] . '"/>
                                    <button class="btnview" name="btn" value="form_consult" type="submit"></button>
                                </form>
                            </td>
                            <td>
                                <form action="" method="POST">
                                    <input style="display:none;" type="text" name="txtuserid" value="' . $_SESSION["CI"][$i] . '"/>
                                    <button class="btnedit" name="btn" value="form_update" type="submit"></button>
                                </form>
                            </td>
                            <td>
                                <form action="" method="POST">
                                    <input style="display:none;" type="text" name="txtuserid" value="' . $_SESSION["CI"][$i] . '"/>
                                    <button class="btndelete" name="btn" value="form_delete" type="submit"></button>
                                </form>
                            </td>
                        </tr>
                    ';
            }
            ?>
        </table>
        <?php
        if ($_SESSION['total_users'] == 0) {
            echo '
                    <img src="/images/404.svg" class="data-not-found" alt="404">
            ';
        }
        if ($_SESSION['total_users'] != 0) {
            echo '
                    <div class="pages">
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
        echo '</div>';
        ?>
    </div>

<style>
    /* Estilos para la lista de números de página */
    .pages ul {
        list-style: none;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0;
        margin: 0.5px;
    }

    /* Estilos para los elementos de la lista */
    .pages li {
        margin: 0.1px;
    }

    /* Estilos para los botones de número de página */
    .pages button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 5px 10px;
        font-size: 16px;
        border-radius: 1px;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Estilos para el botón de página activa */
    .pages .active button {
        background-color: #888;
        color: white;
    }

    /* Estilos para el contenedor del botón "Cargar Datos" */
    .load-data-container {
        margin-bottom: -8px; /* Ajuste para separar visualmente el botón de la tabla */
        margin-left: 20px; /* Mover el botón a la izquierda */
    }

    /* Estilos para el contenedor del GridView */
    .gridview-container {
        width: 100%; /* Asegurar que el contenedor ocupe el ancho completo */
        overflow-x: auto; /* Permitir desplazamiento horizontal si es necesario */
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
<div class="content-aside">
    <?php
    include_once '../notif_info.php';
    include_once "../sections/options.php";
    ?>
</div>
