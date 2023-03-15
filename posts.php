<?php
$title = 'Post'; // set page title BEFORE linking header as header expects the variable
require('shared/header.php');
?>
<main>
    <h1>Posts</h1>
    <a href="post-details.php">Add a New Post</a>
    <?php
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
<?php require('shared/footer.php'); ?>