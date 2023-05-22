<?php

class Studio extends DB
{
    // Mengambil data studio
    function getStudio()
    {
        $query = "SELECT * FROM studio";
        return $this->execute($query);
    }

    // Mengambil data studio berdasarkan id
    function getStudioById($id)
    {
        $query = "SELECT * FROM studio WHERE studio_id=$id";
        return $this->execute($query);
    }

    // Filter
    function getFilterStudio($filter = '', $sortBy = 'studio_id', $sortOrder = 'ASC') {
        $query = "SELECT * FROM studio";
    
        if (!empty($filter)) {
            $query .= " WHERE nama_studio LIKE '%" . $filter . "%'";
        }
    
        $query .= " ORDER BY " . $sortBy . " " . $sortOrder;
    
        return $this->execute($query);
    }

    // Melakukan pencarian
    function searchStudio($keyword)
    {
        $query = "SELECT * FROM studio WHERE nama_studio LIKE '%$keyword%' ORDER BY studio.studio_id;";
        return $this->execute($query);
    }

    // Menambah data studio
    function addStudio($data)
    {
        $nama = $data['nama'];
        $query = "INSERT INTO studio VALUES('', '$nama')";
        
        return $this->executeAffected($query);
    }

    // Melakukan update data
    function updateStudio($id, $data)
    {
        $nama = $data['nama'];
        $query = "UPDATE studio SET nama_studio='$nama' WHERE studio_id=$id";
        
        return $this->executeAffected($query);
    }

    // Menghapus data studio
    function deleteStudio($id)
    {
        $query = "DELETE FROM studio WHERE studio_id=$id";
        
        return $this->executeAffected($query);
    }
}
