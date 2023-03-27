<?php
require('shared/auth.php');

$title = 'Edit your post';
require('shared/header.php');
?>
<main>
    <?php 
    try {
        // step 6
        // get the postId from the url parameter using $_GET
        $postId = $_GET['postId'];
        if (empty($postId)) {
            header('location:404.php');
            exit();
        }

        // connect
        require('shared/db.php');
        
        // set up $ run SQL query to fetch the selected post record
        $sql = "SELECT * FROM posts WHERE postId = :postId";
        $cmd = $db->prepare($sql);
        $cmd->bindParam(':postId', $postId, PDO::PARAM_INT);
        $cmd->execute();
        $post = $cmd->fetch();

        // check query returned a valid post record
        if (empty($post)) {
            header('location:404.php');
            exit();
        }

        // access control check: is logged user the owner of this post?
        if ($post['user'] != $_SESSION['user']) {
            header('location:403.php');  // 403 = HTTP Forbidden Error
            exit();
        }
    }
    catch (Exception $error) {
        header('location:error.php');
        exit();
    }

    ?>
    <!-- step 2: edit title -->
    <h1>Post Details</h1>
    <!-- step 3: edit action page -->
    <!-- step 4: build "update-post.php" page -->
    <form action="update-post.php" method="post">
        <fieldset>
            <label for="body">Body:</label>
            <textarea name="body" id="body" maxlength="4000" required><?php echo $post['body']; ?></textarea>
        </fieldset>
        <!-- Take off the user fieldset with step 5 -->
        <fieldset>
            <label>Date Created:</label>
            <?php
                echo $post['dateCreated'];
            ?>
        </fieldset>
        <button class="btnOffset">Update</button>
        <input name="postId" id="postId" value="<?php echo $postId; ?>" type="hidden" />
    </form>
</main>
<?php require('shared/footer.php'); ?>