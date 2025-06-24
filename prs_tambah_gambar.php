<?php
include "koneksi.php";

$tempat_gmbr = "iklan/";
$target_file = $tempat_gmbr . basename($_FILES["gambar"]["name"]);

$randomName = uniqid() . '.jpg';
$uploadPath = $tempat_gmbr . $randomName;
$syaratUPLD = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// check apakah gambar itu betul gambar atau bukan
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["gambar"]["tmp_name"]);
  if($check == true) {
    echo "File betul gambar - " . $check["mime"] . ".<br>";
    $syaratUPLD = 1;
  } else {
    echo "File bukan gambar.";
    $syaratUPLD = 0;
  }
}

// Check apakah file sudah ada
// if (file_exists($target_file)) {
//   echo "Gambar sudah ada.";
//   $syaratUPLD = 0;
// }

// Check ukuran file
if ($_FILES["gambar"]["size"] < 500000) {
    $check = $_FILES["gambar"]["size"];
    echo "ukuran file ". $check.". ";
}else{
    
    echo "Maaf, ukuran file terlalu besar.";
    $syaratUPLD = 0;
}

// tambahkan syarat format yang bisa ditambahkan
if($imageFileType != "jpg" ) {
  echo "Hanya bisa jpg.";
  $syaratUPLD = 0;
}

// Check apakah $syaratUPLD ada 0 nya
if ($syaratUPLD == 0) {
  echo "File tidak diupload.";
// jika semua ok, lanjut upload filenya
} else {
  if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $uploadPath)) {
    
    echo "The file ". htmlspecialchars( basename( $_FILES["gambar"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}

if($syaratUPLD !== 0){
    

    $sql = "INSERT INTO iklan (gambar) VALUES ('$randomName')";
    $query = mysqli_query($koneksi,$sql);

    if ( $query){
        header("location:admin_azfa.php?tambah_gambar=sukses");
    }
}else{
    echo "<br>";
    echo "<a href='admin_azfa.php'><button>kembali</button></a>";
}
?>