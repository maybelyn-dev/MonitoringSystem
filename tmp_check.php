<?php
$mysqli = new mysqli('127.0.0.1','root','', 'monitoring_system');
if ($mysqli->connect_errno) { echo "connect_fail\n"; exit(1); }
$email = 'datamonitoring123@gmail.com';
$pass = 'password';
$res = $mysqli->query("select password from users where email='" . $mysqli->real_escape_string($email) . "' limit 1");
$row = $res ? $res->fetch_assoc() : null;
if (!$row) { echo "no_user\n"; exit; }
$hash = $row['password'];
$ok = password_verify($pass, $hash) ? 'yes' : 'no';
echo "password_verify=$ok\n";
?>
