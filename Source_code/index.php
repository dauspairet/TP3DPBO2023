<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Genre.php');
include('classes/Studio.php');
include('classes/Anime.php');
include('classes/Template.php');

// Membuat instance anime
$listAnime = new Anime($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// Membuka koneksi
$listAnime->open();
// Menampilkan data anime
$listAnime->getAnimeJoin();

// Melakukan pencarian
if (isset($_POST['btn-cari'])) {
    // Mencari anime
    $listAnime->searchAnime($_POST['cari']);
} else {
    // Menampilkan data
    $listAnime->getAnimeJoin();
}

$data = null;

// Mengambil data anime
// mengabungkan dgn tag html
// untuk di passing ke skin/template
while ($row = $listAnime->getResult()) {
    $data .= 
    '<div class="col gx-1 gy-3 justify-content-center">' .
        '<div class="card pt-4 px-2 pengurus-thumbnail">
            <a href="detail.php?id=' . $row['anime_id'] . '">
                <div class="row justify-content-center">
                    <img src="assets/images/' . $row['anime_foto'] . '" class="card-img-top" alt="' . $row['anime_foto'] . '">
                </div>
                <div class="card-body">
                    <p class="card-text pengurus-nama my-0">' . $row['anime_title'] . '</p>
                    <p class="card-text divisi-nama">' . $row['jenis_genre'] . '</p>
                    <p class="card-text jabatan-nama my-0">' . $row['nama_studio'] . '</p>
                </div>
            </a>
        </div>    
    </div>';
}

// tutup koneksi
$listAnime->close();

// buat instance template
$home = new Template('templates/skin.html');

// simpan data ke template
$home->replace('DATA_ANIME', $data);
$home->write();
