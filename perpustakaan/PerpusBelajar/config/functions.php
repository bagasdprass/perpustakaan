<?php
// Fungsi untuk mencari member
function searchMember($keyword) {
    global $connection;
    // Bersihkan keyword dari karakter berbahaya
    $keyword = mysqli_real_escape_string($connection, $keyword);
    
    $query = "SELECT * FROM member WHERE 
              nama LIKE '%{$keyword}%' OR
              nisn LIKE '%{$keyword}%' OR
              kode_member LIKE '%{$keyword}%' OR
              kelas LIKE '%{$keyword}%' OR
              jurusan LIKE '%{$keyword}%' OR
              jenis_kelamin LIKE '%{$keyword}%' OR
              no_tlp LIKE '%{$keyword}%'";
              
    writeSearchLog("Search Member Query: " . $query);
    return queryReadData($query);
}

// Fungsi untuk mencari buku
function searchBuku($keyword) {
    global $connection;
    // Bersihkan keyword dari karakter berbahaya
    $keyword = mysqli_real_escape_string($connection, $keyword);
    
    $query = "SELECT * FROM buku WHERE 
              judul LIKE '%{$keyword}%' OR
              kategori LIKE '%{$keyword}%' OR
              pengarang LIKE '%{$keyword}%' OR
              penerbit LIKE '%{$keyword}%' OR
              tahun_terbit LIKE '%{$keyword}%'";
              
    writeSearchLog("Search Buku Query: " . $query);
    return queryReadData($query);
}

// Fungsi untuk logging pencarian (nama fungsi diubah)
function writeSearchLog($message) {
    $logFile = __DIR__ . '/search_debug.log';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND);
}

// Fungsi untuk menambah data
function tambahData($data, $table) {
    global $connection;
    $query = "INSERT INTO $table SET ";
    foreach($data as $key => $value) {
        $query .= "$key = '" . mysqli_real_escape_string($connection, $value) . "', ";
    }
    $query = rtrim($query, ', ');
    return mysqli_query($connection, $query);
}

// Fungsi untuk mengupdate data
function updateData($data, $table, $where) {
    global $connection;
    $query = "UPDATE $table SET ";
    foreach($data as $key => $value) {
        $query .= "$key = '" . mysqli_real_escape_string($connection, $value) . "', ";
    }
    $query = rtrim($query, ', ');
    $query .= " WHERE $where";
    return mysqli_query($connection, $query);
}

// Fungsi untuk menghapus data
function deleteData($table, $where) {
    global $connection;
    $query = "DELETE FROM $table WHERE $where";
    return mysqli_query($connection, $query);
}

// Fungsi untuk mengamankan input
function sanitizeInput($data) {
    global $connection;
    return mysqli_real_escape_string($connection, htmlspecialchars($data));
}

// Fungsi untuk format tanggal
function formatDate($date) {
    return date('d F Y', strtotime($date));
}

// Fungsi untuk mengecek apakah data exists
function isDataExists($table, $where) {
    global $connection;
    $query = "SELECT COUNT(*) as count FROM $table WHERE $where";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] > 0;
}
?>