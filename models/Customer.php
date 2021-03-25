<?php

require_once('./models/CurrencyWebservice.php');
require_once('./models/CurrencyConverter.php');

class Customer {

    private $id_c;
    private $val_r;
    private $transactions = [];
    private $currency;

    function __construct($params) {
        $this->id_c = $params[1];
        $this->val_r = $params[2];
    }

    public function getDate() {
        echo "DATA TODO";
    }

    public function getTransaction() {
        echo "Transazione TODO";
    }

    public function getTransactions() {
        if (($handle = fopen("data.csv", "r")) !== FALSE) { // --- fopen apre un file, arg: url del file, r- sola lettura
            $e = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { // --- fgetcsv per leggere file csv, arg: $handle(puntatore al file), 1000(numero massimo della lunghezza della linea nel csv), ","(delimitatore)
                for ($c = 0; $c < count($data); $c++) {
                    $r = explode(";", $data[$c]); // --- explode divide una stringa($data[$c]) in un array attraverso un delimitatore (;)
                    if ($r[0] == $this->id_c) {
                        $e++;
                        $cvr = $this->getValueFromString($r[2]);
                        $dep = new CurrencyConverter($r[2], $this->val_r);
                        $change = new CurrencyWebservice($dep);
//                        $change = new CurrencyWebservice();
                        $this->currency = $change->getExchangeRate();
                        $this->transactions[] = [$r[1], $this->id_c, $cvr, $this->currency];
                    }
                }
            }
            if ($e == 0) {
                echo "Utente " . $this->id_c . " inesistente.\n";
            }
            fclose($handle); // --- chiusura del puntatore al file aperto
        }
        return $this->transactions;
    }

    function currencyConverter($valore, $valuta) {
        $get_par = '?valore=' . $valore . '&valuta=' . $valuta;
        $json = file_get_contents('http://www.serdf3r.com/currencyConverter/index.php' . $get_par); // --- servizio di cambio valuta
        $obj = json_decode($json);
        return $obj->euro;
    }

    public function getValueFromString($cv) {
        $cv = str_replace('"', '', $cv); // --- elimina i doppi apici
        $cv = str_replace('$', 'S', $cv);
        $cv = str_replace('£', 'L', $cv);
        $cv = str_replace('€', 'E', $cv);
        if (preg_match('(S|L|E)', $cv) === 1) {
            $ca = substr($cv, 0, 1);
        } else {
            $ca = "Z";
        }
    }

}
