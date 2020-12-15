<?php
//include 'index.php';

$host  = "localhost";
$username  = "root";
$password  = "";
$database  = "stki2";
$koneksi  = mysqli_connect($host,  $username,  $password, $database);
$pilihdatabase  = mysqli_select_db($koneksi, "stki2");
if  ($pilihdatabase) echo "<h3>Koneksi Berhasil </h3><hr><br/>";
else echo "Koneksi Gagal <br/>";
?>