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


//handling all text through middleware
$text = $menu->middleware($text, $sessionId, $user, $pdo);

if ($text == "" && !$isRegistered) {
    # initial and user not registered
    $menu->mainMenuUnregistered();

} else if ($text == "" && $isRegistered) {
    # initial and user is registered
    echo "CON " . $menu->mainMenuRegistered($username);

} else if ($isRegistered) {
    # sending money #withdrawing money #checking balance
    if ($textArray[0] == 1) {
        $menu->sendMoneyMenu($textArray,$phoneNumber,$pdo);

    } else if ($textArray[0] == 2) {
        $menu->withdrawMoneymenu($textArray);

    } else if ($textArray[0] == 3) {
        $menu->checkBalanceMenu($balance, $phoneNumber, $textArray, $pin, $pdo);

    } else {
        $menu->persistInvalidEntry($pdo, $user->readUserId($pdo), $sessionId, $textArray);
        echo "CON Invalid Option, Try again  \n" . $menu->mainMenuRegistered($username);
    }

    // Alternatively use swiitch-case
    // switch ($textArray[0]) {
    //     case '1':
    //         $menu->sendmMoneyMenu($textArray);
    //         break;
    //     case '2':
    //         $menu->withdrawMoneymenu($textArray);
    //         break;
    //     case '3':
    //         $menu->checkBalanceMenu($balance, $phoneNumber, $textArray, $pin, $pdo);
    //         break;
    //     default:
    //         $menu->persistInvalidEntry($pdo, $user->readUserId($pdo), $sessionId, $textArray);
    //         echo "CON Invalid Option, Try again  \n" . $menu->mainMenuRegistered($username);
    //         break;
    // }
} elseif (!$isRegistered) {
    switch ($textArray[0]) {
        case '1':
            $menu->registerMenu($textArray, $phoneNumber, $pdo);
            break;
        default:
            break;
    }
}

// echo "\n text at index " . $text;

?>