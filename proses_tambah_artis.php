<?php
include "koneksi.php";
$nama = $_POST['nama'];
$id_movies = $_POST['id_movies'];
$gambar = $_FILES['gambar'];

for ($i = 0; $i < count($id_movies); $i++) {

    $tempat_gmbr = "artis/";
    $nama_random = uniqid().".jpg";
    $target_file = $tempat_gmbr . $nama_random;
    $syaratUPLD = 1;

    // check apakah gambar itu betul gambar atau bukan
    if(isset($_POST["submit"])) {
    $check = getimagesize($gambar["tmp_name"][$i]);
    if($check == true) {
        $syaratUPLD = 1;
    } else {
    
        $syaratUPLD = 0;
    }
    }



    // Check apakah $syaratUPLD ada 0 nya
    if ($syaratUPLD == 0) {
    // jika semua ok, lanjut upload filenya
    } else {    
        if (move_uploaded_file($gambar["tmp_name"][$i], $target_file)) {
    
            echo "The file ". htmlspecialchars( basename( $gambar["name"][$i])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    if($syaratUPLD !== 0){

        $sql = "INSERT INTO artis_movies (artis_name, artis_image, id_movies) VALUES ('$nama[$i]', '$nama_random', '$id_movies[$i]')";
        $query = mysqli_query($koneksi,$sql);
    }else{
        echo "Tidak bisa menambahkan gambar";
        echo "<a href='admin_azfa.php'><button>kembali</button></a>";
    }
    
    
}

if ($query){
      header("location:admin_azfa.php?tambah_movies=sukses");
        
}else{
    echo "<a href='admin_azfa.php'><button>kembali</button></a>";
}


?>