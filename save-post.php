<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saving your post...</title>
    <!-- normalize to remove browser default styles -->
    <link rel="stylesheet" href="css/normalize.css" />
    <!-- our custom css -->
    <link rel="stylesheet" href="css/app.css" />
</head>
<body>
    <header>
        <h1>
            <a href="#">
                MediaCon
            </a>
        </h1>
        <nav>
            <ul>
                <li><a href="posts.php">Posts</a></li>
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php
        // capture the form body input using the $_POST array & store in a var
        $body = $_POST['body'];
        $user = $_POST['user'];
        
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
        ?>
    </main>
</body>
</html>