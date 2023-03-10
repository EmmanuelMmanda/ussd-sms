<?php
include_once('./db.php');
class User
{

    protected $phone;
    protected $name;
    protected $pin;
    protected $balance;

    function __construct($phone)
    {
        $this->phone = $phone;
    }

    //setter and getters 

    public function getPhone()
    {
        return $this->phone;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setPin($pin)
    {
        $this->pin = $pin;
    }
    public function getPin()
    {
        return $this->pin;
    }
    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function registerNewUser($pdo)
    {
        try {
            $hashedPin = password_hash($this->getPin(), PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name,pin,phone,balance) VALUES (?,?,?,?)");
            $stmt->execute([$this->getName(), $hashedPin, $this->getPhone(), $this->getBalance()]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function usersIsRegistered($pdo)
    {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE phone = ?");
            $stmt->execute([$this->getPhone()]);
            if (count($stmt->fetchAll()) > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function readUserName($pdo)
    {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE phone = ?");
        $stmt->execute([$this->getPhone()]);
        $row = $stmt->fetch();
        return $row['name'] ?? '';
    }
    public function readBalance($pdo)
    {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE phone = ?");
        $stmt->execute([$this->getPhone()]);
        $row = $stmt->fetch();
        return $row['balance'] ?? '';
    }
    public function readPin($pdo)
    {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE phone = ?");
        $stmt->execute([$this->getPhone()]);
        $row = $stmt->fetch();
        return $row['pin'] ?? '';
    }
    public function verifyPin($pdo)
    {
        $stmt = $pdo->prepare("SELECT pin FROM users WHERE phone = ?");
        $stmt->execute([$this->getPhone()]);
        $row = $stmt->fetch();
        if ($row['pin'] == null){
            return false;
        }
        if (password_verify($this->pin,$row['pin'])){
            return true;
        }
        return false;
    }
    public function readUserId($pdo)
    {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE phone = ?");
        $stmt->execute([$this->phone]);
        $row = $stmt->fetch();
        return $row['uid'] ?? '';
    }
}

?>