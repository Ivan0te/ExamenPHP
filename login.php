<?php
session_start();

// Incluir la conexión a la base de datos
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consultar si el usuario existe
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            // Iniciar la sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
        
            // Redirigir a la página de acortador
            header('Location: index.html');
            exit;
        } else {
            echo "Contraseña incorrecta.";
            
        }
    } else {
        echo "Usuario no encontrado.";
    }
}
?>

<form method="POST" action="login.php">
    <label for="username">Usuario:</label>
    <input type="text" name="username" required>
    <label for="password">Contraseña:</label>
    <input type="password" name="password" required>
    <button type="submit">Iniciar sesión</button>
</form>
