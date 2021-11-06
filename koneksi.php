<?php
$koneksi = mysqli_connect('localhost','root','satusampe250599') or die(mysqli_error());
$db = mysqli_select_db($koneksi,'2016_web_native_siswa') or die (mysqli_error());
?>