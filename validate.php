<?php
$code = $_POST['c'];
$username = $_POST['username'];
$password = $_POST['password'];
require_once('rfc6238.php');
$secretkey = 'GEZDGNBVGY3TQOJQGEZDGNBVGY3TQOJQ';
$currentcode = $code;
$tanggal = date('M j H:i:s');
$remote_ip = $_SERVER['REMOTE_ADDR'];
if (TokenAuth6238::verify($secretkey, $currentcode)) {
    if ($username == 'student' && $password == 'password') {
        echo "Code is valid\n";
    } else {
        error_log("$tanggal - $remote_ip - GAGAL LOGIN");
        echo "username and password is invalid";
    }
} else {
    if ($username == 'student' && $password == 'password') {
        error_log("$tanggal - $remote_ip - GAGAL LOGIN");
        echo "Invalid code\n";
    } else {
        error_log("$tanggal - $remote_ip - GAGAL LOGIN");
        echo "Credentials is invalid";
    }
}
print sprintf('<img src="%s"/>', TokenAuth6238::getBarCodeUrl('riza', 'riza.my.id', $secretkey, 'Riza%20TFA'));
