<?php
$title = 'Register';
require('shared/header.php');
?>
<main>
    <h1>Register</h1>
    <form action="save-registration.php" method="post">
        <fieldset>
            <label for="email">Email:</label>
            <input type="email" name="email" required/>
        </fieldset>
        <button>Register</button>
    </form>
</main>
<?php require('shared/footer.php'); ?>