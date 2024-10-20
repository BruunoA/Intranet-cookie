<?php
define("WEB","Primera web DAW");

include "libs/logged.php";

$page='privat1'; 

?>
<html>

<head>
    <title>Calendario <?php echo date("F") . "-" . date("Y"); ?></title>
</head>
    <div>
        <?php include "libs\menu.php";?>
    </div>

    <body>
    <?php
    // Inicializar las variables mes y año
    $añoActual = date("Y");
    $mesActual = isset($_POST['mes']) ? (int)$_POST['mes'] : date("n");
    $anioActual = isset($_POST['anio']) ? (int)$_POST['anio'] : $añoActual;

    // Procesar el cambio de mes
    if (isset($_POST['cambiar'])) {
        if ($_POST['cambiar'] == 'anterior') {
            $mesActual--;
            if ($mesActual < 1) {
                $mesActual = 12;
                $anioActual--;
            }
        } elseif ($_POST['cambiar'] == 'siguiente') {
            $mesActual++;
            if ($mesActual > 12) {
                $mesActual = 1;
                $anioActual++;
            }
        }
    }
    ?>

    <h3>Calendario <?php echo date("F", mktime(0, 0, 0, $mesActual, 1)) . "-" . $anioActual; ?></h3>

    <!-- Formulario para seleccionar mes y año -->
    <form method="POST" action="" id="calendarioForm">
    <button type="submit" name="cambiar" value="anterior"> << </button>
        <select id="mes" name="mes" onchange="document.forms[0].submit()">
            <?php
            // Crear un select para los meses usando strtotime
            for ($m = 1; $m <= 12; $m++) {
                $selected = ($mesActual == $m) ? 'selected' : '';
                echo "<option value='$m' $selected>" . date("F", strtotime("2024-$m-01")) . "</option>";
            }
            ?>
        </select>

        <select id="anio" name="anio" onchange="document.forms[0].submit()">
            <?php
            // Crear un select para los años
            for ($a = $añoActual - 80; $a <= $añoActual + 80; $a++) {
                $selected = ($anioActual == $a) ? 'selected' : '';
                echo "<option value='$a' $selected>$a</option>";
            }
            ?>
        </select>

        <button type="submit" name="cambiar" value="siguiente"> >> </button>
    </form>

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
        // Obtener el día actual para marcarlo
        $diaActual = date("j");
        $mes = $mesActual;
        $anio = $anioActual;

        $dia = 1;
        $nDiesMes = date("t", strtotime("$anio-$mes-01")); // Número de días en el mes seleccionado
        $primerDiaMes = strtotime("$anio-$mes-01"); // Primer día del mes seleccionado
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
            // Verificar si es domingo para pintar en rojo
            if ($iWDIni % 7 == 6) {
                echo "<td style='background-color: red;'>$dia</td>";
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
