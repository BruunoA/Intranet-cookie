<?php
define("WEB","Primera web DAW");

include "libs/logged.php";
 
$page='home';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
</head>
<body>

    <h1>Pagina principal</h1>
    <div>
        <?php include "libs\menu.php";?>
    </div>
</body>
</html>