<?php

include "./inc/config.php";
include "./inc/header.php";
?>
<div class="container-fluid ">
    <div class="row">

        <!-- Sidebar -->
        <?php
        include "./inc/side.php";

        ?>
        <main class="col-md-9 col-lg-10 p-4">
            <div class="row">
                <div class="col-6 ">
                    <h1 class="col-10 ">Dashboard Overview</h1>
                </div>

                <div class="col-6 text-end mt-2"> <a href="./CreatePost.php" class=" btn btn-primary ">Create New Posts</a></div>
            </div>
            <hr>
            <div class="row mt-3">
                <?php
                $getPost = $con->query("SELECT COUNT(*) FROM `posts` ");
                $post = $getPost->fetch();
                $getpublished = $con->query("SELECT COUNT(*) FROM `posts` WHERE status='published' ");
                $onePost = $getpublished->fetch();


                ?>
                <div class="col-3 border-0">
                    <div class="card bg-primary  text-light p-2">
                        <div class="card-body">
                            <h4 class="card-title"><?= $post["COUNT(*)"] ?></h4>
                            <p class="card-text"> Post(<?= $onePost["COUNT(*)"] ?> Published)</p>
                        </div>
                    </div>

                </div>
                <?php
                $getcategories = $con->query("SELECT COUNT(*) FROM  categories");
                $categories = $getcategories->fetch();



                ?>
                <div class="col-3">
                    <div class="card bg-success  text-light  p-2">
                        <div class="card-body">
                            <h4 class="card-title"><?= $categories["COUNT(*)"] ?></h4>
                            <p class="card-text">categories</p>
                        </div>
                    </div>

                </div>
                <?php

                $getpending = $con->query("SELECT COUNT(*) FROM `comments` WHERE status='pending'");
                $countcomment = $getpending->fetch();

                ?>
                <div class="col-3">
                    <div class="card bg-warning  text-light  p-2">
                        <div class="card-body">
                            <h4 class="card-title"><?= $countcomment["COUNT(*)"] ?></h4>
                            <p class="card-text">Pending Comment</p>
                        </div>
                    </div>

                </div>
                <?php
                $getviews = $con->query("SELECT SUM(views) FROM `posts` ");
                $countview = $getviews->fetch();


                ?>
                <div class="col-3">
                    <div class="card bg-black  text-light  p-2">
                        <div class="card-body">
                            <h4 class="card-title"><?= $countview["SUM(views)"] ?></h4>
                            <p class="card-text">Total Views</p>
                        </div>
                    </div>

                </div>



            </div>
            <div class="card mt-4">
                <div class="card-header">

                    <div class="row">
                        <div class="col-6">
                            <h1 class="col-10 ">Latest Posts</h1>
                        </div>

                        <div class="col-6 text-end mt-2"> <a href="./IndexPost.php" class=" btn btn-outline-secondary ">All Posts Detils</a></div>
                    </div>


                </div>
                <div
                    class="table-responsive container text-center ">
                    <table
                        class="table ">

                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th>title</th>
                                <th scope="col">status</th>
                                <th>image</th>
                                <td>Read More</td>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $posts = $con->query("SELECT * FROM `posts`");
                            foreach ($posts as $post):

                            ?>

                                <tr class="table-secondary">
                                    <td scope="row"><?= $post["id"] ?></td>
                                    <td><?= $post["title"] ?></td>

                                    <td>
                                        <?php
                                        if ($post["status"] == "draft"): ?>
                                            <p class="bg-secondary text-light rounded-2"><?= $post["status"] ?></p>

                                        <?php
                                        else: ?>
                                            <p class="bg-danger text-light rounded-2"><?= $post["status"] ?></p>


                                        <?php endif  ?>

                                    </td>
                                    <td><img src="./uploads/<?= $post["image"]  ?>" alt="" srcset="" width="60px" height="20px" class="img-fluid rounded-3"></td>
                                    <td>
                                        <a href="./showPosts.php?id=<?= $post["id"]  ?>" class="btn btn-primary">More Detalis</a>
                                    </td>


                                </tr>
                            <?php endforeach;







                            ?>
                        </tbody>
                    </table>
                </div>

            </div>


        </main>
    </div>