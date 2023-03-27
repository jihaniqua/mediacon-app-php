<?php
require('shared/auth.php');
try {
    // no html required as this is an invisible page
    // it deletes the post then redirects them to the updated feed

    // identify which post to remove. use $_GET to read url param called "postId"
    $postId = $_GET['postId'];

    // connect to db
    require('shared/db.php');

   // access control check: does the current user own this post?
   $sql = "SELECT * FROM posts WHERE postId = :postId";
   $cmd = $db->prepare($sql);

   // populate the SQL with the selected postId
   $cmd->bindParam(':postId', $postId, PDO::PARAM_INT);

   // execute query in the database
   $cmd->execute();
   $post = $cmd->fetch();

   // ownership check
   if ($post['user'] != $_SESSION['user']) {
       $db = null;
       header('location:403.php'); // forbidden
       exit();
   }

    // create SQL delete statement. make sure to always have WHERE clause
    $sql = "DELETE FROM posts WHERE postId = :postId";
    $cmd = $db->prepare($sql);

    // populate the SQL delete with the selected postId
    $cmd->bindParam(':postId', $postId, PDO::PARAM_INT);

    // execute delete in the database
    $cmd->execute();

    // disconnect
    $db = null;

    // redirect to updated feed
    // echo 'Deleted';
    header('location:posts.php');
}
catch (Exception $error) {
    header('location:error.php');
    exit();
}
?>