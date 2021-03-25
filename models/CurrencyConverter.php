<?php

/**
 * Uses CurrencyWebservice
 *
 */
class CurrencyConverter {

    private $valore;
    private $valuta_richiesta;
    private $valuta_recuperata;

    public function __construct($valore, $valuta_richiesta) {
        $this->valore = $valore;
        $this->valuta_richiesta = $valuta_richiesta;
    }

    public function convert() {
//        print_r("fff".$this->valore);
        $this->valuta_recuperata = substr($this->getValueFromString($this->valore), 1, -1);
        $this->valore = substr($this->getValueFromString($this->valore), 0, 1);
        $ret = '';
        switch ($this->valuta_richiesta) {
            case 'E':
                $ret = $this->getChangeEuro($this->valuta_recuperata, $this->valore);
                break;
            case 'S':
                $ret = $this->getChangeDollar($this->valuta_recuperata, $this->valore);
                break;
            default:
                $ret = "Valuta non supportata";
        }
        return $ret;
    }

    function getValueFromString($cv) {
        $cv = str_replace('"', '', $cv); // --- elimina i doppi apici
        $cv = str_replace('$', 'S', $cv);
        $cv = str_replace('£', 'L', $cv);
        $cv = str_replace('€', 'E', $cv);
        if (preg_match('(S|L|E)', $cv) === 1) {
            $ca = substr($cv, 0, 1);
        } else {
            $ca = "Z";
        }
        return $cv;
    }

    function getChangeEuro($valore, $valuta) {
        $ret = '';
//        print_r($valore . "------");
//         print_r($valuta . "------");
//        exit;
        if (is_numeric($valore)) {

            switch ($valuta) {
                case 'S':
                    $ret = $valore / 1.38;
                    break;
                case 'L':
                    $ret = $valore / 0.89;
                    break;
                case 'E':
                    $ret = $valore;
                    break;
                default:
                    $ret = "Valuta non supportata";
            }
            if ($ret != "Valuta non supportata") {
                setlocale(LC_MONETARY, 'it_IT');
                $ret = money_format('%.2n', $ret) . "\n";
            }
        } else {
            $ret = "Valore non corretto";
        }
        return $ret;
    }

    function getChangeDollar($valore, $valuta) {
        $ret = '';
//        print_r($valore . "------");
//         print_r($valuta . "------");
//        exit;
        if (is_numeric($valore)) {

            switch ($valuta) {
                case 'S':
                    $ret = $valore;
                    break;
                case 'L':
                    $ret = $valore / 1.89;
                    break;
                case 'E':
                    $ret = $valore / 2.38;
                    break;
                default:
                    $ret = "Valuta non supportata";
            }
            if ($ret != "Valuta non supportata") {
                setlocale(LC_MONETARY, 'it_IT');
                $ret = money_format('%.2n', $ret) . "\n";
            }
        } else {
            $ret = "Valore non corretto";
        }
        return $ret;
    }

}
