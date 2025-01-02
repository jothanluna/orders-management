<?php
$config = include(__DIR__ . '/../../../config/config.php');
session_start();
session_destroy();
header('Location: ' . BASE_URL . '/public/');
exit;