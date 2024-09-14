<?php 

// we make an abstract class for generalization to methods and properties that makes code more lighter and more mentionable
// if there are some methods and properties are used in all classes we can make a separation by a abstract class .

 abstract class BankAccount{
    protected $Balance;
    public $APR;
    public $SortCode;
    public $FirstName;
    public $LastName;
    public $Audit = array();
    protected $Locked;

    //constructor

    public function __construct($FirstName, $LastName, $SortCode, $APR,$Balance =0,$Locked = false) {
        $this->FirstName = $FirstName;
        $this->LastName = $LastName;
        $this->SortCode = $SortCode;
        $this->APR = $APR;
        $this->Balance = $Balance;
        $this->Locked = $Locked;
    }

    //methods

    public function WithDraw($amount){
        $transTime = new DateTime();
        if($this->Locked === false){
            $this->Balance -= $amount;
            array_push($this->Audit,array("WITHDRAWING ACCEPTED",$amount,$this->Balance,$transTime->format("c")));
        }else{
            array_push($this->Audit,array("WITHDRAWING FAILED",$amount,$this->Balance,$transTime->format("c")));
        }
    }
    public function Deposit($amount){
        $transTime = new DateTime();
        if($this->Locked === false){
            $this->Balance += $amount;
            array_push($this->Audit,array("DEPOSIT ACCEPTED",$amount,$this->Balance,$transTime->format("c")));
        }else{
            array_push($this->Audit,array("DEPOSIT FAILED",$amount,$this->Balance,$transTime->format("c")));
        }
    }
    public function LockAccount(){
        $this->Locked = true;
    }
    public function UnLockAccount(){
        $this->Locked = false;
    }
    
}

?>