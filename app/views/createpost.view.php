<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Post</title>
    <link rel="stylesheet" href="<?php echo ROOT ?>/assets/css/newpost.css">

</head>

<body>
    <section class="container">
        <form action="" class="newpost" method="post" enctype="multipart/form-data">
            <h2>Create a new post</h2>
            <label for="post-desc">Enter Post Description : </label>
            <textarea name="post-desc" id="post-desc" cols="30" rows="10" placeholder=""></textarea>
            <div>
                <label for="uploadImage">Attach an image : </label>
                <input type="file" name="uploadImage" id="uploadImage">
            </div>
            <input type="submit" value="POST" name='submit'>
            <a href="/public/welcome">Home</a>
        </form>
    </section>
</body>

</html>