<?php

ini_set('display_errors', 1);

//error handler function
function customError($errno, $errstr) {
  print "<b>Error:</b> [$errno] $errstr\n\n";
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
    $money = $_POST["amount"];
    $sub = $_POST["submission"];
    $captcha = $_POST["g-recaptcha-response"];
} else {
    print "Use POST to submit an entry.";
    die("1");
    // for debugging purposing only
    $name = $_GET["name"];
    $money = $_GET["amount"];
    $sub = $_GET["submission"];
    $captcha = $_GET["g-recaptcha-response"];
}

// filename format: fund-YYYYMMDD--HHMMSS-DEADBEEF (random hex to avoid time collision)
// random hex black magic WARNING: not random enough
$filename = "subs/fund-" . date("Ymd-His") . "-" . substr(md5(rand(0, 2147483647)), 0, 8);

// verify inputs
$inputOk = true;
if(!is_numeric($money)) {
    $inputOk = false;
} else {
    if((int)$money < 10 || (int)$money > 1000000) $inputOk = false;
}
if($name == "") $inputOk = false;
if(strlen($sub) < 20 || strlen($sub) > 10000) $inputOk = false;
if(!$inputOk){
    // input invalid
    // echo "$name $money $sub";
    die("2");
}

// verify captcha
$secretKey = "6LeAqGkUAAAAAMPZqWGTiziskDOvJrl1CDgfpGeR";
$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha);
$responseKeys = json_decode($response, true);
if(intval($responseKeys["success"]) !== 1) {
    // captcha not verified
    die("3");
}


// create new file
$file = fopen($filename, "w");
$txt = "Request IP: " . $_SERVER['REMOTE_ADDR'];
fwrite($file, $txt . "\n\n");
$txt = "Name: " . $name;
fwrite($file, $txt . "\n\n");
$txt = "Amount requested: NT$" . $money;
fwrite($file, $txt . "\n\n");
$txt = "Submission:\n\n" . $sub;
fwrite($file, $txt);
$txt = "\n";
fwrite($file, $txt);
fclose($file);

// Die with a success message
die("0");

?>
