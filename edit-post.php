<?php
$title = 'Edit your post';
require('shared/header.php');
?>
<main>
    <?php 
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

    ?>
    <!-- step 2: edit title -->
    <h1>Post Details</h1>
    <!-- step 3: edit action page -->
    <!-- step 4: build "update-post.php" page -->
    <form action="update-post.php" method="post">
        <fieldset>
            <label for="body">Body:</label>
            <!-- step 7 -->
            <textarea name="body" id="body" maxlength="4000" required><?php echo $post['body']; ?></textarea>
        </fieldset>
        <fieldset>
            <label for="user">User:</label>
            <select name="user" id="user">
                <?php
                // step 5: take-off connection here and move on the top (line 34) for better efficiency

                // use SELECT to fetch the users
                $sql = "SELECT * FROM users";

                // run the Query
                $cmd = $db->prepare($sql);
                $cmd->execute();
                $users = $cmd->fetchAll();

                // loop through the user data to create a list item for each
                foreach ($users as $user) {
                    // step 8: select user that made the current post
                    if ($post['user'] == $user['email']) {
                        echo '<option selected>' . $user['email'] . '</option>';
                    }
                    else {
                        echo '<option>' . $user['email'] . '</option>';
                    }
                }

                // disconnect
                $db = null;

                ?>
            </select>
        </fieldset>
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