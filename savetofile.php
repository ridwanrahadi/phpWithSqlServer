<?php

if (isset($_FILES['myFile'])) {
    // Example:
    $nama	= $_POST['txtcari'];
    move_uploaded_file($_FILES['myFile']['tmp_name'], "uploads/".$_FILES['myFile']['name']);
    echo 'successful';
    echo $nama;
}
?>