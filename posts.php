<?php
$title = 'Post'; // set page title BEFORE linking header as header expects the variable
require('shared/header.php');
?>
<main>
    <h1>Posts</h1>
    <?php
    if (!empty($_SESSION['user'])) {
        echo '<a href="post-details.php">Add a New Post</a>';
    }
    try {
        // connect to db
        require('shared/db.php');

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
            <p>' . $post['body'] . '</p>';

            // access check:
            // 1 - is user logged in?
            // 2 - does user own this post?
            if (!empty($_SESSION['user'])) {
                if ($post['user'] == $_SESSION['user']) {
                echo '<a href="edit-post.php?postId=' . $post['postId'] . '">Edit</a>
                <a onclick="return confirmDelete();"
                    href="delete-post.php?postId=' . $post['postId'] .'
                ">Delete</a>';
                }
            }

            echo '</article>';

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
    }
    catch (Exception $error) {
        header('location:error.php');
        exit();
    }
    ?>
</main>
<?php require('shared/footer.php'); ?>