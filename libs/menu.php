<?php

defined('WEB') or die('No direct script access allowed');


$menus = array(
    "home" => ["text" => "Home", "link" => "home.php"],
    "calendario" => ["text" => "Calendario", "link" => "calendario_priv.php"],
    "upload" => ["text" => "Upload", "link" => "upload.php"],
    "logout" => ["text" => "Logout", "link" => "logout.php"],
    "test" => ["text" => "Test", "link" => "prueba.php"]
);

?>
<ul>
    <?php foreach ($menus as $id => $menu) : ?>
        <li>
            <?php if ($page != $id): ?>
                <a href='<?= $menu['link'] ?>'>
            <?php endif; ?>
            <?= $menu['text']; ?>
            <?php if ($page != $id): ?>
                </a>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>

</ul>
