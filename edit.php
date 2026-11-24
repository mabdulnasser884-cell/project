<?php

ob_start();

include "./inc/config.php";


$id = (int) $_GET["edit"];

$getComment = $con->prepare("
    SELECT * FROM comments
    WHERE id = ?
");

$getComment->execute([$id]);

$comment = $getComment->fetch(PDO::FETCH_ASSOC);

if (!$comment) {
    header("Location: index.php");
    exit;
}

if (isset($_POST["update"])) {

    $id = (int) $_POST["id"];
    $post = $_POST["post"];
    $name = trim($_POST["name"]);
    $commentText = trim($_POST["comment"]);

    if (!empty($post) && !empty($name) && !empty($commentText)) {

        $update = $con->prepare("
            UPDATE comments
            SET posts_id = ?, name = ?, comment = ?
            WHERE id = ?
        ");

        $update->execute([
            $post,
            $name,
            $commentText,
            $id
        ]);

        header("Location: index.php");
        exit;
    }
}

$getPosts = $con->query("SELECT * FROM posts");

include "./inc/header.php";

?>

<div class="container-fluid">

    <div class="row">

        <?php include "./inc/side.php"; ?>

        <main class="col-md-9 col-lg-10 p-4">

            <h1>Edit Comment</h1>

            <hr>

            <div class="card shadow mt-4">

                <div class="card-header">
                    <h3>Update Comment</h3>
                </div>

                <div class="card-body">

                    <form method="POST">

                        <input
                            type="hidden"
                            name="id"
                            value="<?= $comment["id"] ?>">

                        <div class="mb-4">

                            <label class="form-label">
                                Select Post
                            </label>

                            <select
                                name="post"
                                class="form-control"
                                required>

                                <option value="">
                                    Select a Post
                                </option>

                                <?php foreach ($getPosts as $one): ?>

                                    <option
                                        value="<?= $one["id"] ?>"
                                        <?= $comment["posts_id"] == $one["id"] ? "selected" : "" ?>>

                                        <?= htmlspecialchars($one["title"]) ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                        <div class="mb-4">

                            <label class="form-label">
                                Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                placeholder="Enter Name"
                                value="<?= htmlspecialchars($comment["name"]) ?>"
                                required>

                        </div>

                        <div class="mb-4">

                            <label class="form-label">
                                Comment
                            </label>

                            <textarea
                                name="comment"
                                class="form-control"
                                rows="5"
                                placeholder="Enter Comment"
                                required><?= htmlspecialchars($comment["comment"]) ?></textarea>

                        </div>

                        <button
                            type="submit"
                            name="update"
                            class="btn btn-primary">
                            Update Comment
                        </button>

                        <a
                            href="index.php"
                            class="btn btn-secondary">
                            Cancel
                        </a>

                    </form>

                </div>

            </div>

        </main>

    </div>

</div>

</body>

</html>