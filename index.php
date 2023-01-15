<?php
include_once('./menu.php');
include_once('./user.php');
include_once('./db.php');

// Read the variables sent via POST from our API
$sessionId = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text = $_POST["text"];

// static $isRegistered = true;
// static $username = "Mr. Emmanuel Mmanda";
// static $balance = "100,000 Tsh";

$menu = new Menu();

//handling all text through middleware
$text = $menu->middleware($text);

$textArray = explode("*", $text);

//initating a database.
$db = new DB_Connector();
$pdo = $db->connectDB();

//initiating a user class.
$user = new User($phoneNumber);

//check user info.
$isRegistered = $user->usersIsRegistered($pdo);
$balance = $user->readBalance($pdo);
$username = $user->readUserName($pdo);
$pin = $user->readPin($pdo);


if ($text == "" && !$isRegistered) {
    # initial and user not registered
    $menu->mainMenuUnregistered();

} else if ($text == "" && $isRegistered) {
    # initial and user is registered
    $menu->mainMenuRegistered($username);

} else if ($isRegistered) {
    # sending money #withdrawing money #checking balance

    switch ($textArray[0]) {

        case '1':
            $menu->sendmMoneyMenu($textArray);
            break;
        case '2':
            $menu->withdrawMoneymenu($textArray);
            break;
        case '3':
            $menu->checkBalanceMenu($balance, $phoneNumber, $textArray, $pin, $pdo);
            break;
        default:
            echo ('END You have selected an invalid Option, Please try again.');

            break;
    }
} elseif (!$isRegistered) {
    # code...
    switch ($textArray[0]) {
        case '1':
            $menu->registerMenu($textArray, $phoneNumber, $pdo);
            break;
        default:
            break;
    }
}

?>