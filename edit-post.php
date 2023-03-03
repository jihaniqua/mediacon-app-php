<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- step 1: edit title -->
        <title>Edit Post</title>
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
            // step 6
            // get the postId from the url parameter using $_GET
            $postId = $_GET['postId'];
            if (empty($postId)) {
                header('location:404.php');
                exit();
            }


            // connect
            $db = new PDO('mysql:host=172.31.22.43;dbname=Jihan200523101', 'Jihan200523101', 'ZjTmwnJCwo');
            
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
                    <textarea name="body" id="body" maxlength="4000" required>
                        <?php
                        echo $post['body'];
                        ?>
                    </textarea>
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
    </body>
</html>