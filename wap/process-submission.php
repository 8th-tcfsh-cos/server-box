<?php

ini_set('display_errors', 1);

//error handler function
function customError($errno, $errstr) {
  // echo "<b>Error:</b> [$errno] $errstr\n\n";
  die("1");
}

//set error handler
set_error_handler("customError");

// Clean up all the input values(Prevent XSS, etc.)
foreach($_POST as $key => $value) {
    $_POST[$key] = stripslashes(trim($_POST[$key]));
    $_POST[$key] = htmlspecialchars(strip_tags($_POST[$key]));
}

// if (!file_exists('path/to/directory')) {
//     mkdir('path/to/directory', 0777, true);
// }

// Assign the input values to variables

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST["name"];
    $groups = $_POST["groups"];
    $sub = $_POST["submission"];
    $captcha = $_POST["g-recaptcha-response"];
} else {
    // echo "Use POST to submit an entry.";
    die("1");
    // for debugging purposing only
    $name = $_GET["name"];
    $groups = $_GET["groups"];
    $sub = $_GET["submission"];
    $captcha = $_GET["g-recaptcha-response"];
}

// filename format: fund-YYYYMMDD--HHMMSS-DEADBEEF (random hex to avoid time collision)
// random hex black magic WARNING: not random enough
$tmpname = "idea-" . date("Ymd-His") . "-" . substr(md5(rand(0, 2147483647)), 0, 8);
$filename = "subs/" . $tmpname;
$uploadfilename = "uploads/" . $tmpname;

// verify inputs
$inputOk = true;
if($name == "") $inputOk = false;
if(strlen($sub) < 20 || strlen($sub) > 10000) $inputOk = false;
if(!$inputOk){
    // input invalid
    // echo "$name $groups $sub";
    die("2");
}

$has_file = true;
if(!file_exists($_FILES['attachment']['tmp_name']) || !is_uploaded_file($_FILES['attachment']['tmp_name'])) {
    $has_file = false;
}

// verify captcha
$secretKey = "6LeAqGkUAAAAAMPZqWGTiziskDOvJrl1CDgfpGeR";
$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha);
$responseKeys = json_decode($response, true);
if(intval($responseKeys["success"]) !== 1) {
    // captcha not verified
    die("3");
}

$target_name = "";

if($has_file){
    $uploadOk = 1;

    $target_dir = $uploadfilename . '/';
    $target_file = $target_dir . basename($_FILES["attachment"]["name"]);

    // create a new path for new upload
    mkdir($target_dir, 0777, true);

    // Check file size (<= 20 MiB)
    if ($_FILES["attachment"]["size"] > 1048576 * 20) {
        // echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        // echo "Sorry, your file was not uploaded.";
        die("4");
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
            // echo "The file ". basename( $_FILES["attachment"]["name"]). " has been uploaded.";
        } else {
            // echo "Sorry, there was an error uploading your file.";
            die("4");
        }
    }
}

// create new file
$file = fopen($filename, "w");
$txt = "Request IP: " . $_SERVER['REMOTE_ADDR'];
fwrite($file, $txt . "\n\n");
$txt = "Name: " . $name;
fwrite($file, $txt . "\n\n");
$txt = "Recipient(s): " . $groups;
fwrite($file, $txt . "\n\n");
$txt = "Uploaded file: " . $has_file;
fwrite($file, $txt . "\n\n");
$txt = "Submission:\n\n" . $sub;
fwrite($file, $txt);
$txt = "\n";
fwrite($file, $txt);
fclose($file);

// Die with a success message
die("0");

?>
