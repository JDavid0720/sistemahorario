<?php
require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');

$sql = "SELECT * FROM docente WHERE CI = '" . $_POST['txtuserid'] . "'";

if ($result = $conexion->query($sql)) {
	if ($row = mysqli_fetch_array($result)) {
		$_SESSION['user_id'] = $row['CI'];
		$_SESSION['teacher_name'] = $row['ApellidoNombre'];
		$_SESSION['teacher_T3'] = $row['Titulo_tercer'];
		$_SESSION['teacher_T4'] = $row['Titulo_cuarto'];
		$_SESSION['teacher_Contrato'] = $row['Contrato'];
		$_SESSION['teacher_dedicacion'] = $row['dedicacion'];
		$_SESSION['teacher_campus'] = $row['campus'];
		/*$_SESSION['teacher_phone'] = $row['phone'];*/
		$_SESSION['teacher_complementaria'] = $row['actividad_complementaria'];
		/*$_SESSION['teacher_level_studies'] = $row['level_studies'];*/
		/*$_SESSION['teacher_specialty'] = $row['specialty'];*/
		$_SESSION['teacher_carrera'] = $row['Id_carrera'];
	}
}
?>
<div class="form-data">
	<div class="head">
		<h1 class="titulo">Consultar</h1>
	</div>
	<div class="body">
		<form name="form-consult-teachers" action="#" method="POST">
			<div class="wrap">
				<div class="first">
					<label class="label">CI</label>
					<input style="display: none;" type="text" name="btn" value="form_default" />
					<input class="text" type="text" name="txt" value="<?php echo $_SESSION['user_id']; ?>" disabled />
					<label class="label">Apellidos y Nombre</label>
					<input class="text" type="text" name="txtname" value="<?php echo $_SESSION['teacher_name']; ?>" disabled />
                    <label for="txtusersurnames" class="label">Titulo tercer nivel</label>
					<input class="text" type="text" name="txtTercer" value="<?php echo $_SESSION['teacher_T3']; ?>" disabled />
                    <label for="dateofbirth" class="label">Titulo de Cuarto nivel</label>
					<input id="dateofbirth" class="date" type="text" name="txtT4"  value="<?php echo $_SESSION['teacher_T4']; ?>" disabled />

					<label for="selectgender" class="label">Tipo de contrato</label>
										<input id="dateofbirth" class="date" type="text" name="txt_Contrato"  value="<?php echo $_SESSION['teacher_Contrato']; ?>" disabled />

				</div>
				<div class="last">
					<label class="label">Dedicacion</label>
					<input class="text" type="text" name="txtcurp" value="<?php echo $_SESSION['teacher_dedicacion']; ?>" disabled />
					<label class="label">Campus</label>
					<input class="text" type="text" name="txtrfc" value="<?php echo $_SESSION['teacher_campus']; ?>" disabled />
					<label class="label">Actividad complementaria</label>
					<textarea class="text" name="txtphone" disabled><?php echo $_SESSION['teacher_complementaria']; ?></textarea>
				</div>
				<div class="content-full">
					
						
				</div>
				<div class="content-full">
					<label for="selectusercareers" class="label">Carrera</label>
					<select id="selectusercareers" class="select" name="selectlevelstudies" disabled>
						<?php
						$_SESSION['teacher_carrera'] = trim($_SESSION['teacher_carrera'], ',');
						$arraySubjectTeachers = explode(',', $_SESSION['teacher_carrera']);

						foreach ($arraySubjectTeachers as $key) {
							$sql = "SELECT Id_carrera, Nom_carrera FROM carrera where Id_carrera = '" . $key . "'";

							if ($result = $conexion->query($sql)) {
								while ($row = mysqli_fetch_array($result)) {
									$_SESSION['teacher_carrera_id'] = $row['Id_carrera'];
									$_SESSION['teacher_carrera_nombre'] = $row['Nom_carrera'];
								}
								if ($_SESSION['teacher_carrera_id'] != '') {
									echo
									'
										<option value="' . $_SESSION['teacher_carrera_id'] . '" selected>' . $_SESSION['teacher_carrera_nombre'] . '</option>
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
			<button id="btnSave" class="btn icon" type="submit" autofocus>done</button>
		</form>
	</div>
</div>
<div class="content-aside">
	<?php include_once "../sections/options-disabled.php"; ?>
</div>
<script src="/js/modules/teachers.js" type="text/javascript"></script>