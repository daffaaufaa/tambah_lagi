<?php
include "koneksi.php";

$tempat_gmbr = "movie/";
$syaratUPLD = 1;
$nama_random = null;

if (isset($_POST["submit"])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $description = $_POST['description'];
    $release_date = $_POST['release_date'];
    $duration = $_POST['duration'];
    $max_tayang = $_POST['max_tayang'];


    // Cek apakah gambar baru diupload
    if ($_FILES["poster_image"]["name"] != '') {
        $check = getimagesize($_FILES["poster_image"]["tmp_name"]);
        if ($check == true) {
            $nama_random = uniqid() . ".jpg";
            $target_file = $tempat_gmbr . $nama_random;

            if (!move_uploaded_file($_FILES["poster_image"]["tmp_name"], $target_file)) {
                echo "Gagal upload gambar.";
                exit;
            }
        } else {
            echo "File bukan gambar.";
            exit;
        }
    }

    if ($nama_random !== null) {
        $sql = "UPDATE movies SET 
                    title='$title',
                    genre='$genre',
                    description='$description',
                    release_date='$release_date',
                    duration='$duration',
                    poster_image='$nama_random',
                    max_tayang='$max_tayang'
                WHERE id_movies='$id'";
    } else {
        $sql = "UPDATE movies SET 
                    title='$title',
                    genre='$genre',
                    description='$description',
                    release_date='$release_date',
                    duration='$duration',
                    max_tayang='$max_tayang'
                WHERE id_movies ='$id'";
    }

    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        header("location:admin_azfa.php?edit_movies=sukses");
    } else {
        echo "Gagal update data.";
    }
}
?>
