<?php
// Configuración de la base de datos


include '../conexion.php';
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
            
            // Actualizar la contraseña en la base de datos
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateSql = "UPDATE users SET pass = ? WHERE email = ?";
            $updateStmt = $conexion->prepare($updateSql);
            
            if ($updateStmt) {
                $updateStmt->bind_param("ss", $hashedNewPassword, $email);
                $updateStmt->execute();
                $updateStmt->close(); // Cierra la declaración de la consulta de actualización
                
                // Enviar el correo electrónico con la nueva contraseña
                $to = $email;
                $subject = "Recuperación de contraseña";
                $message = "Hola $username,\n\nTu nueva contraseña temporal es: $newPassword";
                $headers = "From: tu_correo@example.com";
                
                mail($to, $subject, $message, $headers);
                
                echo "Se ha enviado una nueva contraseña por correo electrónico.";
            } else {
                echo "Error en la consulta de actualización: " . $conn->error;
            }
        } else {
            echo "No se encontró ningún usuario con ese correo electrónico.";
        }
    } else {
        echo "Error en la consulta de selección: " . $conn->error;
    }
    
    // Cerrar conexión
    $conexion->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Recuperación de Contraseña</title>
</head>
<body>
    <h2>Recuperar Contraseña</h2>
    <form method="post">
        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" required>
        <br>
        <input type="submit" value="Recuperar">
    </form>
</body>
</html>
