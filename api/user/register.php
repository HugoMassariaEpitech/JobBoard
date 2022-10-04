<?php
include_once "../config/database.php";
include_once "../class/user.php";

$config = new Database();
$database = $config->getConnection();
$class = new User($database);
$user_name = $_POST["user_name"];
$user_password = $_POST["user_password"];
$user_email = $_POST["user_email"];
$user_phone = $_POST["user_phone"];
$user_birthdate = $_POST["user_birthdate"];
$user_civility = $_POST["user_civility"];
$user_firstname = $_POST["user_firstname"];
$user_confirmpass = $_POST["user_confirmpass"];
$currentdate = date('Y-m-d');

$pattern = "(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}";
$current = new DateTime($currentdate);
$entry = new DateTime($user_birthdate);


if (
    isset($user_email) && ($user_email != "") &&
    isset($user_name) && ($user_name != "") &&
    isset($user_password) && ($user_password != "") &&
    isset($user_phone) && ($user_phone != "") &&
    isset($user_birthdate) && ($user_birthdate != "") &&
    isset($user_civility) && ($user_civility != "") &&
    isset($user_firstname) && ($user_firstname != "")
) {


    if ($user_password != $user_confirmpass) {
        http_response_code(404);
    } else {
        $answer = false;
        if (!preg_match($pattern,$user_password)) {
            $answer = false;
            echo "false";
        } else {
            $answer = true;
            echo "true";
        }
        
        if ($answer) {
            if (filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                if (preg_match('/^[0-9]{10}+$/', $user_phone)) {
                    if ($user_phone[0] == '0') {
                        if ($current > $entry) {
                            $class->user_email = $user_email;
                            $class->user_name = $user_name;
                            $class->user_password = $user_password;
                            $class->user_phone = $user_phone;
                            $class->user_birthdate = $user_birthdate;
                            $class->user_civility = $user_civility;
                            $class->user_firstname = $user_firstname;
                            http_response_code(200);
                            echo $class->registerUser();
                        }
                        else {
                            echo "date trop grande";
                        }
                    }else{
                        echo "num pas commence par 0";
                    }
                }else{
                    echo "pas num";
                }
            }else{
                echo "pas mail";
            }
        }else{
            echo "test mdp";
        }
    }
}
