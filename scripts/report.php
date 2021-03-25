<?php

require('./models/Customer.php');
// --- $argv Contains an array of all the arguments passed to the script when running from the command line
if (count($argv) != 3) {
    throw new Exception("Gli argomenti passati devono essere Id-Cliente e Valuta di Coversione");
}
//print_r($argv);
$customer = $argv[1];
echo "Transazioni dell' utente " . $customer . "\n";
$customer = new Customer($argv);
foreach ($customer->getTransactions() as $transaction) {
  
    echo "In data " . $transaction[0] . " l'utente " . $transaction[1] . " ha fatto la seguente transazione: " . $transaction[2] . " --> " . $transaction[3] . "\n";
}