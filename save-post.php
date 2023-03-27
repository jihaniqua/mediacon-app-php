<?php
// authentication check
require('shared/auth.php');

$title = 'Saving your post...';
require('shared/header.php');
?>
<main>
    <?php
    try {
        // capture the form body input using the $_POST array & store in a var
        $body = $_POST['body'];
        $user = $_SESSION['user'];// $_POST['user'];
        
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

            // set up an SQL INSERT "INSERT INTO tableName (colName1, colName2 , colName3) VALUES (colon-prefix-value parameter as placeholders)
            $sql = "INSERT INTO posts (body, user, dateCreated) VALUES (:body, :user, :dateCreated)";

            // map each input to the corresponding db column
            $cmd = $db->prepare($sql);
            $cmd->bindParam(':body', $body, PDO::PARAM_STR, 4000);
            $cmd->bindParam(':user', $user, PDO::PARAM_STR, 100);
            $cmd->bindParam(':dateCreated', $dateCreated, PDO::PARAM_STR);

            // execute the insert
            $cmd->execute();

            // disconnect
            $db = null;

            // show the user a message
            echo '<h1>Post saved</h1>
                <p><a href="posts.php">See the updated feed</a></p>';
        }
    }
    catch (Exception $error) {
        header('location:error.php');
        exit();
    }
    ?>
</main>
<?php require('shared/footer.php'); ?>