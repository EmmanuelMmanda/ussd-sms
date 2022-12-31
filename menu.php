<?php
class Menu
{
    protected $text;
    protected $sessionID;

    function __construct($sessionID, $text)
    {
        $this->sessionID = $sessionID;
        $this->text = $text;
    }


    public function mainMenuRegistered($u)
    {
        $response = "CON Welcome to VICOBA $u \n";
        $response .= "1. Send Money \n";
        $response .= "2. Withdraw Money \n";
        $response .= "3. Check Balance \n";

        echo ($response);
    }
    public function mainMenuUnregisterd()
    {
        $response = "CON You need to be registered to  BROTHERHOOD VIKOBA: \n";
        $response .= "1. Register";
        echo ($response);
    }
    public function registerMenu($textArray)
    {
        $level = count($textArray);
        switch ($level) {
            case '1':
                echo ('CON Please enter your FullName ie. John Doe.');
                break;
            case '2':
                echo ('CON Enter your PIN');
                break;
            case '3':
                echo ('CON Confirm your PIN');
                break;
            case '4':
                $fullname = $textArray[1];
                $pin = $textArray[2];
                $confirmPin = $textArray[3];
                if ($pin != $confirmPin) {
                    echo ('END Your pins do not match ! \n');
                } elseif ($pin == $confirmPin and $fullname == '') {

                    echo ('END You have succesfully registered as ' . $fullname);
                }
                break;
            default:
                break;
        }
    }
    public function sendmMoneyMenu()
    {
        $response = "END We will allow send Money Shorlty \n";
        echo ($response);
    }
    public function withdrawMoneymenu()
    {
        $response = "END We will allow Withdraw Money Shorlty \n";
        echo ($response);
    }

    public function checkBalanceMenu($b)
    {
        $response = "END Your Current balance is: .$b.\n";
        echo ($response);
    }

}
?>