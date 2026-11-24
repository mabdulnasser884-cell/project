<?php

include "./inc/config.php";
include "./inc/header.php";
$id = $_GET["id"];
$get = $con->prepare("SELECT * FROM `posts` WHERE id=?");
$get->execute([$id]);
$one = $get->fetch();

$massage = "";
if (isset($_POST["Add"])) {

    $tilte = $_POST["tilte"];
    $content = $_POST["content"];
    $photo = $_FILES["photo"]["name"];
    $categorie_id = $_POST["categorie"];
    $view = $_POST["view"];
    $status = $_POST["status"];
    // echo  $photo . $tilte . $categorie . $status;
    if ( $tilte && $categorie_id && $status && $view && $content) {

        if ($photo) {
            $path = "./uploads/" . basename($photo);

            move_uploaded_file($_FILES["photo"]["tmp_name"], $path);
            if ($one && file_exists("./uploads/" . $one["image"])) {
                unlink("./uploads/" . $one["image"]);
            }
        } else {
            $photo = $one["image"];
        }

        $categorie = $con->prepare("UPDATE `posts` SET `title`=?,`content`=?,`image`=?,`category_id`=?,`views`=?,`status`=? WHERE id=?");

        $categorie->execute([
            $tilte,
            $content,
            $photo,
            $categorie_id,
            $view,
            $status,
            $id
        ]);
        header("location:IndexPost.php");
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



            <div class="row">
                <div class="col-6">
                    <h1> Add New Posts</h1>

                </div>
                <div class="col-6 text-end">
                    <a href="./IndexPost.php" class="btn btn-secondary mt-1 "><-- Back To Post</a>

                </div>
            </div>


            <div class="card shadow mt-4">
                <div class="card-header ">
                    <h1> Create New Posts</h1>
                </div>
                <form method="post" class="m-3" enctype="multipart/form-data">

                    <div class="mt-4">
                        <label for="tilte">tilte</label>
                        <input type="text" name="tilte" class="form-control" value="<?= $one["title"] ?>">
                    </div>

                    <div class="mt-4">
                        <label for="content">content</label>
                        <textarea type="text" name="content" class="form-control" value=""> <?= $one["content"] ?></textarea>
                    </div>
                    <div class="mt-4">
                        <label for="view">view</label>
                        <input type="number" name="view" class="form-control" value="<?= $one["views"] ?>">
                    </div>
                    <div class="mt-5">
                        <label for="category">categorie</label>

                        <select name="categorie" id="" class="form-control">
                            <?php $get = $con->query("select * from categories");
                            foreach ($get as $one) :
                                # code...
                            ?>
                                <option value="<?= $one["id"] ?>"><?= $one["name"] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="mt-4">
                        <label for="image">image</label>
                        <?php

                        ?>
                        <input type="file" name="photo" class="form-control" value="<?= $one["image"] ?>">
                    </div>
                    <div class="mt-4">
                        <label for="Status">Status</label>
                        <select name="status" id="" class="form-control" value="<?= $one["status"] ?>">
                            <option value="Draft">Draft</option>
                            <option value="published">published</option>
                        </select>
                    </div>

                    <button class="btn btn-primary w-100 mt-4" type="submit" name="Add">Add</button>

                </form>

            </div>
        </main>
        <?php
        include "./inc/footer.php" ?>