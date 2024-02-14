<?php
require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');
?>
<div class="form-gridview">
	<table class="default">
		<?php
		if ($_SESSION['total_users'] != 0) {
			echo '
					<tr>
						<th>Usuario</th>
						<th>Nombre</th>
						<th>CURP</th>
						<th class="center" style="width: 80px;">Admisión</th>
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
		for ($i = 0; $i < $_SESSION['total_users']; $i++) {
			echo '
		    		<tr>
		    			<td>' . $_SESSION["user_id"][$i] . '</td>
						<td>' . $_SESSION["student_name"][$i] . '</td>
						<td class="tdbreakw">' . $_SESSION["student_curp"][$i] . '</td>
						<td class="center">' . $_SESSION["student_date"][$i] . '</td>
						<td>
							<form action="" method="POST">
								<input style="display:none;" type="text" name="txtuserid" value="' . $_SESSION["user_id"][$i] . '"/>
								<button class="btnview" name="btn" value="form_consult" type="submit"></button>
							</form>
						</td>
						<td>
							<form action="" method="POST">
								<input style="display:none;" type="text" name="txtuserid" value="' . $_SESSION["user_id"][$i] . '"/>
								<button class="btnedit" name="btn" value="form_update" type="submit"></button>
							</form>
						</td>
						<td>
							<form action="" method="POST">
								<input style="display:none;" type="text" name="txtuserid" value="' . $_SESSION["user_id"][$i] . '"/>
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
		echo '</div>';
	}
	?>
	
<style>
  /* Estilos para la lista de números de página */
  .pagina ul {
    list-style: none; /* Eliminar los estilos de lista predeterminados */
    display: flex; /* Mostrar los elementos en línea horizontal */
    justify-content: center; /* Centrar los elementos horizontalmente */
    align-items: center; /* Centrar los elementos verticalmente */
    padding: 0;
    margin: 0;
  }

  /* Estilos para los elementos de la lista */
  .pagina li {
    margin: 0 2px; /* Ajustar el espaciado horizontal entre los botones */
  }

  /* Estilos para los botones de número de página */
  .pagina button {
    background-color: #007bff; /* Azul claro */
    color: white;
    border: none;
    padding: 5px 10px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    display: flex; /* Mostrar el contenido de forma flexible */
    justify-content: center; /* Centrar horizontalmente el contenido */
    align-items: center; /* Centrar verticalmente el contenido */
  }

  /* Estilos para el botón de página activa */
  .pagina .active button {
    background-color: #888; /* Gris */
    color: white; /* Letras en blanco */
  }
</style>
</div>
<div class="content-aside">
	<?php
	include_once '../notif_info.php';
	include_once "../sections/options.php";
	?>
</div>