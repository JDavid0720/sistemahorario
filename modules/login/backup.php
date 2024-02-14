<!DOCTYPE html>
<html>
<head>
    
<link rel="stylesheet" type="text/css" href="/sistemaHorario/css/style.css">
    <title>Recuperación de Contraseña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 150;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #555;
        }

        input[type="email"] {
            width: 95%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .message {
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            font-size: 16px;
        }

        .error {
            text-align: center;
            margin-top: 20px;
            color: #dc3545;
            font-size: 16px;
        }
        .logo-container {
            margin: 0 auto;
        margin-bottom: 30px;
        text-align: center;
    }

    .user-logo {
        margin: 0 auto;
        width: 100px; /* Ajusta el tamaño del logo según tus necesidades */
        height: 100px;
        background-color: #ccc; /* Cambia esto por la apariencia real del logo */
        border-radius: 50%;
    }
    </style>
    
</head>
<body class="login">
 <div class="wrap-title-login">
    
    </div>
    <h2>Recuperar Contraseña</h2>
    <div class="logo-container">
    <img class="user-logo" src="gmail.png" alt="correo">
</div>

    <form method="post" action="recuperar.php">
        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" placeholder="Ingrese el correo registrado" required>
        <br>
        <input type="submit" value="Recuperar">
    </form>
    
</body>
</html>
