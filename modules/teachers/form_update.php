<?php
require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');

$sql = "SELECT * FROM docente WHERE CI = '" . $_POST['txtuserid'] . "'";

if ($result = $conexion->query($sql)) {
	if ($row = mysqli_fetch_array($result)) {
		$_SESSION['user_id'] = $row['CI'];
		$_SESSION['teacher_name'] = $row['ApellidoNombre'];
		$_SESSION['teacher_T3'] = $row['Titulo_tercer'];
		$_SESSION['teacher_Contrato'] = $row['Contrato'];
		$_SESSION['teacher_T4'] = $row['Titulo_cuarto'];
		$_SESSION['teacher_dedicacion'] = $row['dedicacion'];
		$_SESSION['teacher_campus'] = $row['campus'];
		$_SESSION['teacher_complementaria'] = $row['actividad_complementaria'];
		$_SESSION['teacher_carrera'] = $row['Id_carrera'];
	}
}
?>
<div class="form-data">
	<div class="head">
		<h1 class="titulo">Actualizar</h1>
	</div>
	<div class="body">
		<form name="form-update-teachers" action="update.php" method="POST" autocomplete="off" autocapitalize="on">
			<div class="wrap">
				<div class="first">
					<label for="txtuserid" class="label">CI</label>
					<input id="txtuserid" style="display: none;" type="text" name="txtuserid" value="<?php echo $_SESSION['user_id']; ?>" maxlength="50">
					<input class="text" type="text" name="txt" value="<?php echo $_SESSION['user_id']; ?>" maxlength="50" disabled />
					<label for="txtusername" class="label">Apellidos y Nombres</label>
					<input id="txtusername" class="text" type="text" name="txtname" value="<?php echo $_SESSION['teacher_name']; ?>" placeholder="Apellidos y nombres" autofocus maxlength="60" required />
					<label for="txtusersurnames" class="label">Titulo de tercer nivel</label>
					<input id="txtTercer" class="text" type="text" name="txtT3" value="<?php echo $_SESSION['teacher_T3']; ?>" placeholder="Titulo de tercer nivel" maxlength="60" required />
					<label for="dateofbirth" class="label">Titulo de cuarto nivel</label>
					<input id="txtT4" class="date" type="text" name="txtT4" value="<?php echo $_SESSION['teacher_T4']; ?>" placeholder="Titulo de cuarto nivel" maxlength="60" required />
					<label for="selectgender" class="label">Contrato</label>
					<select id="seleccontrato" class="select" name="selecContrato" required>
						<?php
						if ($_SESSION['teacher_Contrato'] == '') {
							echo '
								<option value="">Seleccioné</option>
								<option value="CONTRATO">CONTRATO</option>
								<option value="NOMBRAMIENTO">NOMBRAMIENTO</option>
								<option value="otro">Otro</option>
								<option value="nodecirlo">Prefiero no decirlo</option>
							';
						} elseif ($_SESSION['teacher_Contrato'] == 'CONTRATO') {
							echo '
								<option value="CONTRATO">CONTRATO</option>
								<option value="NOMBRAMIENTO">NOMBRAMIENTO</option>
								<option value="otro">Otro</option>
								<option value="nodecirlo">Prefiero no decirlo</option>
							';
						} elseif ($_SESSION['teacher_Contrato'] == 'NOMBRAMIENTO') {
							echo '
								<option value="NOMBRAMIENTO">NOMBRAMIENTO</option>
								<option value="CONTRATO">CONTRATO</option>
								<option value="otro">Otro</option>
								<option value="nodecirlo">Prefiero no decirlo</option>
							';
						} elseif ($_SESSION['teacher_Contrato'] == 'otro') {
							echo '
								<option value="otro">Otro</option>
								<option value="CONTRATO">CONTRATO</option>
								<option value="NOMBRAMIENTO">NOMBRAMIENTO</option>
								<option value="nodecirlo">Prefiero no decirlo</option>
							';
						} elseif ($_SESSION['teacher_Contrato'] == 'nodecirlo') {
							echo '
								<option value="nodecirlo">Prefiero no decirlo</option>
								<option value="otro">Otro</option>
								<option value="CONTRATO">CONTRATO</option>
								<option value="NOMBRAMIENTO">NOMBRAMIENTO</option>
							';
						}
						?>
					</select>
				</div>
				<div class="last">
					<label for="txtusercurp" class="label">Dedicacion</label>
					<select id="selecdedicacion" class="select" name="selecDedicacion" >
						<?php
						if ($_SESSION['teacher_dedicacion'] == '') {
							echo '
								<option value="">Seleccioné</option>
								<option value="TIEMPO COMPLETO">TIEMPO COMPLETO</option>
								<option value="MEDIO TIEMPO">MEDIO TIEMPO</option>
								<option value="TIEMPO PARCIAL">TIEMPO PARCIAL</option>
								<option value="nodecirlo">Prefiero no decirlo</option>
							';
						} elseif ($_SESSION['teacher_dedicacion'] == 'TIEMPO COMPLETO ') {
							echo '
								<option value="TIEMPO COMPLETO">TIEMPO COMPLETO</option>
								<option value="MEDIO TIEMPO">MEDIO TIEMPO</option>
								<option value="TIEMPO PARCIAL">TIEMPO PARCIAL</option>
								<option value="nodecirlo">Prefiero no decirlo</option>
							';
						} elseif ($_SESSION['teacher_dedicacion'] == 'MEDIO TIEMPO') {
							echo '
								<option value="MEDIO TIEMPO">MEDIO TIEMPO</option>
								<option value="TIEMPO COMPLETO">TIEMPO COMPLETO</option>
								<option value="TIEMPO PARCIAL">TIEMPO PARCIAL</option>
								<option value="nodecirlo">Prefiero no decirlo</option>
							';
						} elseif ($_SESSION['teacher_dedicacion'] == 'TIEMPO PARCIAL') {
							echo '
								<option value="TIEMPO PARCIAL">TIEMPO PARCIAL</option>
								<option value="MEDIO TIEMPO">MEDIO TIEMPO</option>
								<option value="TIEMPO COMPLETO">TIEMPO COMPLETO</option>
								<option value="nodecirlo">Prefiero no decirlo</option>
							';
						} elseif ($_SESSION['teacher_decicacion'] == 'nodecirlo') {
							echo '
								<option value="nodecirlo">Prefiero no decirlo</option>
								<option value="TIEMPO PARCIAL">TIEMPO PARCIAL</option>
								<option value="MEDIO TIEMPO">MEDIO TIEMPO</option>
								<option value="TIEMPO COMPLETO">TIEMPO COMPLETO</option>
							';
						}
						?>
					</select>
					<label for="txtuserrfc" class="label">Campus</label>
					<select id="seleccampus" class="select" name="selecCampus" required>
						<?php
						if ($_SESSION['teacher_campus'] == '') {
							echo '
								<option value="">Seleccioné</option>
								<option value="LA MANÁ">LA MANÁ</option>
								<option value="MATRIZ">MEDIO TIEMPO</option>
							';
						} elseif ($_SESSION['teacher_campus'] == 'LA MANÁ') {
							echo '
								<option value="LA MANÁ">LA MANÁ</option>
								<option value="MATRIZ">MATRIZ</option>
								
							';
						} elseif ($_SESSION['teacher_campus'] == 'MEDIO TIEMPO') {
							echo '
								<option value="MATRIZ">MEDIO TIEMPO</option>
								<option value="LA MANÁ">LA MANÁ</option>
								
							';
						} 
						?>
						</select>
						
					<label for="txtuseraddress" class="label">Actividad Complementaria</label>
					<textarea id="txtactividad" class="text" name="txtacti" placeholder="Actividad complementaria" maxlength="200" required><?php echo $_SESSION['teacher_complementaria']; ?></textarea>					
				</div>
				<div class="content-full">
					
				</div>
				<div class="content-full">
					<label for="selectusercareers" class="label">Carrera</label>
					<select id="selectusercareers" class="select" name="selectlevelstudies"  required>
						<?php
						$_SESSION['teacher_carrera'] = trim($_SESSION['teacher_carrera'], ',');
						$carrera = explode(',', $_SESSION['teacher_carrera']);

						$i = 0;

						$sql = "SELECT Id_carrera, Nom_carrera FROM carrera";

						if ($result = $conexion->query($sql)) {
							while ($row = mysqli_fetch_array($result)) {
								if ($row['Id_carrera'] == $carrera[$i]) {
									echo
									'
										<option value="' . $row['Id_carrera'] . '" selected>' . $row['Nom_carrera'] . '</option>
									';
									$i++;
								} else {
									echo
									'
										<option value="' . $row['Id_carrera'] . '">' . $row['Nom_carrera'] . '</option>
									';
								}
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
	<?php include_once "../sections/options-disabled.php"; ?>
</div>
<script src="/js/modules/teachers.js" type="text/javascript"></script>