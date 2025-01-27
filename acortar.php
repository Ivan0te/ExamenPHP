<?php
session_start();

// Incluir la conexión a la base de datos
include('db.php');

// Comprobar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    echo "Por favor, inicia sesión primero.";
    exit;
}

// Función para generar una cadena aleatoria para el acortamiento
function generarCodigo($length = 6) {
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $codigo = '';
    for ($i = 0; $i < $length; $i++) {
        $codigo .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $codigo;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['url'])) {
    $url = $_POST['url'];
    $codigoAcortado = generarCodigo();

    // Verificar si el código ya existe en la base de datos
    $query = "SELECT id FROM urls WHERE url_corta = '$codigoAcortado'";
    $result = mysqli_query($conn, $query);

    while (mysqli_num_rows($result) > 0) {
        // Si el código ya existe, generamos uno nuevo
        $codigoAcortado = generarCodigo();
        $result = mysqli_query($conn, $query);
    }

    // Obtener el user_id del usuario logueado
    $user_id = $_SESSION['user_id'];

    // Insertar la URL original y corta en la base de datos con el user_id
    $query = "INSERT INTO urls (url_original, url_corta, user_id) VALUES ('$url', '$codigoAcortado', '$user_id')";
    if (mysqli_query($conn, $query)) {
        // Obtener el dominio de la URL proporcionada
        $parseUrl = parse_url($url);
        $dominio = isset($parseUrl['host']) ? $parseUrl['host'] : 'tu-dominio.com';

        // Mostrar la URL acortada
        echo "<h1>URL Acortada</h1>";
        echo "<p>Tu URL original es: <a href='$url' target='_blank'>$url</a></p>";
        echo "<p>La URL acortada es: <a href='redirigir.php?code=$codigoAcortado' target='_blank'>$dominio/$codigoAcortado</a></p>";
    } else {
        echo "Error al guardar la URL: " . mysqli_error($conn);
    }
}
?>

<form method="POST" action="acortar.php">
    <label for="url">Introduce una URL para acortar:</label>
    <input type="text" name="url" required>
    <button type="submit">Acortar URL</button>
</form>
