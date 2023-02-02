<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saving your registration...</title>
    <link href="css/app.css" rel="stylesheet" />
</head>
<body>
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
        $db = new PDO('mysql:host=172.31.22.43;dbname=Jihan200523101', 'Jihan200523101', 'ZjTmwnJCwo');

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
</body>
</html>