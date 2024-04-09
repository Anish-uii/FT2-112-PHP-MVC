<?php
$loadUserInfo = new App\Controllers\Updateprofile;
$userInfo = $loadUserInfo->getUser($_SESSION['username']);
$userFullName = explode(" ",$userInfo['NAME']);
$fname = $userFullName[0];
$lname = $userFullName[1];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="<?php echo ROOT ?>/assets/css/updateprofile.css">

</head>

<body>
    <section class="container">
        <main>
            <form action="" class="update-form" method="post" enctype="multipart/form-data">
                <h2>Update Profile </h2>
                <label for="name">Enter Name : </label>
                <div class="name-fields">
                    <input type="text" name="fname" id="fname" placeholder="First Name" value="<?php echo $fname; ?>" required>
                    <input type="text" name="lname" id="lname" placeholder="Last Name" value="<?php echo $lname; ?>" required>
                </div>
                <label for="profilephoto">Upload Proile Photo : </label>
                <input type="file" name="uploadImage" id="uploadImage">
                <label for="name">Enter Email : </label>
                <input type="email" name="email" id="email" placeholder="abc@example.com" value="<?php echo $userInfo['EMAIL'];?>" required>
                <label for="username">Enter Username : </label>
                <input type="text" name="username" id="username" placeholder="Name121" value="<?php echo $userInfo['USERNAME'];?>" required>
                <label for="bio">Enter Bio : </label>
                <textarea name="bio" id="bio" cols="30" rows="7" placeholder="Tell us something about you .. "></textarea>
                <input type="submit" value="Update" name="submit">
            </form>
        </main>
    </section>
</body>

</html>