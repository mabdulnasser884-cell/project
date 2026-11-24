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
                <div class="col-6">
                    <h1 class="col-10">Posts Managment</h1>
                </div>

                <div class="col-6 text-end mt-2"> <a href="./CreatePost.php" class=" btn btn-primary ">Create New Posts</a></div>
            </div>





            <hr>
            <!-- table -->
            <div class="card mt-4">
                <div class="card-header">

                    <h4 class="col-6">All Posts</h4>


                </div>
                <div
                    class="table-responsive container text-center ">
                    <table
                        class="table ">

                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th>title</th>
                                <th scope="col">content</th>
                                <th scope="col">status</th>
                                <th>views</th>
                                <th>image</th>
                                <th>category_id</th>
                                <th scope="col">craeted_at</th>
                                <th scope="col">action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $posts = $con->query("SELECT * FROM `posts`");
                            foreach ($posts as $post):

                            ?>

                                <tr class="table-secondary">
                                    <td scope="row"><?= $post["id"] ?></td>
                                    <td><?= $post["title"] ?></td>
                                    <td><?= $post["content"] ?></td>
                                    <td>
                                        <?php
                                        if ($post["status"] == "draft"): ?>
                                            <p class="bg-success text-light rounded-2"><?= $post["status"] ?></p>

                                        <?php
                                        else: ?>
                                            <p class="bg-danger text-light rounded-2"><?= $post["status"] ?></p>


                                        <?php endif  ?>

                                    </td>
                                    <td><?= $post["views"] ?></td>
                                    <td><img src="./uploads/<?= $post["image"]  ?>" alt="" srcset="" width="60px" height="20px" class="img-fluid rounded-3"></td>
                                    <td><?= $post["category_id"] ?></td>
                                    <td><?= $post["created_at"] ?></td>
                                    <td>
                                        <!-- <a href="./EditPost.php?id=  class="btn btn-primary" >Edit</a> -->
                                        <a href="./EditPost.php?id=<?= $post["id"]  ?>" class="btn btn-warning">Edit</a>
                                        <a href="./DeletePost.php?id=<?= $post["id"] ?>" class="btn btn-danger">Delete</a>
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
</div>
<footer class="bg-black text-center text-light p-3">
    <p>&copy;2025 PHP Blog Dashboard</p>
</footer>





<script src="./js/bootstrap.bundle.min.js"></script>

</body>

</html>