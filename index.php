<?php
// Read the variables sent via POST from our API
$sessionId = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text = $_POST["text"];

$isNotRegistered = false;
$username = "Emmanuel Mmanda";
$balance = "100,000 Tsh";

if ($text == "" && $isNotRegistered) {
    # initial and user not registered
    $response = "CON Welcome to VICOBA, Choose 1 to Register: \n";
    $response .= "1. Register";

} else if ($text == "" && !$isNotRegistered) {
    # initial and user is registered
    $response = "CON Welcome to VICOBA,.$username.  \n";
    $response .= "1. Send Money \n";
    $response .= "2. Withdraw Money \n";
    $response .= "3. Check Balance \n";
} else if ($text == "1" && !$isNotRegistered) {
    # sending money
    $response = "END We will allow send Money Shorlty \n";
} else if ($text == "2"  && !$isNotRegistered) {
    #withdrawing money
    $response = "END We will allow withdraw Money Shorlty \n";

} else if ($text == "3"  && !$isNotRegistered) {
    #checking balance
    $response = "END Your Current balance is: .$balance.\n";
}
//echo back the response to ApI
header('Content-type: plain/text');
echo $response;
?>