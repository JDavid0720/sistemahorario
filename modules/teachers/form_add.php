<?php
require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');

function unique_id($l = 10)
{
    return substr(md5(uniqid(mt_rand(), true)), 0, $l);
}

$id_generate = 'tchr-' . unique_id(5);
?>
<div class="form-data">
    <div class="head">
        <h1 class="titulo">Agregar</h1>
    </div>
    <div class="body">
        <form name="form-add-teachers" action="insert.php" method="POST" autocomplete="off" autocapitalize="on">
            <div class="wrap">
                <div class="first">
                    <label for="txtuserid" class="label">CI</label>
                    <input id="txtuserphone" class="text" type="text" name="txtCI" value="" placeholder="CI" pattern="[0-9]{10}" title="Ingresa un número de teléfono válido." maxlength="10" required />
                    <label for="txtusername" class="label">Apellidos y Nombres</label>
                    <input id="txtusername" class="text" type="text" name="txtname" value="" placeholder="Apellidos y Nombres" maxlength="30" required autofocus />
                    <label for="txtusersurnames" class="label">Titulo tercer nivel</label>
                    <input id="txtusersurnames" class="text" type="text" name="txtT3" placeholder="Titulo tercer nivel" value="" maxlength="60" required />
                    <label for="dateofbirth" class="label">Titulo de Cuarto nivel</label>
                    <input id="dateofbirth" class="date" type="text" name="txtT4" value="" placeholder="Ingrese el titulo" value="" maxlength="60" required />
                    <label for="selectgender" class="label">Tipo de contrato</label>
                    <select id="selectgender" class="select" name="selecContrato" required>
                        <option value="">Seleccioné</option>
                        <option value="Contrato">Contrato</option>
                        <option value="Nombramiento">Nombramiento</option>
                        <option value="otro">Otro</option>
                        <option value="nodecirlo">Prefiero no decirlo</option>
                    </select>
                </div>
                <div class="last">
                    <label for="selectgender" class="label">Dedicacion</label>
                    <select id="selectgender" class="select" name="selecDedicacion" required>
                        <option value="">Seleccioné</option>
                        <option value="Tiempo completo">Tiempo completo</option>
                        <option value="Medio tiempo">Medio tiempo</option>
                    </select>
                    <label for="selectgender" class="label">Campus</label>
                    <select id="selectgender" class="select" name="selecCampus" required>
                        <option value="">Seleccioné</option>
                        <option value="Matriz">Matriz</option>
                        <option value="La Maná">La Maná</option>
                    </select>
                    <label for="txtuserphone" class="label">Número de teléfono</label>
                    <input id="txtuserphone" class="text" type="text" name="txtphone" value="" placeholder="9998887766" pattern="[0-9]{10}" title="Ingresa un número de teléfono válido." maxlength="10" required />
                    <label for="txtuseraddress" class="label">Actividad complementaria</label>
                    <input id="txtuseraddress" class="text" type="text" name="txtactividad" value="" placeholder="Ingrese la actividad complementaria" maxlength="200" required />
                  </div>
                
                <div class="content-full">
                    <label for="selectusercareers" class="label">Carrera</label>
                    <select id="selectusercareers" class="select" name="selectlevelstudies"   required>
                        <?php
                        $sql = "SELECT Id_carrera, Nom_carrera FROM carrera";

                        if ($result = $conexion->query($sql)) {
                            while ($row = mysqli_fetch_array($result)) {
                                echo
                                '
									<option value="' . $row['Id_carrera'] . '">' . $row['Nom_carrera'] . '</option>
								';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <button id="btnBack" class="btn back icon" type="button">arrow_back</button>
            <button id="btnNext" class="btn icon" type="button">arrow_forward</button>
            <button id="btnSave" class="btn icon" type="submit">save</button>
        </form>
    </div>
</div>
<div class="content-aside">
    <?php
    include_once "../sections/options-disabled.php";
    ?>
</div>
<script src="/js/modules/teachers.js" type="text/javascript"></script>