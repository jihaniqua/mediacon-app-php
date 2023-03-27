<?php
// authentication check: this page is now private
require('shared/auth.php');

$title = 'Create a new post';
require('shared/header.php');
?>
<main>
    <h1>Create a New Post</h1>
    <form action="save-post.php" method="post">
        <fieldset>
            <label for="body">Body:</label>
            <textarea name="body" id="body" maxlength="4000" required></textarea>
        </fieldset>
        <button class="btnOffset">Post</button>
    </form>
</main>
<?php require('shared/footer.php'); ?>