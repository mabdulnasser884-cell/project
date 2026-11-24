<?php
ob_start();

include "./inc/config.php";
include "./inc/header.php"; 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>
<div class="container-fluid ">
    <div class="row">

        <!-- Sidebar -->
        <?php
        include "./inc/side.php";

        ?>
        <main class="col-md-9 col-lg-10 p-4">

            <h1 class="col-10 ">Comments Management</h1>



            <hr>
            <div class="row mt-3">
                <?php
                $getcommenta = $con->query("SELECT COUNT(*) FROM `commenta` ");
                $commenta = $getcommenta->fetch();
                ?>
                <div class="col-3 border-0">
                    <div class="card bg-primary  text-light p-2">
                        <div class="card-body">
                            <h4 class="card-title">Total Comments</h4>
                            <h4 class="card-text"><?= $commenta["COUNT(*)"] ?> </h4>
                        </div>
                    </div>

                </div>
                <?php
                $commentpending = $con->query("SELECT COUNT(*) FROM `commenta` WHERE status='pending'");
                $pending = $commentpending->fetch();
                ?>
                <div class="col-3">
                    <div class="card bg-warning  text-light  p-2">
                        <div class="card-body">
                            <h4 class="card-text">Pending</h4>
                            <h4 class="card-title"><?= $pending["COUNT(*)"] ?></h4>
                        </div>
                    </div>

                </div>
                <?php

                $getapproved = $con->query("SELECT COUNT(*) FROM `commenta` WHERE status='approved'");
                $approved = $getapproved->fetch();

                ?>
                <div class="col-3">
                    <div class="card bg-success  text-light  p-2">
                        <div class="card-body">
                            <h4 class="card-text">Approved</h4>
                            <h4 class="card-title"><?= $approved["COUNT(*)"] ?></h4>
                        </div>
                    </div>

                </div>
                <?php
                $getrejected = $con->query("SELECT COUNT(*) FROM `commenta` WHERE status='rejected'");
                $countcommentrejected = $getrejected->fetch();

                ?>
                <div class="col-3">
                    <div class="card bg-danger  text-light  p-2">
                        <div class="card-body">
                            <h4 class="card-text">Rejected</h4>
                            <h4 class="card-title"><?= $countcommentrejected["COUNT(*)"] ?></h4>
                        </div>
                    </div>

                </div>



            </div>
            <div class="card shadow mt-5">
                <div class="card-header ">
                    <h1> Add New Comment</h1>
                </div>
                <form method="post" class="m-3" enctype="multipart/form-data">



                    <div class="mt-4">
                        <label for="tilte">Select Post</label>
                        <select name="post" id="" class="form-control">
                            <option value="">Select a Post</option>
                            <?php $get = $con->query("SELECT * FROM `posts`");
                            foreach ($get as $one): ?>
                                <option value="<?= $one["id"] ?>"><?= $one["title"] ?></option>
                            <?php endforeach ?>

                        </select>
                    </div>

                    <div class="mt-4">
                        <label for="content">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Name">
                    </div>
                    <div class="mt-4">
                        <label for="view">Comment</label>
                        <textarea type="number" name="comment" class="form-control" placeholder="Enter Comment"></textarea>
                    </div>


                    <div class="mt-4">
                        <button class="btn btn-outline-success w-auto" name="create" type="submit">Add Comment</button>
                    </div>
                    <?php
                    if (isset($_POST["create"])) {
                        $post = $_POST["post"];
                        $comment = $_POST["comment"];
                        $name = $_POST["name"];
                        $create = $con->prepare("INSERT INTO `commenta`( `posts_id`, `name`, `comment`) VALUES (?,?,?)");
                        $create->execute([$post, $comment, $name]);
                        header("location:IndexComment.php");
                    } ?>

                </form>

            </div>
            <div class="card mt-3 shadow">
                <?php
                $comments = $con->query("SELECT * FROM `commenta`");

                ?>
                <div class="card-header bg-secondery p-1">
                    <h3> All Comments</h3>
                </div>
                <div class="container">
                    <div
                        class="table-responsive-md text-center">
                        <table
                            class="table table-light">
                            <thead>
                                <tr class="table-dark">
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Comment</th>
                                    <th scope="col">status</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($commenta as $comment): ?>
                                    <tr class="table-secondary">
                                        <td scope="row"><?= $comment["id"] ?></td>
                                        <td scope="row"><?= $comment["name"] ?></td>
                                        <td scope="row"><?= $comment["comment"] ?></td>
                                        <td scope="row">
                                            <p class="btn btn-success">
                                                <?= $comment["status"] ?>
                                            </p>
                                        </td>
                                        <td scope="row"><?= $comment["created_at"] ?></td>
                                        <td scope="row">
                                            <a href="./DeleteComment?id=<?= $comment["id"] ?>" class="btn btn-primary">Edit</a>
                                            <!-- <button type="submit" name="edit" class="btn btn-primary">Edit</button> -->
                                            <a href="#" class="btn btn-warning">Reject</a>
                                            <a href="./DeleteComment.php?id=<?= $comment["id"] ?>" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>