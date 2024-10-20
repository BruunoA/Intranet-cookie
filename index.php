<?php
session_start();
$msg = "";

// Verificar si se envió el formulario
if (isset($_POST['btnSubmit'])) {
    if (
        isset($_POST['txtLogin']) && isset($_POST['txtPass']) &&
        $_POST['txtLogin'] == 'daw' && $_POST['txtPass'] == '2024'
    ) {
        $_SESSION['usr'] = 'daw';

        // Manejar el checkbox de "Recordar usuario"
        if (isset($_POST['rememberMe'])) {
            setcookie("usrname", $_POST['txtLogin'], time() + (86400 * 30), "/"); // Guardar cookie por 30 días
        } else {
            setcookie("usrname", "", time() - 3600, "/"); // Eliminar la cookie si no está seleccionado
        }

        header('location: home.php');
        die;
    } else {
        $msg = "<h2 style='color:red'>Contraseña o Usuario incorrecto</h2>";
    }
} elseif (isset($_GET['err']) && $_GET['err'] == '1') {
    $msg = "<h2 style='color:red'>Hay que iniciar sesión antes</h2>";
} elseif (isset($_GET['logout']) && $_GET['logout'] == '1') {
    $msg = "<h2 style='color:green'>Se ha cerrado la sesión actual</h2>";
}

// Recuperar el nombre de usuario de la cookie si está guardado
$savedUsr = isset($_COOKIE['usrname']) ? $_COOKIE['usrname'] : '';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h2>Login Formulario</h2>
    <form action="index.php" method="POST">
        <label for="txtLogin">Nombre de usuario: </label>
        <input type="text" name="txtLogin" id="txtLogin" value="<?php echo $savedUsr ?>"><br><br>

        <label for="txtPass">Contraseña: </label>
        <input type="password" name="txtPass" id="txtPass"><br><br>

        <label>
            <input type="checkbox" name="rememberMe" id="rememberMe" <?php echo $savedUsr ? 'checked' : ''; ?>> Recordar usuario
        </label><br><br>

        <input type="submit" value="Entrar" name="btnSubmit" id="btnSubmit"><br>
    </form>

    <?php echo $msg ?? ''; ?>

    <h3> <?php echo date("F") . "-" . date("Y"); ?></h3>

    <table border="1px" style="text-align: center;">
        <tr>
            <td>Lun</td>
            <td>Mar</td>
            <td>Mier</td>
            <td>Jue</td>
            <td>Vie</td>
            <td>Sab</td>
            <td>Dom</td>
        </tr>
        <?php
        // Obtener el día actual
        $diaActual = date("j");
        $mesActual = date("m");
        $anioActual = date("Y");

        $dia = 1;
        $nDiesMes = date("t"); // Número de días en el mes
        $primerDiaMes = strtotime(date("Y-m-01")); // Primer día del mes
        $iWDIni = date("w", $primerDiaMes); // Día de la semana del primer día del mes

        // Ajustar el índice para que la semana empiece el lunes
        $iWDIni = ($iWDIni == 0) ? 6 : $iWDIni - 1;

        // Imprimir celdas en blanco hasta el primer día del mes
        echo "<tr>";
        for ($i = 0; $i < $iWDIni; $i++) {
            echo "<td>--</td>";
        }

        // Imprimir los días del mes
        while ($dia <= $nDiesMes) {
            // Verificar si es el día actual y marcarlo
            if ($dia == $diaActual && date("m") == $mesActual && date("Y") == $anioActual) {
                echo "<td style='background-color: yellow; font-weight: bold;'>$dia</td>";
            }
            // Verificar si es domingo para pintar en rojo
            else if ($iWDIni % 7 == 6) {
                echo "<td style='background-color: red; font-weight: bold; color: white;'>$dia</td>";
            } else {
                echo "<td>$dia</td>";
            }

            $dia++;
            $iWDIni++;

            // Si es domingo, cerrar la fila y abrir una nueva
            if ($iWDIni % 7 == 0 && $dia <= $nDiesMes) {
                echo "</tr><tr>";
            }
        }

        // Imprimir celdas en blanco hasta el final de la semana
        while ($iWDIni % 7 != 0) {
            echo "<td>--</td>";
            $iWDIni++;
        }

        echo "</tr>";
        ?>
    </table>
</body>

</html>