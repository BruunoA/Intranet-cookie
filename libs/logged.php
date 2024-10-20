<?php

session_start();

if (!isset($_SESSION['usr'])) {
    header('location: index.php?err=1');
    die;
}


