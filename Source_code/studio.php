<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Genre.php');
include('classes/Studio.php');
include('classes/Template.php');

$studio = new Studio($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$studio->open();
$studio->getStudio();

// Penanda filter
$filtered = 0;

// Melakukan pencarian
if (isset($_POST['btn-cari'])) {
    // Mencari data studio
    $studio->searchStudio($_POST['cari']);
    $filtered = 1;
}
else{
    $studio->getStudio();
}

// Menambah data studio
if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        // Jika sukses
        if ($studio->addStudio($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'studio.php';
            </script>";
        } else { // Jika gagal
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'studio.php';
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
    $sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'studio_id';
    $sortOrder = isset($_GET['order']) ? $_GET['order'] : 'ASC';

    $studio->getFilterStudio($filter, $sortBy, $sortOrder);
}

$mainTitle = 'Studio';
$header = '<tr>
<th scope="row">No.</a></th>
<th scope="row"><a style="text-decoration: none;" href="studio.php?sort=nama_studio&order=' . ($sortBy == 'nama_studio' && $sortOrder == 'ASC' ? 'DESC' : 'ASC') . '">Nama Studio</a></th>
<th scope="row">Aksi</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'Studio';

while ($div = $studio->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['nama_studio'] . '</td>
    <td style="font-size: 22px;">
        <a href="studio.php?id=' . $div['studio_id'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="studio.php?hapus=' . $div['studio_id'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

// Mengedit data studio
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($studio->updateStudio($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'studio.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'studio.php';
            </script>";
            }
        }

        $studio->getStudioById($id);
        $row = $studio->getResult();

        $dataUpdate = $row['nama_studio'];
        $btn = 'Edit';
        $title = 'Edit';

        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($studio->deleteStudio($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'studio.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'studio.php';
            </script>";
        }
    }
}

$studio->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->write();
