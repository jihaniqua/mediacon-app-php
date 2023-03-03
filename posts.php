<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    <!-- normalize to remove browser default styles -->
    <link rel="stylesheet" href="css/normalize.css" />
    <!-- our custom css -->
    <link rel="stylesheet" href="css/app.css" />
    <!-- our custom js -->
    <script src="js/scripts.js" defer></script>
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
        <h1>Posts</h1>
        <a href="post-details.php">Add a New Post</a>
        <?php
        // connect to db
        $db = new PDO('mysql:host=172.31.22.43;dbname=Jihan200523101', 'Jihan200523101', 'ZjTmwnJCwo');
        // set up the SQL SELECT command
        $sql = "SELECT * FROM posts ORDER BY postId DESC";
        // execute the select query
        $cmd = $db->prepare($sql);
        $cmd->execute();
        // store the query results in an array. use fetchAll for multiple records, fetch for 1.
        $posts = $cmd->fetchAll();
        /*echo '<table>
        <thead><th>Body</th><th>User</th><th>Date</th></thead>';*/
        // display post data in a loop. $posts = all data, $post = the current item in the loop
        foreach ($posts as $post) {
            echo '<article>
            <h2>' . $post['user'] . '</h2>
            <p>' . $post['dateCreated'] . '</p>
            <p>' . $post['body'] . '</p>
            <a href="edit-post.php?postId=' . $post['postId'] . '">Edit</a>
            <a onclick="return confirmDelete();"
             href="delete-post.php?postId=' . $post['postId'] .'
            ">Delete</a>
            </article>';

            /*echo '<tr>
            <td>' . $post['body'] . '</td>
            <td>' . $post['user']. '</td>
            <td>' . $post['dateCreated']. '</td>
        </tr>';*/
        }
        // close table
        //echo '</table>';
        // disconnect
        $db = null;
        ?>
    </main>
</body>
</html>