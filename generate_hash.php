<?php
$password = 'Palmeraslocas'; // Cambia por la contraseña que desees hashear
echo password_hash($password, PASSWORD_DEFAULT);
?>