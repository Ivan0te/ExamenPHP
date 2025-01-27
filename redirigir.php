<?php
// Incluir la conexión a la base de datos
include('db.php');

// Comprobar si se ha proporcionado el código
if (isset($_GET['code'])) {
    $codigo = $_GET['code'];

    // Consultar la base de datos para obtener la URL original
    $query = "SELECT url_original FROM urls WHERE url_corta = '$codigo'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $url = mysqli_fetch_assoc($result)['url_original'];

        // Redirigir al usuario a la URL original
        header("Location: $url");
        exit;
    } else {
        echo "URL no encontrada.";
    }
} else {
    echo "No se proporcionó un código de URL.";
}
?>
