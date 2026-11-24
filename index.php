<?php
ob_start();

include "./inc/config.php";



$editComment = null;

if (isset($_GET["edit"])) {

    $id = $_GET["edit"];

    $getEdit = $con->prepare(
        "SELECT * FROM `commenta` WHERE id = ?"
    );

    $getEdit->execute([$id]);

    $editComment = $getEdit->fetch();
}




if (isset($_POST["create"])) {

    $post_id = $_POST["post"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $comment = $_POST["comment"];
    $status = $_POST["status"];

    $create = $con->prepare("INSERT INTO `commenta`(`post_id`, `name`, `email`, `comment`, `status`) VALUES ()");

    $create->execute([$post_id,$name,$email,$comment,$status]);
}



if (isset($_POST["update"])) {

    $id = $_POST["id"];
    $post = $_POST["post"];
    $name = $_POST["name"];
    $comment = $_POST["comment"];

    $update = $con->prepare("UPDATE comments SET posts_id = ?, name = ?, comment = ? WHERE id = ?
    ");

    $update->execute([$post, $name, $comment, $id]);
}




if (isset($_POST["update_status"])) {

    $id = $_POST["id"];
    $status = $_POST["status"];

    if (in_array($status, ["pending", "approved", "rejected"])) {

        $update = $con->prepare("
            UPDATE comments
            SET status = ?
            WHERE id = ?
        ");

        $update->execute([$status, $id]);
    }
}




if (isset($_POST["delete"])) {

    $id = $_POST["id"];

    $delete = $con->prepare(
        "DELETE FROM comments WHERE id = ?"
    );

    $delete->execute([$id]);
}




include "./inc/header.php";

?>

<div class="container-fluid">

    <div class="row">

        <?php include "./inc/side.php"; ?>

        <main class="col-md-9 col-lg-10 p-4">

            <h1>Comments Management</h1>

            <hr>

            <?php

        

            $total = $con->query(
                "SELECT COUNT(*) FROM commenta"
            )->fetchColumn();

            $pending = $con->query(
                "SELECT COUNT(*) FROM commenta WHERE status='pending'"
            )->fetchColumn();

            $approved = $con->query(
                "SELECT COUNT(*) FROM commenta WHERE status='approved'"
            )->fetchColumn();

            $rejected = $con->query(
                "SELECT COUNT(*) FROM commenta WHERE status='rejected'"
            )->fetchColumn();

            ?>


            <div class="row mt-3">

                <div class="col-md-3 mb-3">

                    <div class="card bg-primary text-light p-2">

                        <div class="card-body">

                            <h4>Total Comments</h4>

                            <h4><?= $total ?></h4>

                        </div>

                    </div>

                </div>


                <div class="col-md-3 mb-3">

                    <div class="card bg-warning text-light p-2">

                        <div class="card-body">

                            <h4>Pending</h4>

                            <h4><?= $pending ?></h4>

                        </div>

                    </div>

                </div>


                <div class="col-md-3 mb-3">

                    <div class="card bg-success text-light p-2">

                        <div class="card-body">

                            <h4>Approved</h4>

                            <h4><?= $approved ?></h4>

                        </div>

                    </div>

                </div>


                <div class="col-md-3 mb-3">

                    <div class="card bg-danger text-light p-2">

                        <div class="card-body">

                            <h4>Rejected</h4>

                            <h4><?= $rejected ?></h4>

                        </div>

                    </div>

                </div>

            </div>


      

            <div class="card shadow mt-5">

                <div class="card-header">

                    <h3>
                        <?= $editComment ? "Edit Comment" : "Add New Comment" ?>
                    </h3>

                </div>


                <form method="POST" class="m-3">

                    <?php if ($editComment): ?>

                        <input
                            type="hidden"
                            name="id"
                            value="<?= $editComment["id"] ?>">

                    <?php endif; ?>



                    <div class="mt-4">

                        <label>Select Post</label>

                        <select
                            name="post"
                            class="form-control"
                            required>

                            <option value="">Select a Post</option>

                            <?php

                            $getPosts = $con->query(
                                "SELECT * FROM posts"
                            );

                            foreach ($getPosts as $one):

                            ?>

                                <option
                                    value="<?= $one["id"] ?>"

                                    <?= (
                                        $editComment &&
                                        $editComment["posts_id"] == $one["id"]
                                    ) ? "selected" : "" ?>>

                                    <?= htmlspecialchars($one["title"]) ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>



                    <div class="mt-4">

                        <label>Name</label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            placeholder="Enter Name"
                            value="<?= $editComment ? htmlspecialchars($editComment["name"]) : "" ?>"
                            required>

                    </div>



                    <div class="mt-4">

                        <label>Comment</label>

                        <textarea
                            name="comment"
                            class="form-control"
                            placeholder="Enter Comment"
                            required><?= $editComment ? htmlspecialchars($editComment["comment"]) : "" ?></textarea>

                    </div>



                    <div class="mt-4">

                        <?php if ($editComment): ?>

                            <button
                                type="submit"
                                name="update"
                                class="btn btn-primary">

                                Update Comment

                            </button>


                            <a
                                href="IndexComment.php"
                                class="btn btn-secondary">

                                Cancel

                            </a>

                        <?php else: ?>

                            <button
                                type="submit"
                                name="create"
                                class="btn btn-outline-success">

                                Add Comment

                            </button>

                        <?php endif; ?>

                    </div>

                </form>

            </div>



            <div class="card mt-4 shadow">

                <div class="card-header">

                    <h3>All Comments</h3>

                </div>


                <div class="container-fluid">

                    <div class="table-responsive mt-3">

                        <table class="table table-light text-center">

                            <thead>

                                <tr class="table-dark">

                                    <th>#</th>

                                    <th>Name</th>

                                    <th>Comment</th>

                                    <th>Status</th>

                                    <th>Date</th>

                                    <th>Actions</th>

                                </tr>

                            </thead>


                            <tbody>

                                <?php

                                $comments = $con->query(
                                    "SELECT * FROM commenta ORDER BY id DESC"
                                );

                                foreach ($comments as $comment):

                                ?>

                                    <tr class="table-secondary">

                                        <td>
                                            <?= $comment["id"] ?>
                                        </td>


                                        <td>
                                            <?= htmlspecialchars($comment["name"]) ?>
                                        </td>


                                        <td>
                                            <?= htmlspecialchars($comment["comment"]) ?>
                                        </td>



                                        <td>

                                            <?php if ($comment["status"] == "pending"): ?>

                                                <span class="badge bg-warning">
                                                    Pending
                                                </span>

                                            <?php elseif ($comment["status"] == "approved"): ?>

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
                                            <?= $comment["created_at"] ?>
                                        </td>



                                        <td>


                                            <a href="edit.php?edit=<?= $comment['id'] ?>"
                                                class="btn btn-primary btn-sm">
                                                Edit
                                            </a>


                                            <?php if ($comment["status"] == "pending"): ?>



                                                <form
                                                    method="POST"
                                                    class="d-inline">

                                                    <input
                                                        type="hidden"
                                                        name="id"
                                                        value="<?= $comment["id"] ?>">

                                                    <input
                                                        type="hidden"
                                                        name="status"
                                                        value="approved">

                                                    <button
                                                        type="submit"
                                                        name="update_status"
                                                        class="btn btn-success btn-sm">

                                                        Approve

                                                    </button>

                                                </form>



                                                <form
                                                    method="POST"
                                                    class="d-inline">

                                                    <input
                                                        type="hidden"
                                                        name="id"
                                                        value="<?= $comment["id"] ?>">

                                                    <input
                                                        type="hidden"
                                                        name="status"
                                                        value="rejected">

                                                    <button
                                                        type="submit"
                                                        name="update_status"
                                                        class="btn btn-danger btn-sm">

                                                        Reject

                                                    </button>

                                                </form>


                                            <?php elseif ($comment["status"] == "approved"): ?>



                                                <form
                                                    method="POST"
                                                    class="d-inline">

                                                    <input
                                                        type="hidden"
                                                        name="id"
                                                        value="<?= $comment["id"] ?>">

                                                    <input
                                                        type="hidden"
                                                        name="status"
                                                        value="pending">

                                                    <button
                                                        type="submit"
                                                        name="update_status"
                                                        class="btn btn-warning btn-sm">

                                                        Pending

                                                    </button>

                                                </form>



                                                <form
                                                    method="POST"
                                                    class="d-inline">

                                                    <input
                                                        type="hidden"
                                                        name="id"
                                                        value="<?= $comment["id"] ?>">

                                                    <input
                                                        type="hidden"
                                                        name="status"
                                                        value="rejected">

                                                    <button
                                                        type="submit"
                                                        name="update_status"
                                                        class="btn btn-danger btn-sm">

                                                        Reject

                                                    </button>

                                                </form>


                                            <?php elseif ($comment["status"] == "rejected"): ?>



                                                <form
                                                    method="POST"
                                                    class="d-inline">

                                                    <input
                                                        type="hidden"
                                                        name="id"
                                                        value="<?= $comment["id"] ?>">

                                                    <input
                                                        type="hidden"
                                                        name="status"
                                                        value="approved">

                                                    <button
                                                        type="submit"
                                                        name="update_status"
                                                        class="btn btn-success btn-sm">

                                                        Approve

                                                    </button>

                                                </form>



                                                <form
                                                    method="POST"
                                                    class="d-inline">

                                                    <input
                                                        type="hidden"
                                                        name="id"
                                                        value="<?= $comment["id"] ?>">

                                                    <input
                                                        type="hidden"
                                                        name="status"
                                                        value="pending">

                                                    <button
                                                        type="submit"
                                                        name="update_status"
                                                        class="btn btn-warning btn-sm">

                                                        Pending

                                                    </button>

                                                </form>


                                            <?php endif; ?>



                                            <form
                                                method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this comment?')">

                                                <input
                                                    type="hidden"
                                                    name="id"
                                                    value="<?= $comment["id"] ?>">

                                                <button
                                                    type="submit"
                                                    name="delete"
                                                    class="btn btn-dark btn-sm">

                                                    Delete

                                                </button>

                                            </form>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </main>

    </div>

</div>