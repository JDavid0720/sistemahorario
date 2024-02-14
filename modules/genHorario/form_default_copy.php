<!DOCTYPE html>
<html>

<head>
    <title>Editar Materia</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <style>
        body {
            margin: 0;
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-wrap: wrap; /* Permitir que los elementos se envuelvan en pantallas pequeñas */
        }

        .content {
            width: 80%; /* Ocupar el 80% del ancho de la ventana */
            display: flex;
            justify-content: space-around; /* Espacio entre los elementos en la dirección principal */
            align-items: flex-start; /* Alinear los elementos arriba */
            flex-wrap: wrap; /* Permitir que los elementos se envuelvan en pantallas pequeñas */
        }

        .form-container {
            max-width: 250px;
            padding: 15px;
            flex: 1; /* Ocupar el espacio disponible en el contenedor */
            margin: 10px; /* Agregar un margen entre los contenedores */
            box-sizing: border-box; /* Incluir el padding y margen en el tamaño total */
        }

        .form-container h2 {
            margin-bottom: 15px;
            color: #007BFF;
        }

        .form-container label {
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        .form-container input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-container input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 16px;
        }

        .form-container input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .horarios-table-container {
            flex: 1;
            max-width: 800px; /* Ancho máximo de la tabla */
            margin: 10px; /* Agregar un margen entre los contenedores */
            overflow-x: auto; /* Permitir desplazamiento horizontal si la tabla es muy ancha */
        }

        .horarios-table {
            border-collapse: collapse;
            width: 100%;
        }

        .horarios-table th,
        .horarios-table td {
            border: 1px solid #ccc;
            padding: 12px; /* Aumentar el tamaño de las celdas */
            text-align: center;
            background-color: #fff;
            font-size: 16px; /* Aumentar el tamaño del texto */
        }

        .horarios-table th {
            background-color: #007BFF;
            color: #fff;
        }

        @media screen and (max-width: 800px) {
            .content {
                width: 100%; /* En pantallas pequeñas, ocupa todo el ancho */
                padding: 10px; /* Agregar un poco de espacio entre los elementos */
            }
        }
    </style>
</head>

<body>
    <?php
    // Tu código PHP aquí
    ?>

    <div class="container">
        <div class="content">
            <div class="form-container">
                <h2>Editar Materia</h2>
                <form method="post">
                    <label>Nombre:</label>
                    <input type="text" name="nom_carrera" value="<?php echo $_GET['nombre']; ?>">
                    <label>ID Tiempo:</label>
                    <input type="text" name="id_tiempo" value="<?php echo $_GET['hora']; ?>">
                    <label>ID Día:</label>
                    <input type="text" name="id_dia" value="<?php echo $_GET['dia']; ?>">
                    <label>Tipo:</label>
                    <input type="text" name="tipo" value="<?php echo $_GET['tipo']; ?>">
                    <input type="submit" value="Guardar Cambios">
                </form>
            </div>

            <div class="horarios-table-container">
                <table class="horarios-table">
                    <tr>
                        <th>Hora</th>
                        <th>Lunes</th>
                        <th>Martes</th>
                        <th>Miércoles</th>
                        <th>Jueves</th>
                        <th>Viernes</th>
                        <th>Sábado</th>
                        <th>Domingo</th>
                    </tr>
                    <?php
                    // Generar filas con las horas de 7 a 22
                    for ($hora = 7; $hora <= 22; $hora++) {
                        echo "<tr>";
                        echo "<td>$hora:00</td>";
                        // Generar celdas vacías para cada día de la semana
                        for ($dia = 1; $dia <= 7; $dia++) {
                            echo "<td></td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>

</body>

</html>
