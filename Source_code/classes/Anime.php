<?php

class Anime extends DB
{
    // Melakukan join
    function getAnimeJoin()
    {
        $query = "SELECT * FROM anime JOIN genre ON anime.genre_id=genre.genre_id JOIN studio ON anime.studio_id=studio.studio_id ORDER BY anime.anime_id";

        return $this->execute($query);
    }

    // Mengambil data anime
    function getAnime()
    {
        $query = "SELECT * FROM anime";
        return $this->execute($query);
    }

    // Mengambil id
    function getAnimeById($id)
    {
        $query = "SELECT * FROM anime JOIN genre ON anime.genre_id=genre.genre_id JOIN studio ON anime.studio_id=studio.studio_id WHERE anime_id=$id";
        return $this->execute($query);
    }

    // Melakukan search
    function searchAnime($keyword)
    {
        $query = "SELECT * FROM anime JOIN genre ON anime.genre_id=genre.genre_id JOIN studio ON anime.studio_id=studio.studio_id WHERE anime_title LIKE '%$keyword%' ORDER BY anime.anime_id;";
        return $this->execute($query);
    }

    // Untuk melakukan penambahan data
    function addAnime($data, $file)
    {
        //Inisialisasi data anime
        $title = $data['title'];
        $episode = $data['episode'];
        $link = $data['link'];
        $genre = $data['genre'];
        $studio = $data['studio'];

        // Bagian upload foto
        $image = $file['img']['name'];
        $container = $file['img']['tmp_name'];
        $path = 'assets/images/' . $image;
        $isMoved = move_uploaded_file($container, $path);

        if (!$isMoved) {
            $image = 'photo.jpg';
        }

        // Memasukkan data
        $query = "INSERT INTO anime 
        VALUES('', '$image', 
        '$title', 
        '$episode',
        '$link', 
        '$genre', 
        '$studio');";

        return $this->executeAffected($query);
    }

    // Untuk melakukan update
    function updateAnime($id, $data, $file)
    {
        //Inisialisasi data anime
        $title = $data['title'];
        $episode = $data['episode'];
        $link = $data['link'];
        $genre = $data['genre'];
        $studio = $data['studio'];

        // Bagian upload foto
        $image = $file['img']['name'];
        $container = $file['img']['tmp_name'];
        $path = 'assets/images/' . $image;
        $isMoved = move_uploaded_file($container, $path);
        if (!$isMoved) {
            $image = 'photo.jpg';
        }

        // Melakukan update data
        $query = "UPDATE anime SET 
        anime_foto='$image',anime_title='$title', anime_episode='$episode', anime_link='$link', genre_id='$genre', studio_id='$studio' 
        WHERE anime_id=$id;";

        return $this->executeAffected($query);
    }

    // Menghapus data
    function deleteAnime($id)
    {
        $query = "DELETE FROM anime WHERE anime_id=$id";
        return $this->executeAffected($query);
    }
}
