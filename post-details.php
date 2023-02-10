<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Post</title>
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
            //date_default_timezone_set("America/Toronto");
            //$d = date('y-m-d h:i');
            //echo $d; ?>
            <h1>Create a New Post</h1>
            <form action="save-post.php" method="post">
                <fieldset>
                    <label for="body">Body:</label>
                    <textarea name="body" id="body" maxlength="4000" required></textarea>
                </fieldset>
                <fieldset>
                    <label for="user">User:</label>
                    <select name="user" id="user">
                        <?php
                        // connect
                        $db = new PDO('mysql:host=172.31.22.43;dbname=Jihan200523101', 'Jihan200523101', 'ZjTmwnJCwo');

                        // use SELECT to fetch the users
                        $sql = "SELECT * FROM users";

                        // run the Query
                        $cmd = $db->prepare($sql);
                        $cmd->execute();
                        $users = $cmd->fetchAll();

                        // loop through the user data to create a list item for each
                        foreach ($users as $user) {
                            echo '<option>' . $user['email'] . '</option>';
                        }

                        // disconnect
                        $db = null;

                        ?>
                    </select>
                </fieldset>
                <button class="btnOffset">Post</button>
            </form>
        </main>
    </body>
</html>