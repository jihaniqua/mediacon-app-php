<?php
// connect
require('../shared/db.php');

// get all posts
$sql = "SELECT * FROM posts ORDER BY dateCreated DESC";

// check for user filter
if (!empty($_GET['user'])) {
    $sql = "SELECT * FROM posts WHERE user = :user ORDER BY dateCreated DESC";
}

$cmd = $db->prepare($sql);
if (!empty($_GET['user'])) {
    $cmd->bindParam(':user', $_GET['user'], PDO::PARAM_STR, 50);
}
$cmd->execute();
$posts = $cmd->fetchAll(PDO::FETCH_ASSOC); // FETCH_ASSOC includes column names for our json

// convert the data to json format and output all of it
echo json_encode($posts);
$db = null;
?>