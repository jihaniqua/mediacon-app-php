<?php
// authentication check: this page is now private
require('shared/auth.php');

$title = 'Create a new post';
require('shared/header.php');
?>
<main>
    <h1>Create a New Post</h1>
    <form action="save-post.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <label for="body">Body:</label>
            <textarea name="body" id="body" maxlength="4000" required></textarea>
        </fieldset>
        <!-- Apr 3 - Step 1: Add file input 
        Next step on save-post.php line 15 -->
        <fieldset>
            <label for="photo">Photo:</label>
            <input type="file" name="photo" accept=".png,.jpg" />
        </fieldset>
        <button class="btnOffset">Post</button>
    </form>
</main>
<?php require('shared/footer.php'); ?>