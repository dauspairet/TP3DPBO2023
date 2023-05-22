<?php

class Genre extends DB
{
    // Mengambil data genre
    function getGenre()
    {
        $query = "SELECT * FROM genre";
        return $this->execute($query);
    }

    // Filter
    function getFilterGenres($filter = '', $sortBy = 'genre_id', $sortOrder = 'ASC') {
        $query = "SELECT * FROM genre";
    
        if (!empty($filter)) {
            $query .= " WHERE jenis_genre LIKE '%" . $filter . "%'";
        }
    
        $query .= " ORDER BY " . $sortBy . " " . $sortOrder;
    
        return $this->execute($query);
    }

    // Melakukan pencarian
    function searchGenre($keyword)
    {
        $query = "SELECT * FROM genre WHERE jenis_genre LIKE '%$keyword%' ORDER BY genre.genre_id;";
        return $this->execute($query);
    }

    // Mengambil data berdasarkan id
    function getGenreById($id)
    {
        $query = "SELECT * FROM genre WHERE genre_id=$id";
        return $this->execute($query);
    }

    // Menambah data genre
    function addGenre($data)
    {
        $nama = $data['nama'];
        $query = "INSERT INTO genre VALUES('', '$nama')";
        return $this->executeAffected($query);
    }

    // Melakukan update genre
    function updateGenre($id, $data)
    {
        $nama = $data['nama'];
        $query = "UPDATE genre SET jenis_genre='$nama' WHERE genre_id=$id";
        
        return $this->executeAffected($query);
    }

    // Menghapus data genre
    function deleteGenre($id)
    {

        $query = "DELETE FROM genre WHERE genre_id=$id";
        
        return $this->executeAffected($query);
    }
}
