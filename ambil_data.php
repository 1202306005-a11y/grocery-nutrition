<?php
include 'koneksi.php';

if (isset($_POST['nama'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);

    // Cari di tabel 'produk' berdasarkan nama yang mirip
    $query = "SELECT * FROM produk WHERE nama_produk LIKE '%$nama%' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    } else {
        // Jika tidak ada di database, kirim pesan error
        echo json_encode(['error' => 'Data nutrisi produk ini belum tersedia di database.']);
    }
}
?>