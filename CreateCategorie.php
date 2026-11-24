<?php

include "./inc/config.php";
include "./inc/header.php";


$massage = "";
if (isset($_POST["Add"])) {
    $Categoryname = $_POST["Category"];
    $description = $_POST["Description"];
    if ($Categoryname && $description) {
        $categorie = $con->prepare("INSERT INTO `categories`( `name`, `description`) VALUES (?,?)");
        $categorie->execute([$Categoryname, $description]);
        header("location:IndexCategorie.php");
        $massage="Created Success";
        # code...
    } else {
        $massage = "Invalid Information";
    }
}
?>
<div class="container-fluid ">
    <div class="row">

        <!-- Sidebar -->
        <?php
        include "./inc/side.php";

        ?>



        <main class="col-md-9 col-lg-10 p-4">
            <?php
            if ($massage) :

            ?>
                <div
                    class="alert alert-danger alert-dismissible fade show"
                    role="alert">
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"></button>

                    <strong><?= $massage ?></strong>

                </div>
            <?php endif ?>




            <div class="card shadow mt-5">
                <div class="card-header ">
                    Add New Category
                </div>
                <form method="post" class="mt-3">
                    <div class="row p-3">
                        <div class="col-4">
                            <label for="Category " class="mb-2">Category Name*</label>
                            <input type="text" name="Category" class="form-control">
                        </div>
                        <div class="col-5">
                            <label for="Description" class="mb-2">Description</label>
                            <input type="text" name="Description" class="form-control">
                        </div>
                        <div class="col-3 mt-4">
                            <button class="btn btn-primary" type="submit" name="Add">Add</button>
                        </div>
                    </div>
                </form>


            </div>
        </main>
        <?php 
        include "./inc/footer.php" ?>