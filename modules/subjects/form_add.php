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
                    <label for="txtuserid" class="label">Id Asignatura</label>
                    <input id="txtIdasignatura" class="text" type="text" name="txtCI" value="" placeholder="Codigo de Asignatura" pattern="[0-9]+" title="Ingresa solo números." required />
                    <label for="selectgender" class="label">Carrera</label>
                    <select id="IdCarrera" class="select" name="selecCarrera"   required>
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
                    <label for="selectgender" class="label">Ciclo</label>
                    <select id="IdCiclo" class="select" name="selecCiclo"   required>
                        <?php
                        $sql = "SELECT * FROM cilco";

                        if ($result = $conexion->query($sql)) {
                            while ($row = mysqli_fetch_array($result)) {
                                echo
                                '
									<option value="' . $row['Id_cilco'] . '">' . $row['Ciclo'] . '  ' . $row['paralelo'] . '</option>
								';
                            }
                        }
                        ?>
                    </select>                       
                
                </div>
                <div class="last">
                <label for="selectgender" class="label">Malla</label>
                    <select id="IdMalla" class="select" name="selecMalla"   required>
                        <?php
                        $sql = "SELECT * FROM malla";

                        if ($result = $conexion->query($sql)) {
                            while ($row = mysqli_fetch_array($result)) {
                                echo
                                '
									<option value="' . $row['Id_malla'] . '">' . $row['Nom_malla'] . '</option>
								';
                            }
                        }
                        ?>
                    </select>                     
                    <label for="dateofbirth" class="label">Nombre de la Asignatura</label>
                    <input id="NomAsignatura" class="date" type="text" name="asignatura" value="" placeholder="Ingrese el Nombre de la Asignatura" value="" maxlength="60" required />
   
                    
                   
                </div>
                <div class="content-full">
                   
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