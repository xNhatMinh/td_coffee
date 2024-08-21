<?php
$db_name = 'mysql:host=localhost; dbname=td_coffee';
$user_name = 'root';
$user_password = '';
$conn = new PDO($db_name, $user_name, $user_password);
if ($conn) {
    echo "";
}

function unique_id()
{
    $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $charlength = strlen($chars);
    $randomString = '';
    for ($i = 0; $i < 20; $i++) {
        $randomString .= $chars[rand(0, $charlength - 1)];
    }
    return $randomString;
}