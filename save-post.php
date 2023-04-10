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
        // Apr 3 - Step 2: Add var
        $photo = $_FILES['photo'];
        
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

        // Apr 3 - Step 3: Add add validation
        // if a photo was uploaded, validate & save it 
        if (!empty($photo['name'])) {
            $tmp_name = $photo['tmp_name'];

            // ensure file is jpg or png
            $type = mime_content_type($tmp_name);
            if ($type != 'image/png' && $type != 'image/jpeg') {
                echo 'Please upload a .png or .jpg';
                $ok = false;
            }

            // create a unique name and save the photo
            $name = session_id() . '-' . $photo['name'];
            move_uploaded_file($tmp_name, 'img/' . $name);
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

            // Apr 3 - Step 4: edit, test by trying to put a file with a wrong filetype
            // set up an SQL INSERT "INSERT INTO tableName (colName1, colName2 , colName3) VALUES (colon-prefix-value parameter as placeholders)
            $sql = "INSERT INTO posts (body, user, dateCreated, photo) VALUES 
                (:body, :user, :dateCreated, :photo)";

            // map each input to the corresponding db column
            $cmd = $db->prepare($sql);
            $cmd->bindParam(':body', $body, PDO::PARAM_STR, 4000);
            $cmd->bindParam(':user', $user, PDO::PARAM_STR, 100);
            $cmd->bindParam(':dateCreated', $dateCreated, PDO::PARAM_STR);
            /* Apr 3 - Step 5: bind placeholder to unique name
            Next step on post.php line 50 */
            $cmd->bindParam(':photo', $name, PDO::PARAM_STR, 100);

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