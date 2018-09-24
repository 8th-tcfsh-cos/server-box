<?php

// Clean up all the input values(Prevent XSS, etc.)
foreach($_POST as $key => $value) {
    $_POST[$key] = stripslashes(trim($_POST[$key]));
    $_POST[$key] = htmlspecialchars(strip_tags($_POST[$key]));
}

if (!file_exists('path/to/directory')) {
    mkdir('path/to/directory', 0777, true);
}

// Assign the input values to variables
$name = $_POST["name"];
$email = $_POST["email"];
$message = $_POST["message"];

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// verify captcha
$secretKey = "6LeAqGkUAAAAAMPZqWGTiziskDOvJrl1CDgfpGeR";
$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha);
$responseKeys = json_decode($response, true);
if(intval($responseKeys["success"]) !== 1) {
    // captcha not verified
    echo '<h2>You are spammer ! Get the @$%K out</h2>';
} else {
    //
    echo '<h2>Thanks for posting comment.</h2>';
}

// Die with a success message
die("<span class='success'>Success! Your message has been sent.</span>");


// A function that checks to see if
// an email is valid
function validEmail($email) { return true; }



?>
