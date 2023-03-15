<?php
$title = 'Saving your registration...';
require('shared/header.php');
?>
<main>
    <?php
    // capture user data from the POST
    $email = $_POST['email'];

    // validation
    $ok = true;

    if (empty($email)) {
        echo '<p class="error">Email is required.</p>';
        $ok = false;
    }

    // check email formatting too
    if  (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<p class="error">Email format is invalid.</p>';
        $ok = false;
    }

    if ($ok == true) {
        // connect
        require('shared/db.php');

        // set up SQL insert
        $sql = "INSERT INTO users (email) VALUES (:email)";

        // set up and fill the parameter values for safety. We are going to be executing this SQL statement, but first we are going to provide some parameters
        $cmd = $db->prepare($sql);
        $cmd->bindParam(':email', $email, PDO::PARAM_STR, 100); // Parameters - email parameter, email variable, string that is 100 char

        // execute the SQL command
        $cmd->execute();

        // disconnect
        $db = null;

        // show confirmation
        echo 'Your registration was successful';
    }  
    ?>
</main>
<?php require('shared/footer.php'); ?>