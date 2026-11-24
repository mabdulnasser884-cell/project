<?php

include "./inc/config.php";
include "./inc/header.php";

global $massage;

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
                    <h1 class="col-10">Categories Managment</h1>
                </div>

                <div class="col-6 text-end mt-2"> <a href="./CreateCategorie.php" class=" btn btn-primary ">Create New Categories</a></div>
            </div>

            <hr>
            <!-- table -->
            <div class="card mt-4">
                <div class="card-header">

                    <h4>All Categories</h4>



                </div>
                <div
                    class="table-responsive container ">
                    <table
                        class="table ">

                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">craeted_at</th>
                                <th scope="col">action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $categories = $con->query("SELECT * FROM `categories`");

                            foreach ($categories as $categorie):
                                # code...
                            ?>

                                <tr class="table-secondary">
                                    <td scope="row"><?= $categorie["id"] ?></td>
                                    <td><?= $categorie["name"] ?></td>
                                    <td><?= $categorie["description"] ?></td>
                                    <td><?= $categorie["created_at"] ?></td>
                                    <td>
                                        <a href="./EditCategorie.php?id=<?= $categorie["id"] ?>" class="btn btn-primary">Edit</a>
                                        <a href="./DeleteCategorie.php?id=<?= $categorie["id"] ?>" class="btn btn-danger">Delete</a>
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