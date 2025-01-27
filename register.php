<?php
session_start();

// Incluir la conexión a la base de datos
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
   
    // Comprobar si el usuario ya existe
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 0) {
        // Insertar el nuevo usuario en la base de datos
        $query = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";
        if (mysqli_query($conn, $query)) {
            echo "Usuario registrado exitosamente. <a href='login.php'>Iniciar sesión</a>";
        } else {
            echo "Error al registrar el usuario: " . mysqli_error($conn);
        }
    } else {
        echo "El usuario ya existe.";
    }
}
?>

<form method="POST" action="register.php">
    <label for="username">Usuario:</label>
    <input type="text" name="username" required>
    <label for="password">Contraseña:</label>
    <input type="password" name="password" required>
    <button type="submit">Registrarse</button>
</form>
