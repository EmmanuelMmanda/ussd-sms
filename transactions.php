<?php

class Transaction
{
    private $amount;
    private $ttype;

    public function __construct($ttype, $amount)
    {
        $this->ttype = $ttype;
        $this->amount = $amount;
    }

    public function sendMoney($pdo, $uid, $ruid, $SenderBalance, $ReceiverBalance)
    {
        $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
        try {
            $pdo->beginTransaction();
            $newSenderBalance = $SenderBalance - ($this->amount + util::$VAT);
            $newReceiverBalance = $ReceiverBalance + $this->amount;
            
            //prepare statements
            $transaction_stmt = $pdo->prepare("INSERT INTO transactions (uid,ruid,ttype,tamount) VALUES (?,?,?,?)");
            $transaction_stmt->execute([$uid, $ruid, $this->ttype, $this->amount]);
            $users_stmt = $pdo->prepare("UPDATE users SET balance=? WHERE uid=?");

            $users_stmt->execute([$newSenderBalance, $uid]);
            $users_stmt->execute([$newReceiverBalance, $ruid]);
            $pdo->commit();
            return true;

        } catch (Exception $e) {
            $pdo->rollBack();
            return "Something went Wrong";
        }

    }

}
?>