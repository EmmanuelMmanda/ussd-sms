<?php
include_once('./menu.php');
// Read the variables sent via POST from our API
$sessionId = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text = $_POST["text"];

$isRegistered = false;
$username = "Emmanuel Mmanda";
$balance = "100,000 Tsh";

$menu = new Menu($sessionId,$text);

if ($text == "" && !$isRegistered) {
    # initial and user not registered
    $menu->mainMenuUnregisterd();

} else if ($text == "" && $isRegistered) {
    # initial and user is registered
    $menu->mainMenuRegistered($username);

} else if ($text == "1" && $isRegistered) {
    # sending money
    $menu->sendmMoneyMenu();
} else if ($text == "2" && $isRegistered) {
    #withdrawing money
    $menu->withdrawMoneymenu();

} else if ($text == "3" && $isRegistered) {
    #checking balance
    $menu->checkBalanceMenu($balance);
} else {
    # code...
}

?>