<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Genre.php');
include('classes/Studio.php');
include('classes/Anime.php');
include('classes/Template.php');

$anime = new Anime($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$anime->open();

$data = nulL;

// Menghapus data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    // Jika sukses
    if ($id > 0) {
        if ($anime->deleteAnime($id) > 0) {
            echo "
					<script>
						alert('Data berhasil dihapus!');
						document.location.href = 'index.php';
					</script>
				";
        } else { // jika gagal
            echo "
					<script>
						alert('Data gagal dihapus!');
						document.location.href = 'index.php';
					</script>
				";
        }
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        $anime->getAnimeById($id);
        $row = $anime->getResult();

        $data .= '<div class="card-header text-center">
        <h3 class="my-0">Detail ' . $row['anime_title'] . '</h3>
        </div>
        <div class="card-body text-end">
            <div class="row mb-5">
                <div class="col-3">
                    <div class="row justify-content-center">
                        <img src="assets/images/' . $row['anime_foto'] . '" class="img-thumbnail" alt="' . $row['anime_foto'] . '" width="60">
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card px-3">
                            <table border="0" class="text-start">
                                <tr>
                                    <td>Title</td>
                                    <td>:</td>
                                    <td>' . $row['anime_title'] . '</td>
                                </tr>
                                <tr>
                                    <td>Episode</td>
                                    <td>:</td>
                                    <td>' . $row['anime_episode'] . '</td>
                                </tr>
                                <tr>
                                    <td>Source</td>
                                    <td>:</td>
                                    <td><a href="' . $row['anime_link'] . '">' . $row['anime_link'] . '</a></td>
                                </tr>
                                <tr>
                                    <td>Genre</td>
                                    <td>:</td>
                                    <td>' . $row['jenis_genre'] . '</td>
                                </tr>
                                <tr>
                                    <td>Studio</td>
                                    <td>:</td>
                                    <td>' . $row['nama_studio'] . '</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="addEdit.php?id=' . $row['anime_id'] . '"><button type="button" class="btn btn-success text-white">Edit</button></a>
                <a href="detail.php?hapus=' . $row['anime_id'] . '"><button type="button" class="btn btn-danger">Delete</button></a>
            </div>';
    }
}

$anime->close();
$detail = new Template('templates/skindetail.html');
$detail->replace('DATA_DETAIL_ANIME', $data);
$detail->write();
