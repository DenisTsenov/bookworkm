<?php
//towa e primeren  kod  za validaciq in  img fail
//ako iskash  go izpolzwaj :)
$img = basename($_FILES['fileToUpload']['name']);

$imageFileType = strtolower(pathinfo($img, PATHINFO_EXTENSION));
//            echo ".".$imageFileType;            
$imgSize = $_FILES['fileToUpload']['size'];
if ($imgSize > 100000) {
    echo "Max size is 100 KB!<br>";
}
$f = false;
if ($imageFileType != "jpg" && $imageFileType != "ico" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, ICO, PNG & GIF files are allowed.<br>";
}

if (!file_exists($img)) {
    if (is_uploaded_file($_FILES['fileToUpload']['tmp_name'])) {
        $path = "./uploads/denis." . $imageFileType;
        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $path)) {
            $f = true;
        } else {
            echo "Sorry, something  went  wrong! Try  again  later<br>";
        }
    } else {
        echo "File is  not uploaded!<br>";
    }
} else {
    echo "Sorry, the  file  allready exist!<br>";
}