<?php
require('shared/auth.php');

$title = 'Updating your post...';
require('shared/header.php');
?>
<main>
    <?php
    // capture the form body input using the $_POST array & store in a var
    $body = $_POST['body'];
    $user = $_SESSION['user']; // $_POST['user']
    $postId = $_POST['postId']; // hidden input w/PK
    
    // calculate the date and time with php
    date_default_timezone_set("America/Toronto");
    $dateCreated = date("y-m-d h:i");
    // echo $dateCreated;
    // echo $body;

    // lesson 4 - add validation before saving. Check 1 at a time for descriptive errors.
    $ok = true; // start with no validation errors

    if (empty($body)) {
        echo '<p class="error">Post body is required.</p>';
        $ok = false; // error happened - bad data
    }
    if (empty($user)) {
        echo '<p class="error">User is required.</p>';
        $ok = false; // error happened - bad data
    }

    // only save to db if $ok has never changed to false
    if ($ok == true) {
        // connect to the db
        require('shared/db.php');
        /* if ($db) {
            echo 'Connected';
        }
        else {
            echo 'Connection Failed';
        } */

        // step 2: update table. set up an SQL UPDATE. We MUST HAVE A WHERE CLAUSE
        $sql = "UPDATE posts SET body = :body, user = :user, dateCreated = :dateCreated WHERE postId = :postId";

        // map each input to the corresponding db column
        $cmd = $db->prepare($sql);
        $cmd->bindParam(':body', $body, PDO::PARAM_STR, 4000);
        $cmd->bindParam(':user', $user, PDO::PARAM_STR, 100);
        $cmd->bindParam(':dateCreated', $dateCreated, PDO::PARAM_STR);
        $cmd->bindParam(':postId', $postId, PDO::PARAM_INT);

        // execute the insert
        $cmd->execute();

        // disconnect
        $db = null;

        // show the user a message
        echo '<h1>Post updated</h1>
            <p><a href="posts.php">See the updated feed</a></p>';
    }
    ?>
</main>
<?php require('shared/footer.php'); ?>