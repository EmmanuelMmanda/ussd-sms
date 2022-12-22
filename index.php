<?php
// Read the variables sent via POST from our API
$sessionId = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text = $_POST["text"];

$isNotRegistered = true;
$username = "Emmanuel Mmanda";
$balance = "100,000 Tsh";

if ($text == "" && $isNotRegistered) {
    # initial and user not registered
    $response = "CON Welcome to VICOBA, Choose 1 to Register: \n";
    $response .= "1. Register";

} elseif ($text == "" && !$isNotRegistered) {
    # initial and user is registered
    $response = "CON Welcome to VICOBA,.$username.  \n";
    $response .= "1. Send Money \n";
    $response .= "2. Withdraw Money \n";
    $response .= "3. Check Balance \n";
} elseif ($text == "1") {
    # sending money
    $response = "END We will allow send Money Shorlty \n";
} elseif ($text == "2") {
    #withdrawing money
    $response = "END We will allow withdraw Money Shorlty \n";

} elseif ($text == "3") {
    #checking balance

    $response = "END Your Current balance is: .$balance.\n";

}

?>