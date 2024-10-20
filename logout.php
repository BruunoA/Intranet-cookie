<?php
/* Block time: 20241003 15:41:22*/
session_start();
 
session_destroy();
header('location: index.php?logout=1');