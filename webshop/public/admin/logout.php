<?php
session_start();

session_unset();
session_destroy();
header('Location: /webshop/public/index.php');
exit();
