<?php
// starts a php session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//import the vendor files for email sending
include_once("../ClassAutoLoad.php");
// spl_autoload_register('ClassAutoLoad', true, true);
require '../vendor/autoload.php';

require_once '../sql/dbconn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['signup']) ){
// extrat user details
$names = $_POST["full-name"];
$email_address = $_POST["email"];
$password = $_POST["password"];
$phone_number = $_POST["phone"]; /// add this
$conf_password = $_POST["confirm-password"];
$token = md5(time());
$token_expire = date("Y-m-d H:i:s", strtotime("+ 2hours"));
$email_template = "
    <h2> Hi {{full-name}}, you have registered with BidUnity!</h2>
    <h3>verify your email address to login with the link given below. 
     Thank you for joining our community!
    <p> We value diversity! </p>
    <br>
    <a href='http://localhost/group_project/processes/verify_email.php?token=$token''>click here</a>
    <br> 
    Regards <br>
    BidUnity
    </h3>";

$pass_hash = password_hash($conf_password, PASSWORD_DEFAULT);




//check if email exists
$check_email_query = "SELECT email_address FROM user WHERE email_address ='$email_address' LIMIT 1";
$check_email_query_RUN = mysqli_query($conn, $check_email_query);


if (mysqli_num_rows($check_email_query_RUN) > 0) {
    $_SESSION['status'] = "email already exists";
    header("location:../signup.php");
} else {
    $query = "INSERT INTO user (username,email_address,password,token,token_expire) value ('$names','$email_address','$pass_hash','$token','$token_expire')";
    $query_run = mysqli_query($conn, $query);

    $verify_query = "SELECT * FROM user where email_address = '$email_address' LIMIT 1";
    $verify_query_run = mysqli_query($conn, $verify_query);

    if (mysqli_num_rows($verify_query_run) > 0) {
        $replacements = mysqli_fetch_assoc($verify_query_run);
        $message = $OBJ_processes->bind_to_template($replacements, $email_template);
    }

    if ($verify_query_run) {
        $message = $OBJ_processes->bind_to_template($replacements, $email_template);
        $OBJ_processes->sendemail_verify($names, $message);
        $_SESSION['status'] = "registration successfull. now verify your email";
        // header("location:../signup.php");

    } else {

        $_SESSION['status'] = "Registration Failed";
        header("location:../signup.php");

    }
}

}
?>