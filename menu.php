<?php

include_once("./util.php");
include_once("./user.php");
include_once("./db.php");
include_once("./transactions.php");

class Menu
{
    protected $text;
    protected $sessionID;

    function __construct()
    {
    }

    public function mainMenuRegistered($u)
    {
        $response = "Welcome to VICOBA $u \n";
        $response .= "1. Send Money \n";
        $response .= "2. Withdraw Money \n";
        $response .= "3. Check Balance \n";

        return ($response);
    }
    public function mainMenuUnregistered()
    {
        $response = "CON You need to be registered to  BROTHERHOOD VIKOBA: \n";
        $response .= "1. Register";
        echo ($response);
    }
    public function registerMenu($textArray, $phoneNumber, $pdo)
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
                    try {
                        $user = new User($phoneNumber);
                        $user->setName($fullname);
                        $user->setPin($pin);
                        $user->setBalance(util::$BALANCE);

                        $user->registerNewUser($pdo);
                        echo ('END You have succesfully registered as ' . $fullname . ' ');

                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                }
                break;
            default:
                break;
        }
    }
    public function sendMoneyMenu($textArray, $phoneNumber, $pdo)
    {

        $level = count($textArray);
        if ($level == 1) {
            echo ("CON Enter receiver's phone number.");
        } elseif ($level == 2) {
            echo ('CON Enter the Amount');
        } elseif ($level == 3) {
            echo ('CON Enter your PIN');
        } elseif ($level == 4) {
            $phone_Input = $this->addCountryCodeToPhone($textArray[1]);
            $inputedPin = $textArray[3];
            $user = new User($phoneNumber);
            $user->setPin($inputedPin);
            $pin = $user->getPin();
            if ($user->verifyPin($pdo) == false) {
                echo "END You have entered incorrect PIN. Please try again.";
                return;
            }

            $receiver_phone_number = $this->validatePhoneNumber($phone_Input);

            if ($receiver_phone_number == 1) {
                //getting receiver name 
                $receiver = new User($phone_Input);
                $receiver_Name = $receiver->readUserName($pdo);

                $r = "CON You are sending Tsh " . $textArray[2] . " to " . $receiver_Name . " - " .$phone_Input. " with a fee of 50 Tsh \n";
                $r .= "1. Confirm \n";
                $r .= "2. Cancel \n";
                $r .= util::$GO_BACK . " Go back \n";
                $r .= util::$MAIN_MENU . " Main Menu";
                echo ($r);

            } else {
                echo "\n  END Invalid Phone-Number format. Correct format is 07xxx";
            }

        } elseif ($level == 5) {
            if ($textArray[4] == 1) {
                # confirmation
                //getting sender info
                $user = new User($phoneNumber);
                $uid = $user->readUserId($pdo);
                $senderBalance = $user->getBalance();

                //getting receiver user info.
                $receiver = new User($this->addCountryCodeToPhone($textArray[1]));
                $ruid = $receiver->readUserId($pdo);
                $receiver_Balance = $receiver->getBalance();

                //managing transaction
                $ttype = "send_money";
                $amount = $textArray[2];
                $txn = new Transaction($ttype, $amount);

                $result = $txn->sendMoney($pdo, $uid, $ruid, $senderBalance, $receiver_Balance);

                if ($result == true) {
                    echo ('END Your request is being proccessed.You will be notified shortly via SMS');
                    //send an sms to user and receiver
                    
                } else {
                    echo "CON" . $result;
                }

            } elseif ($textArray[4] == 2) {
                # cancelation
                echo ('END Cancelled :: Thank you!');
            }
        } else {
            echo "END Invalid input";
        }

        // switch ($level) {
        //     case '1':
        //         echo ("CON Enter receiver's phone number.");
        //         break;
        //     case '2':
        //         echo ('CON Enter the Amount');
        //         break;
        //     case '3':
        //         echo ('CON Enter your PIN');
        //         break;
        //     case '4':
        //         $r = "CON You are sending " . $textArray[2] . " to " . $textArray[1] . "\n";
        //         $r .= "1. Confirm \n";
        //         $r .= "2. Cancel \n";
        //         $r .= util::$GO_BACK . " Go back \n";
        //         $r .= util::$MAIN_MENU . " Main Menu";
        //         echo ($r);
        //         break;
        //     case '5':
        //         if ($textArray[4] == 1) {
        //             # confirmation
        //             echo ('END Your request is being proccessed');
        //         } elseif ($textArray[4] == 2) {
        //             # cancelation
        //             echo ('END Cancelled :: Thank you!');

        //         } elseif ($textArray[4] == 3) {
        //             # Go back one step - to pin
        //             echo ('END Your will go back to pin');


        //         } elseif ($textArray[4] == 4) {
        //             # Go back to main menu
        //             echo ('END You will be at main menu soon');
        //         }

        //         break;
        //     default:
        //         echo ('END Invalid entry');
        //         break;
        // }
    }
    public function withdrawMoneymenu($textArray)
    {

        $level = count($textArray);
        if ($level == 1) {
            echo ("CON Enter Agents's Number");

        } elseif ($level == 2) {
            echo ('CON Enter the Amount');

        } elseif ($level == 3) {
            echo ('CON Enter your PIN');

        } elseif ($level == 4) {
            $r = "CON You are withrawing " . $textArray[2] . " from Agent " . $textArray[1] . "\n";
            $r .= "1. Confirm \n";
            $r .= "2. Cancel \n";
            $r .= util::$GO_BACK . " Go back \n";
            $r .= util::$MAIN_MENU . " Main Menu";
            echo ($r);
        } elseif ($level == 5) {
            if ($textArray[4] == 1) {
                # confirmation
                echo ('END Your withdraw request is being processed');
            } elseif ($textArray[4] == 2) {
                # cancelation
                echo ('END Cancelled :: Thank you !');
            }
        } else {
            echo ('Invalid entry, Please try again!');

        }

        // switch ($level) {
        //     case '1':
        //         echo ("CON Enter Agents's Number");
        //         break;
        //     case '2':
        //         echo ('CON Enter the Amount');
        //         break;
        //     case '3':
        //         echo ('CON Enter your PIN');
        //         break;
        //     case '4':
        //         $r = "CON You are withrawing " . $textArray[2] . " from Agent " . $textArray[1] . "\n";
        //         $r .= "1. Confirm \n";
        //         $r .= "2. Cancel \n";
        //         $r .= util::$GO_BACK . " Go back \n";
        //         $r .= util::$MAIN_MENU . " Main Menu";
        //         echo ($r);
        //         break;
        //     case '5':
        //         if ($textArray[4] == 1) {
        //             # confirmation
        //             echo ('END Your withdraw request is being processed');
        //         } elseif ($textArray[4] == 2) {
        //             # cancelation
        //             echo ('END Cancelled :: Thank you !');

        //         }
        //     //  elseif ($textArray[4] == 3) {
        //     //     # Go back one step - to pin
        //     //     echo ('END Your will go back to pin');


        //     // } elseif ($textArray[4] == 4) {
        //     //     # Go back to main menu
        //     //     echo ('END You will be at main menu soon');
        //     // } else {
        //     //     echo ('Invalid entry !');
        //     // }

        //     default:
        //         echo ('Invalid entry, Please try again!');
        //         break;
        // }
    }

    public function checkBalanceMenu($balance, $phoneNumber, $textArray, $pin, $pdo)
    {
        $level = count($textArray);

        switch ($level) {
            case '1':
                echo ("CON Enter your PIN.\n  ");
                break;
            case '2':
                # checking balance
                try {
                    $user = new User($phoneNumber);
                    $user->setPin($textArray[1]);

                    if ($user->verifyPin($pdo) == true) {
                        $response = "\n END Your Current balance is: " . $balance . "\n";
                    } else {
                        $response = "\n END Your have entered an incorrect pin";
                    }
                } catch (PDOException $e) {
                    $response = "END" . $e->getMessage();
                }
                echo ($response);
                break;
            default:
                echo ('Invalid entry, Please try again!');
                break;
        }
    }

    public function middleware($text, $sessionID, $user, $pdo)
    {
        return $this->invalidEntry($this->goBack($this->goToMainMenu($text)), $sessionID, $user, $pdo);
    }
    public function goBack($text)
    {
        //1*2*3*98 => 1*2
        $explodedText = explode("*", $text);
        while (array_search(util::$GO_BACK, $explodedText) != false) {
            $firstIndex = array_search(util::$GO_BACK, $explodedText);
            array_splice($explodedText, $firstIndex - 1, 2);
        }
        return join("*", $explodedText);
    }
    public function goToMainMenu($text)
    {
        $explodedText = explode("*", $text);
        while (array_search(util::$MAIN_MENU, $explodedText) != false) {
            $firstIndex = array_search(util::$MAIN_MENU, $explodedText);
            $explodedText = array_slice($explodedText, $firstIndex + 1);
        }
        return join("*", $explodedText);
    }

    public function persistInvalidEntry($pdo, $userId, $sessionID, $sessionLevel)
    {
        $sLevel = count($sessionLevel) - 1;
        $query = "INSERT INTO ussdsessions (sid,sLevel,userId) VALUES (?,?,?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$sessionID, $sLevel, $userId]);
        $stmt = null;
    }

    public function invalidEntry($text, $sessionID, $user, $pdo)
    {
        $stmt = $pdo->prepare("SELECT sLevel FROM ussdsessions WHERE userId=? AND sid=?");
        $stmt->execute([$user->readUserId($pdo), $sessionID]);
        $results = $stmt->fetchAll();

        if (count($results) == 0) {
            return $text;
        }

        $strArray = explode("*", $text);

        foreach ($results as $value) {
            unset($strArray[$value['sLevel']]);
        }

        $textArray = array_values($strArray);

        return join("*", $textArray);
    }

    public function addCountryCodeToPhone($phone)
    {
        return $phone_number = util::$COUNTRY_CODE . substr($phone, 1);
    }
    public function validatePhoneNumber($phone)
    {
        if (preg_match(util::$phone_regex, $phone) == 1) {
            return true;
        } else {
            return false;
        }
    }
}
?>