<?php


include "./inc/config.php";
include "./inc/header.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$id = $_GET["id"];
$get = $con->prepare("SELECT * FROM `posts` WHERE id=?");
$get->execute([$id]);
$one = $get->fetch();

?>
<div class="container-fluid ">
    <div class="row">

        <!-- Sidebar -->
        <?php
        include "./inc/side.php";

        ?>
        <main class="col-md-9 col-lg-10 p-4">
            <div class="card mx-auto w-50">
                <div class="card-header bg-primary text-center text-light p-2">
                    <h1>Info About <span class="text-warning"><?= $one["title"] ?></span></h1>
                </div>
                <div class="card">
                    <img class="card-img-top" src="./uploads/<?= $one["image"]  ?>" alt="Title" />
                    <div class="card-body">
                        <h4 class="card-title"> Status <span class="bg-warning p-2 rounded-2"><?= $one["status"] ?></span> </h4>
                        <h4 class="card-title"> Views <span class="text-danger"><?= $one["views"] ?></span></h4>
                        <p class="card-text"><?= $one["content"] ?></p>
                        <a class="btn btn-outline-success w-100" href="./viewsite.php">Back To ViewSite</a>
                    </div>
                </div>

            </div>

        </main>
    </div>
</div>