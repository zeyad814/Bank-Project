<?php 
require './subClasses.php';

$Account1 = new ISA(25,'a7mos','zeyad','qapil','20-20-32',5.4,1000);

$Account1->Deposit(1000);
$Account1->WithDraw(200);
$Account1->WithDraw(150);
echo serialize($Account1);
var_dump($Account1);


//procedural programming paradigms


// $Account2 = new Savings;

// $Account2->APR = 13.0;
// $Account2->FirstName = 'hamada';
// $Account2->LastName = 'medo';
// $Account2->package = 'the package';

// $Account2->Deposit(500);
// $Account2->LockAccount();
// $Account2->WithDraw(200);
// $Account2->UnLockAccount();
// $Account2->WithDraw(200); 





// $Account3 = new Debit;

// $Account3->APR = 13.0;
// $Account3->FirstName = 'ahmed';
// $Account3->LastName = 'elqady';
// $Account3->package = 'spy package';

// $Account3->Deposit(500);
// $Account3->LockAccount();
// $Account3->WithDraw(200);
// $Account3->UnLockAccount();
// $Account3->WithDraw(200);

// // $Account3->AddBonus();
// $Account3->validate();
// $Account3->changePin(1523);



// $accounts = array($Account1,$Account2,$Account3);

// foreach($accounts as $key => $account){
//     $print =  $account->FirstName;
//     if($account instanceof Bonus){
//         $print.= $account->AddBonus();
//     }
//         echo "".$print."</br>";
// }

echo "</pre>";
var_dump(get_declared_classes());



?>