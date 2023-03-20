<?php
    // capture from input from $_POST array
    $username = $_POST['username'];
    $password = $_POST['password'];

    // connect
    require('shared/db.php');
    
    // check if username exists
    $sql = "SELECT * FROM users WHERE username = :username";
    $cmd = $db->prepare($sql);
    $cmd->bindParam(':username', $username, PDO::PARAM_STR, 50);
    $cmd->execute();
    $user = $cmd->fetch();

    if (empty($user)) {
        $db = null; // to make sure no more code executes on this page
        header('location:login.php?valid=false'); // back to login page
        exit();
    }
    else {
        // check if hashed password exists
        if (password_verify($password, $user['password']) == false) {
            $db = null;
            header('location:login.php?valid=false');
            exit();
        }
        else {
            // if both credentials found, store the user identity in the $_SESSION object as a var
            // redirect to post feed
            // *** code dictation line go here ***
            session_start(); // means access the current session
            $_SESSION['user'] = $username; // could be any var name
            header('location:posts.php');
            $db = null;
        }
    }

    // extra challenge: add JS file to view password and password doesn't match
?>