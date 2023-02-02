<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/app.css" rel="stylesheet" />
    <title>Posts</title>
</head>
<body>
    <h1>Posts</h1>
    <?php
    // connect to db
    $db = new PDO('mysql:host=172.31.22.43;dbname=Jihan200523101', 'Jihan200523101', 'ZjTmwnJCwo');

    // set up the SQL SELECT command
    // Query is using select because we're retrieving data instead of inserting where we were sending data to the database
    $sql = "SELECT * FROM posts";

    // execute the select query
    // command variable, prepare to run our query
    $cmd = $db->prepare($sql);
    // if we don't call execute, we've connected and set up a query but the query never happens
    $cmd->execute();

    // store the query results in an array. Use fetchAll for multiple records, fetch for 1.
    $posts = $cmd->fetchAll();

    // open table
    // echo '<table>';
    // echo '<thead><th>Body</th><th>User</th><th>Date</th>';
    //simplified
    echo '<table>
        <thead><th>Body</th><th>User</th><th>Date</th>';

    // display the post data in a loop. $posts = all the data, $post = current item in the loop
    foreach ($posts as $post) {
        echo '<tr>'; // create a new row
        echo '<td>' . $post['body'] . '</td>'; // create new column with data inside
        echo '<td>' . $post['user'] . '</td>';
        echo '<td>' . $post['dateCreated'] . '</td>';
        echo '</tr>';
    }

    // close table
    echo '</table>';

    // disconnect
    $db = null;
    ?>
</body>
</html>