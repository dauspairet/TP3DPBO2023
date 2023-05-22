<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Genre.php');
include('classes/Template.php');

$genre = new Genre($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

$genre->open();
$genre->getGenre();

// Penanda filter
$filtered = 0;

// Melakukan pencarian
if (isset($_POST['btn-cari'])) {
    // Mencari data genre
    $genre->searchGenre($_POST['cari']);
    // Penanda filter
    $filtered = 1;
}
else{
    $genre->getGenre();
}

// Melakukan penambahan data genre
if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        // Jika sukses
        if ($genre->addGenre($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'genre.php';
            </script>";
        } else { // Jika gagal
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'genre.php';
            </script>";
        }
    }

    $btn = 'Add';
    $title = 'Add';
}

// Membuka template baru
$view = new Template('templates/skintabel.html');

// Filter
if($filtered == 0){
    $sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'genre_id';
    $sortOrder = isset($_GET['order']) ? $_GET['order'] : 'ASC';
    
    $genre->getFilterGenres($filter, $sortBy, $sortOrder);
}

$mainTitle = 'Genre';
$header = '<tr>
<th scope="row">No.</a></th>
<th scope="row"><a style="text-decoration: none;" href="genre.php?sort=jenis_genre&order=' . ($sortBy == 'jenis_genre' && $sortOrder == 'ASC' ? 'DESC' : 'ASC') . '">Jenis Genre</a></th>
<th scope="row">Aksi</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'Genre';

while ($div = $genre->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['jenis_genre'] . '</td>
    <td style="font-size: 22px;">
        <a href="genre.php?id=' . $div['genre_id'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="genre.php?hapus=' . $div['genre_id'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

// Melakukan edit
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($genre->updateGenre($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'genre.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'genre.php';
            </script>";
            }
        }

        $genre->getGenreById($id);
        $row = $genre->getResult();

        $dataUpdate = $row['jenis_genre'];
        $btn = 'Edit';
        $title = 'Edit';

        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

// Melakukan penghapusan data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        // Jika sukses
        if ($genre->deleteGenre($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'genre.php';
            </script>";
        } else { // Jika gagal
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'genre.php';
            </script>";
        }
    }
}

$genre->close();

// Menukar nilai variabel
$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->write();
