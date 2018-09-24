<?php

ini_set('display_errors', 1);

//error handler function
function customError($errno, $errstr) {
  echo "<b>Error:</b> [$errno] $errstr\n\n";
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
$name = $_POST["name"];
$money = $_POST["amount"];
$sub = $_POST["submission"];
$captcha = $_POST["g-recaptcha-response"];

// filename format: fund-HHMMSSA-DEADBEEF (random hex to avoid time collision)
// random hex black magic WARNING: not random enough
$filename = "subs/fund-" . date("hisa") . "-" . substr(md5(rand(0, 2147483647)), 0, 8);

// verify captcha
$secretKey = "6LeAqGkUAAAAAMPZqWGTiziskDOvJrl1CDgfpGeR";
$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha);
$responseKeys = json_decode($response, true);
if(intval($responseKeys["success"]) !== 1) {
    // captcha not verified
    die("captcha not verified");
}

// create new file
$file = fopen($filename, "w");
$txt = "Name: " . $name;
fwrite($file, $txt . "\n\n");
$txt = "Amount requested: NT$" . $money;
fwrite($file, $txt . "\n\n");
$txt = "Submission:\n\n" . $sub;
fwrite($file, $txt);
fclose($file);

// Die with a success message
die("1");

?>
