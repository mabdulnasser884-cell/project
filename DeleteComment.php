     <?php
        include "./inc/config.php";


        $id = $_GET["id"];
        $del = $con->prepare("DELETE FROM `comments` WHERE id=?");
        $del->execute([$id]);
        // echo "done";
        header("location:IndexComment.php");
        ?>