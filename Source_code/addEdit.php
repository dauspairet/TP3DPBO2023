<?php
include('config/db.php');
include('classes/DB.php');
include('classes/Genre.php');
include('classes/Studio.php');
include('classes/Anime.php');
include('classes/Template.php');

$anime = new Anime($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$genre = new Genre($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$studio = new Studio($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

$anime->open();
$genre->open();
$studio->open();

$dataGenre = null;
$dataStudio = null;

if (isset($_POST['btnAdd'])) {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        if ($anime->updateAnime($id, $_POST, $_FILES) > 0) {
            echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'index.php';
            </script>";
        }
    } else {
        if ($anime->addAnime($_POST, $_FILES) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'index.php';
            </script>";
        }
    }
}

$title = isset($_GET['id']) ? 'Edit' : 'Add';

$genre->getGenre();
$studio->getStudio();

$listGenre = [];
while ($tempGenre = $genre->getResult()) {
    $listGenre[] = $tempGenre;
}

$listStudio = [];
while ($tempStudio = $studio->getResult()) {
    $listStudio[] = $tempStudio;
}

foreach ($listGenre as $tempGenre) {
    $dataGenre .= '<option value="' . $tempGenre['genre_id'] . '">' . $tempGenre['jenis_genre'] . '</option>';
}

foreach ($listStudio as $tempStudio) {
    $dataStudio .= '<option value="' . $tempStudio['studio_id'] . '">' . $tempStudio['nama_studio'] . '</option>';
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        $anime->getAnimeById($id);
        $row = $anime->getResult();

        $dataAnime = [];
        $dataAnime[0] = $row['anime_title'];
        $dataAnime[1] = $row['anime_episode'];
        $dataAnime[2] = $row['anime_link'];
        $dataAnime[3] = $row['genre_id'];
        $dataAnime[4] = $row['studio_id'];

        $anime->close();
        $genre->close();
        $studio->close();

        $tambah = new Template('templates/skinform.html');
        $tambah->replace('DATA_TITLE', $title);
        $tambah->replace('DATA_GENRE', $dataGenre);
        $tambah->replace('DATA_STUDIO', $dataStudio);
        $tambah->replace('DATA_NAMA', $dataAnime[0]);
        $tambah->replace('DATA_EPS', $dataAnime[1]);
        $tambah->replace('DATA_SC', $dataAnime[2]);
        $tambah->replace('DATA_GR', $dataAnime[3]);
        $tambah->replace('DATA_ST', $dataAnime[4]);
        $tambah->write();
        exit();
    }
}

$anime->close();
$genre->close();
$studio->close();

$tambah = new Template('templates/skinform.html');
$tambah->replace('DATA_TITLE', $title);
$tambah->replace('DATA_GENRE', $dataGenre);
$tambah->replace('DATA_STUDIO', $dataStudio);
$tambah->replace('DATA_NAMA', '');
$tambah->replace('DATA_EPS', '');
$tambah->replace('DATA_SC', '');
$tambah->replace('DATA_GR', '');
$tambah->replace('DATA_ST', '');
$tambah->write();
?>
