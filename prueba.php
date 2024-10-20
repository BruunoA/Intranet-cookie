<?php
define("WEB", "Primera web DAW");

include "libs/logged.php";

$page = 'privat2';


//<h1>Pagina test</h1> 
//<div> </div>

//<?php include "libs\menu.php"; ?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Archivos</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .file-list { margin: 20px; }
        .file-list div { margin: 5px 0; }
        .delete-btn { color: red; text-decoration: none; margin-left: 10px; }
    </style>
</head>
<body>
<h1>Pagina test</h1>
<div> </div>

<?php include "libs\menu.php"; ?>
<h1>Gestor de Archivos</h1>

<!-- Formulario para crear carpetas -->
<form action="" method="post">
    <input type="text" name="folder_name" placeholder="Nombre de la carpeta" required>
    <button type="submit" name="create_folder">Crear carpeta</button>
</form>

</br>
<!-- Formulario para cargar archivos -->
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="file" required>
    <button type="submit" name="upload_file">Subir archivo</button>
</form>

<!-- Lista de archivos y carpetas -->
<div class="file-list">
    <h2>Archivos y Carpetas:</h2>
    <?php
    $baseDir = 'uploads/';
    
    // Crear la carpeta "uploads" si no existe
    if (!file_exists($baseDir)) {
        mkdir($baseDir, 0777, true);
        echo "<p>La carpeta 'uploads' ha sido creada automáticamente.</p>";
    }

    // Crear carpeta nueva
    if (isset($_POST['create_folder'])) {
        $folderName = $_POST['folder_name'];
        $newFolderPath = $baseDir . $folderName;
        if (!file_exists($newFolderPath)) {
            mkdir($newFolderPath);
            echo "<p>Carpeta '$folderName' creada con éxito.</p>";
        } else {
            echo "<p>La carpeta '$folderName' ya existe.</p>";
        }
    }

    // Subir archivo
    if (isset($_FILES['file'])) {
        $targetFile = $baseDir . basename($_FILES['file']['name']);
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            echo "<p>Archivo subido correctamente: " . $_FILES['file']['name'] . "</p>";
        } else {
            echo "<p>Error al subir el archivo.</p>";
        }
    }

    // Eliminar archivo o carpeta
    if (isset($_GET['delete'])) {
        $itemToDelete = $baseDir . $_GET['delete'];
        if (is_file($itemToDelete)) {
            if (unlink($itemToDelete)) {
                echo "<p>Archivo '" . $_GET['delete'] . "' eliminado con éxito.</p>";
            } else {
                echo "<p>Error al eliminar el archivo.</p>";
            }
        } elseif (is_dir($itemToDelete)) {
            if (is_dir_empty($itemToDelete)) {
                if (rmdir($itemToDelete)) {
                    echo "<p>Carpeta '" . $_GET['delete'] . "' eliminada con éxito.</p>";
                } else {
                    echo "<p>Error al eliminar la carpeta.</p>";
                }
            } else {
                echo "<p>No se puede eliminar la carpeta '" . $_GET['delete'] . "' porque no está vacía.</p>";
            }
        }
    }

    // Función para comprobar si una carpeta está vacía
    function is_dir_empty($dir) {
        $items = scandir($dir);
        return count($items) == 2; // Solo '.' y '..' están presentes en una carpeta vacía
    }

    // Mostrar archivos y carpetas
    function listFiles($dir) {
        if (file_exists($dir)) {
            $items = scandir($dir);
            foreach ($items as $item) {
                if ($item != '.' && $item != '..') {
                    $itemPath = $dir . $item;
                    if (is_dir($itemPath)) {
                        echo "<div><strong>Carpeta:</strong> <a href='?folder=$item'>$item</a>";
                        echo " <a class='delete-btn' href='?delete=$item' onclick='return confirm(\"¿Estás seguro de que deseas eliminar la carpeta '$item'?\");'>Eliminar</a></div>";
                    } else {
                        echo "<div><strong>Archivo:</strong> <a href='$itemPath' target='_blank'>$item</a>";
                        echo " <a class='delete-btn' href='?delete=$item' onclick='return confirm(\"¿Estás seguro de que deseas eliminar el archivo '$item'?\");'>Eliminar</a></div>";
                    }
                }
            }
        } else {
            echo "<p>No se puede encontrar el directorio '$dir'.</p>";
        }
    }

    // Manejo de navegación entre carpetas
    if (isset($_GET['folder'])) {
        $currentDir = $baseDir . $_GET['folder'] . '/';
        echo "<h3>Carpeta: " . $_GET['folder'] . "</h3>";
        echo "<a href='prueba.php'>Atras</a>";
        listFiles($currentDir);
    } else {
        listFiles($baseDir);
    }
    ?>
</div>

</body>
</html>
