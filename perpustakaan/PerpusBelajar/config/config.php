<?php
// Cek apakah konstan sudah didefinisikan untuk mencegah redeclaration
if (!defined('CONFIG_INCLUDED')) {
    define('CONFIG_INCLUDED', true);

    // Koneksi ke database
    $connection = mysqli_connect("localhost", "root", "", "perpustakaan");

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fungsi untuk membaca data
    function queryReadData($query) {
        global $connection;
        $result = mysqli_query($connection, $query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
}
?>


