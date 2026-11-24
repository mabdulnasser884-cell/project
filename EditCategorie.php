<?php

include "./inc/config.php";
include "./inc/header.php";
$id = $_GET["id"];
$get = $con->prepare("SELECT * FROM `categories` where id=?");
$get->execute([$id]);
$one = $get->fetch();

if (isset($_POST["Add"])) {
    $Categoryname = $_POST["Category"];
    $description = $_POST["Description"];
    // echo $Categoryname . $description;
    $categorie = $con->prepare("UPDATE `categories` SET `name`=?,`description`=? WHERE id=?");
    $categorie->execute([$Categoryname, $description, $id]);
    header("location:IndexCategorie.php");
}

?>
<div class="container-fluid ">
    <div class="row">

        <!-- Sidebar -->
        <?php
        include "./inc/side.php";

        ?>



        <main class="col-md-9 col-lg-10 p-4">


            <div class="card shadow mt-5">
                <div class="card-header ">
                    Add New Category
                </div>
                <form method="post" class="mt-3">
                    <div class="row p-3">
                        <div class="col-4">
                            <label for="Category " class="mb-2">Category Name*</label>
                            <input type="text" name="Category" class="form-control" value="<?= $one["name"] ?>">
                        </div>
                        <div class="col-5">
                            <label for="Description" class="mb-2">Description</label>
                            <input type="text" name="Description" class="form-control" value="<?= $one["description"] ?>">
                        </div>
                        <div class="col-3 mt-4">
                            <button class="btn btn-primary" type="submit" name="Add">Add</button>
                        </div>
                    </div>
                </form>

            </div>
        </main>