<?php
$title = 'Saving your registration...';
require('shared/header.php');
?>
<main>
    <?php
    // capture user data from the POST
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    // validation
    $ok = true;

    // check that username is not empty
    if (empty($username)) {
        echo '<p class="error">Username is required.</p>';
        $ok = false;
    }

    // check username formatting too
    if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
        echo '<p class="error">Email format is invalid.</p>';
        $ok = false;   
    }

    // check that password is not empty
    if (empty($password)) {
        echo '<p class="error">Password is required.</p>';
        $ok = false;
    }

    // check that the two passwords are the same
    if ($password != $confirm) {
        echo '<p class="error">Passwords must match.</p>';
        $ok = false;
    }

    // Apr 10 - Step 4
    // recaptcha v3 anti-spam validation - https://developers.google.com/recaptcha/docs/verify
    // setup the input params to call the Google API
    $apiUrl = 'https://www.google.com/recaptcha/api/siteverify';
    // add secret key from the recaptcha admin page
    $secret = '6LeoQHUlAAAAABj-FckKNJ9lSPH73XhYKNW9UrZM';
    $response = $_POST['g-recaptcha-response'];

    // Apr 10 - Step 5 DONE
    // call the API and parse the JSON-formatted results
    $apiResponse = file_get_contents("$apiUrl?secret=$secret&response=$response");
    // converts json string into an array we can parse
    $decodedResponse = json_decode($apiResponse);
    if ($decodedResponse->success == false) {
        echo 'Are you human?';
        $ok = false;
    }

    // print($apiResponse); // for testing only
    // exit(); // for testing only

     if ($ok == true) {
        // connect
        require('shared/db.php');

        // duplicate check/check if user already exists
        $sql = "SELECT * FROM users WHERE username = :username";
        $cmd = $db->prepare($sql);
        $cmd->bindParam(':username', $username, PDO::PARAM_STR, 50);
        $cmd->execute();
        $user = $cmd->fetch();

        // only create a new user if the query for this username returns no data
        if (empty($user)) {
            // set up SQL insert
            $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";

            // set up and fill the parameter values for safety. We are going to be executing this SQL statement, but first we are going to provide some parameters
            $cmd = $db->prepare($sql);
            $cmd->bindParam(':username', $username, PDO::PARAM_STR, 50); // Parameters - email parameter, email variable, string that is 50 char

            // hash the password before binding it to the :password parameter
            $password = password_hash($password, PASSWORD_DEFAULT);
            $cmd->bindParam(':password', $password, PDO::PARAM_STR, 255); // What is the string we are converting, what algorithm we are using

            // execute the sql command
            $cmd->execute();

            // show confirmation
            echo 'Your registration was successful';
        }
        else {
            echo '<p class="error">User already exists.</p>';
        }

        // disconnect
        $db = null;
    }  
    ?>
</main>
<?php require('shared/footer.php'); ?>