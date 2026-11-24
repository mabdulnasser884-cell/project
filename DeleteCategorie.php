  <?php

  include "./inc/config.php";
  include "./inc/header.php";
  $id = $_GET["id"];
  $del = $con->prepare("DELETE FROM `categories` WHERE id=?");
  $del->execute([$id]);
  header("location:IndexCategorie.php");
  exit();



  ?>