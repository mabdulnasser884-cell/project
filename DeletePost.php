<?php

include "./inc/config.php";
include "./inc/header.php";
$id=$_GET["id"];
$get=$con->prepare("SELECT * FROM `posts` WHERE id=?");
$get->execute([$id]);
$one=$get->fetch();
if($one && file_exists("./uploads/".$one["image"])){
    unlink("./uploads/".$one["image"]);
}
$del=$con->prepare("DELETE FROM `posts` WHERE id=?");
$del->execute([$id]);
header("location:IndexPost.php")
?>
