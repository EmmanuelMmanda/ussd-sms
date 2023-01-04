<?php
include_once('./menu.php');
// Read the variables sent via POST from our API
$sessionId = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text = $_POST["text"];

$isRegistered = true;
$username = "Mr. Emmanuel Mmanda";
$balance = "100,000 Tsh";

$menu = new Menu($sessionId, $text);

$textArray = explode("*", $text);

if ($text == "" && !$isRegistered) {
    # initial and user not registered
    $menu->mainMenuUnregisterd();

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
            $menu->checkBalanceMenu($balance,$textArray);
            break;
        default:
            echo ('END You have selected an invalid Option, Please try again. ');
            break;
    }
} elseif (!$isRegistered) {
    # code...
    switch ($textArray[0]) {
        case '1':
            $menu->registerMenu($textArray);
            break;

        default:
            break;
    }
}

?>