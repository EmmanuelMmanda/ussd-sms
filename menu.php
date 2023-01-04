<?php
include_once("./util.php");
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
                    echo ('END Your pins do not match !');
                } else {
                    echo ('END You have succesfully registered as ' . $fullname . ' ');
                }

                break;
            default:
                break;
        }
    }
    public function sendmMoneyMenu($textArray)
    {

        $level = count($textArray);
        echo ("\n");

        switch ($level) {
            case '1':
                echo ("CON Enter receiver's phone number.");
                break;
            case '2':
                echo ('CON Enter the Amount');
                break;
            case '3':
                echo ('CON Enter your PIN');
                break;
            case '4':
                $r = "CON You are sending " . $textArray[2] . " to " . $textArray[1] . "\n";
                $r .= "1. Confirm \n";
                $r .= "2. Cancel \n";
                $r .= util::$GO_BACK . " Go back \n";
                $r .= util::$MAIN_MENU . " Main Menu";
                echo ($r);
                break;
            case '5':
                if ($textArray[4] == 1) {
                    # confirmation
                    echo ('END Your request is being proccessed');
                } elseif ($textArray[4] == 2) {
                    # cancelation
                    echo ('END Cancelled :: Thank you!');

                } elseif ($textArray[4] == 3) {
                    # Go back one step - to pin
                    echo ('END Your will go back to pin');


                } elseif ($textArray[4] == 4) {
                    # Go back to main menu
                    echo ('END You will be at main menu soon');
                }

                break;
            default:
                echo ('END Invalid entry');
                break;
        }
    }
    public function withdrawMoneymenu($textArray)
    {
        $level = count($textArray);

        switch ($level) {
            case '1':
                echo ("CON Enter Agents's Number");
                break;
            case '2':
                echo ('CON Enter the Amount');
                break;
            case '3':
                echo ('CON Enter your PIN');
                break;
            case '4':
                $r = "CON You are withrawing " . $textArray[2] . " from Agent " . $textArray[1] . "\n";
                $r .= "1. Confirm \n";
                $r .= "2. Cancel \n";
                $r .= util::$GO_BACK . " Go back \n";
                $r .= util::$MAIN_MENU . " Main Menu";
                echo ($r);
                break;
            case '5':
                if ($textArray[4] == 1) {
                    # confirmation
                    echo ('END Your withdraw request is being processed');
                } elseif ($textArray[4] == 2) {
                    # cancelation
                    echo ('END Cancelled :: Thank you !');

                } elseif ($textArray[4] == 3) {
                    # Go back one step - to pin
                    echo ('END Your will go back to pin');


                } elseif ($textArray[4] == 4) {
                    # Go back to main menu
                    echo ('END You will be at main menu soon');
                } else {
                    echo ('Invalid entry !');
                }
                break;

            default:
                echo ('Invalid entry, Please try again!');
                break;
        }
    }

    public function checkBalanceMenu($balance, $textArray)
    {
        $level = count($textArray);

        switch ($level) {
            case '1':
                echo ("CON Enter your PIN.");
                break;
            case '2':
                # checking balance
                $response = "END Your Current balance is: .$balance.\n";
                echo ($response);
                break;
            default:
                echo ('Invalid entry, Please try again!');
                break;
        }
    }

}
?>