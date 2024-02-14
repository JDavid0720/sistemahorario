<?php
   // Configuración de la base de datos
include '../conexion.php';
require_once 'sendgrid-php/sendgrid-php.php';

use SendGrid\Mail\Mail;

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    // Consulta SQL para obtener información del usuario
    $selectSql = "SELECT user, pass FROM users WHERE email = ? LIMIT 1";

    // Preparar la consulta
    $selectStmt = $conexion->prepare($selectSql);

    if ($selectStmt) {
        // Vincular parámetros
        $selectStmt->bind_param("s", $email);

        // Ejecutar la consulta
        $selectStmt->execute();

        // Obtener resultados
        $selectStmt->bind_result($username, $hashedPassword);
        $selectStmt->fetch();

        // Cerrar declaración de consulta de selección
        $selectStmt->close();

        // Verificar si se encontró el usuario
        if ($username) {
            // Generar una nueva contraseña temporal
            $newPassword = substr(md5(rand()), 0, 8); // Cambia esto por una generación más segura

            // Actualizar la contraseña en la base de datos (sin encriptar)
            $updateSql = "UPDATE users SET pass = ? WHERE email = ?";
            $updateStmt = $conexion->prepare($updateSql);

            if ($updateStmt) {
                $updateStmt->bind_param("ss", $newPassword, $email);
                $updateStmt->execute();
                $updateStmt->close(); // Cierra la declaración de la consulta de actualización

                // Enviar el correo electrónico con la nueva contraseña
                $to = $email;
                $subject = "Recuperación de contraseña";
                $message = "Hola $username,\n\nTu nueva contraseña temporal es: $newPassword";

                // Crear una instancia de correo electrónico SendGrid
                $sendgridEmail = new Mail();
                $sendgridEmail->setFrom("bryan.freire7970@utc.edu.ec", "Horarios UTC-La Maná");
                $sendgridEmail->setSubject($subject);

                // Agregar el destinatario al correo electrónico de SendGrid
                $sendgridEmail->addTo($email, "Example User");

                // Agregar contenido al correo electrónico
                $sendgridEmail->addContent("text/plain", $message);
                $sendgridEmail->addContent(
                    "text/html", "<strong> $message </strong>"
                );

                $sendgrid = new \SendGrid('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');
                try {
                    $response = $sendgrid->send($sendgridEmail);
                    // Manejar la respuesta de SendGrid si es necesario
                } catch (Exception $e) {
                    echo 'Error al enviar el correo electrónico: ' . $e->getMessage();
                }

                echo "<script>
                alert('Se ha enviado una nueva contraseña por correo electrónico.');
                setTimeout(function() {
                    window.location.href = 'index.php'; // Cambia esto por la URL deseada
                }, 3000); // Redirige después de 3 segundos (1000 ms)
              </script>";            }
               else {
                echo "<script>
                alert('Error en la consulta de actualización: " . $conexion->error . "');
                setTimeout(function() {
                    window.location.href = 'otra_pagina_error.php'; // Cambia esto por la URL deseada para los errores
                }, 3000); // Redirige después de 3 segundos (1000 ms)
              </script>";            }
        } else {
            echo "<script>
            alert('No se encontro usuario registrado con ese correo.');
            setTimeout(function() {
                window.location.href = 'backup.php'; // Cambia esto por la URL deseada
            }, 3000); // Redirige después de 3 segundos (500 ms)
          </script>";
        }
    } else {
        echo "<div class='error'>Error en la consulta de selección: " . $conexion->error . "</div>";
    }

    // Cerrar conexión
    $conexion->close();
}
?>
