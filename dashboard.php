<?php

ob_start();

include "./inc/config.php";

// ==============================
// Statistics
// ==============================

$totalPosts = (int) $con->query(
    "SELECT COUNT(*) FROM posts"
)->fetchColumn();

$totalCommenta= (int) $con->query(
    "SELECT COUNT(*) FROM `commenta`"
)->fetchColumn();

$pendingCommenta = (int) $con->query(
    "SELECT COUNT(*) FROM commenta WHERE status = 'pending'"
)->fetchColumn();

$approvedCommenta = (int) $con->query(
    "SELECT COUNT(*) FROM commenta WHERE status = 'approved'"
)->fetchColumn();

$rejectedCommenta = (int) $con->query(
    "SELECT COUNT(*) FROM commenta WHERE status = 'rejected'"
)->fetchColumn();

$totalCategories = (int) $con->query(
    "SELECT COUNT(*) FROM categories"
)->fetchColumn();



$recentPosts = $con->query("
    SELECT id, title
    FROM posts
    ORDER BY id DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);



$recentCommenta = $con->query("
    SELECT id, name, comment, status, created_at
    FROM commenta
    ORDER BY id DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

include "./inc/header.php";

?>



<div class="container-fluid">

    <div class="row">

        <?php include "./inc/side.php"; ?>

        <main class="col-md-9 col-lg-10 p-4">

            <!-- Welcome -->
            <div class="mb-4">

                <h1 class="fw-bold">Dashboard</h1>

                <p class="text-muted">
                    Welcome to your Blog Management System.
                    Here's an overview of your website.
                </p>

            </div>


            <!-- ============================== -->
            <!-- Statistics Cards -->
            <!-- ============================== -->

            <div class="row">

                <!-- Total Posts -->
                <div class="col-md-6 col-lg-4 col-xl mb-3">

                    <div class="card bg-primary text-white shadow h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between">

                                <div>
                                    <h6>Total Posts</h6>

                                    <h2 class="fw-bold">
                                        <?= $totalPosts ?>
                                    </h2>
                                </div>

                                <i class="fa-solid fa-file-lines fa-2x"></i>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- Total Comments -->
                <div class="col-md-6 col-lg-4 col-xl mb-3">

                    <div class="card bg-info text-white shadow h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between">

                                <div>
                                    <h6>Total Comments</h6>

                                    <h2 class="fw-bold">
                                        <?= $totalCommenta ?>
                                    </h2>
                                </div>

                                <i class="fa-solid fa-comments fa-2x"></i>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- Pending Comments -->
                <div class="col-md-6 col-lg-4 col-xl mb-3">

                    <div class="card bg-warning text-dark shadow h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between">

                                <div>
                                    <h6>Pending Comments</h6>

                                    <h2 class="fw-bold">
                                        <?= $pendingCommenta ?>
                                    </h2>
                                </div>

                                <i class="fa-solid fa-clock fa-2x"></i>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- Approved Comments -->
                <div class="col-md-6 col-lg-4 col-xl mb-3">

                    <div class="card bg-success text-white shadow h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between">

                                <div>
                                    <h6>Approved Comments</h6>

                                    <h2 class="fw-bold">
                                        <?= $approvedCommenta ?>
                                    </h2>
                                </div>

                                <i class="fa-solid fa-circle-check fa-2x"></i>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- Categories -->
                <div class="col-md-6 col-lg-4 col-xl mb-3">

                    <div class="card bg-dark text-white shadow h-100">

                        <div class="card-body">

                            <div class="d-flex justify-content-between">

                                <div>
                                    <h6>Categories</h6>

                                    <h2 class="fw-bold">
                                        <?= $totalCategories ?>
                                    </h2>
                                </div>

                                <i class="fa-solid fa-folder fa-2x"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- ============================== -->
            <!-- Charts -->
            <!-- ============================== -->

            <div class="row mt-4">

                <!-- Comments Status Chart -->
                <div class="col-lg-6 mb-4">

                    <div class="card shadow h-100">

                        <div class="card-header">
                            <h4 class="mb-0">Comments Status</h4>
                        </div>

                        <div class="card-body">

                            <div style="height: 300px;">

                                <canvas
                                    id="commentsChart"

                                    data-pending="<?= $pendingCommenta ?>"
                                    data-approved="<?= $approvedCommenta ?>"
                                    data-rejected="<?= $rejectedCommenta ?>">

                                </canvas>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- Posts & Comments Chart -->
                <div class="col-lg-6 mb-4">

                    <div class="card shadow h-100">

                        <div class="card-header">
                            <h4 class="mb-0">Posts & Comments</h4>
                        </div>

                        <div class="card-body">

                            <div style="height: 300px;">

                                <canvas
                                    id="postsChart"

                                    data-posts="<?= $totalPosts ?>"
                                    data-comments="<?= $totalCommenta ?>">

                                </canvas>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- ============================== -->
            <!-- Quick Actions -->
            <!-- ============================== -->

            <div class="card shadow mt-3">

                <div class="card-header">
                    <h4 class="mb-0">Quick Actions</h4>
                </div>

                <div class="card-body">

                    <a href="CreatePost.php"
                        class="btn btn-primary me-2 mb-2">

                        <i class="fa-solid fa-plus"></i>
                        Add New Post

                    </a>

                    <a href="index.php"
                        class="btn btn-success mb-2">

                        <i class="fa-solid fa-comments"></i>
                        Manage Comments

                    </a>

                </div>

            </div>


            <!-- ============================== -->
            <!-- Recent Posts -->
            <!-- ============================== -->

            <div class="card shadow mt-4">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <h4 class="mb-0">Recent Posts</h4>

                    <span class="badge bg-primary">
                        Latest 5 Posts
                    </span>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-hover text-center">

                            <thead class="table-dark">

                                <tr>
                                    <th>ID</th>
                                    <th>Post Title</th>
                                </tr>

                            </thead>

                            <tbody>

                                <?php if (count($recentPosts) > 0): ?>

                                    <?php foreach ($recentPosts as $post): ?>

                                        <tr>

                                            <td>
                                                <?= $post["id"] ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($post["title"]) ?>
                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                <?php else: ?>

                                    <tr>
                                        <td colspan="2">
                                            No Posts Found
                                        </td>
                                    </tr>

                                <?php endif; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>


            <!-- ============================== -->
            <!-- Recent Comments -->
            <!-- ============================== -->

            <div class="card shadow mt-4 mb-5">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <h4 class="mb-0">Recent Comments</h4>

                    <span class="badge bg-primary">
                        Latest 5 Comments
                    </span>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-hover text-center">

                            <thead class="table-dark">

                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Comment</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>

                            </thead>

                            <tbody>

                                <?php if (count($recentCommenta) > 0): ?>

                                    <?php foreach ($recentCommenta as $one): ?>

                                        <tr>

                                            <td>
                                                <?= $one["id"] ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($one["name"]) ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($one["comment"]) ?>
                                            </td>

                                            <td>

                                                <?php if ($one["status"] == "pending"): ?>

                                                    <span class="badge bg-warning text-dark">
                                                        Pending
                                                    </span>

                                                <?php elseif ($one["status"] == "approved"): ?>

                                                    <span class="badge bg-success">
                                                        Approved
                                                    </span>

                                                <?php else: ?>

                                                    <span class="badge bg-danger">
                                                        Rejected
                                                    </span>

                                                <?php endif; ?>

                                            </td>

                                            <td>
                                                <?= htmlspecialchars($one["created_at"]) ?>
                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                <?php else: ?>

                                    <tr>
                                        <td colspan="5">
                                            No Comments Found
                                        </td>
                                    </tr>

                                <?php endif; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </main>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="charts.js"></script>

</body>

</html>