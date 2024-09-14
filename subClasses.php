<?php 

require("BankAccount.php");

class ISA extends BankAccount{
    public $timePeriod ;
    public $additionalServices;

    public function __construct($timePeriod,$additionalServices,$FirstName, $LastName, $SortCode, $APR,$Balance =0,$Locked = false){
        $this->timePeriod = $timePeriod;
        $this->additionalServices = $additionalServices;
        parent::__construct($FirstName, $LastName, $SortCode, $APR,$Balance,$Locked);
    }

    //Methods

    public function WithDraw($amount){
        $transDate = new DateTime();
        $lastTransaction = null;
        $length = count($this->Audit);
        
        for ($i=$length; $i > 0; $i--) { 
            $element = $this->Audit[$i - 1]; 
            if($element[0] === "WITHDRAWING ACCEPTED"){
                $days = new DateTime($element[3]);
                $lastTransaction = $days->diff($transDate)->format('%a');
                break;
            }
        }

        if($lastTransaction === null && $this->Locked === false || $this->Locked === false && $lastTransaction > $this->timePeriod)
        {
            $this->Balance -= $amount;
            array_push($this->Audit,array("WITHDRAWING ACCEPTED", $amount, $this->Balance ,$transDate->format("c")));
        }else{
            
            if($this->Locked === false){
                $this->Balance -= $amount;
                array_push($this->Audit,array("WITHDRAWING ACCEPTED WITH PENALTY", $amount, $this->Balance ,$transDate->format("c")));
                $this->Penalty();
            }else{
                array_push($this->Audit,array("WITHDRAWING FAILED", $amount, $this->Balance ,$transDate->format("c")));
            }
            
        }
        
    }
    private function Penalty(){
        $penDate = new DateTime(); 
        $this->Balance -= 10;
        array_push($this->Audit,array("PENALTY",10,$this->Balance,$penDate->format('c')));
    }
    
}
// if we have some small static methods and properties are same in some inherited classes we can make a trait and interface 
// and implement that interface for these classes and use trait in them 
// that's prevent iteration of code and make code more lighter 
// This approach minimizes code duplication while maintaining a consistent structure across your classes.
trait SavingPlus{
    private $monthlyFee = 20;
    public $package = "holiday insurance";
    
    // Methods...

    public function AddBonus(){
        echo "Hello ".$this->FirstName." ".$this->LastName." you had $".$this->monthlyFee."a month you get ".$this->package;
    }
}

interface Bonus{
    public function AddBonus();
}

class Savings extends BankAccount implements Bonus{
    use SavingPlus;
    
    public $pocketBook = array();
    public $depositBook = array();
    
    //methods


    public function orderNewBook(){
        $orderTime = new DateTime();
        array_push($this->pocketBook,array("Ordered new pocket book on: ".$orderTime->format('c')));
    }
    public function orderNewDepositBook(){
        $orderTime = new DateTime();
        array_push($this->depositBook,array("Ordered new deposit pocket book on: ".$orderTime->format('c')));
    }
}

class Debit extends BankAccount implements Bonus{
    
    use SavingPlus;
    
    private $creditNumber;
    private $securityCode;
    private $pinNumber;

    //Methods


    public function Validate(){
        $valDate = new DateTime();
        $this->creditNumber = rand(1000,9999)."-".rand(1000,9999)."-".rand(1000,9999)."-".rand(1000,9999);
        $this->securityCode = rand(100,999);
        array_push($this->Audit,array("VALIDATED CARD",$this->creditNumber,$this->securityCode,$this->pinNumber,$valDate->format('c')));
    }
    public function changePin($newPIN){
        $changeDate = new DateTime();
        $this->pinNumber = $newPIN;
        array_push($this->Audit,array("PIN CHANGED",$this->pinNumber,$changeDate->format('c')));
    }
}
?>