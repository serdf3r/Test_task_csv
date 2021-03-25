<?php

require_once('./models/CurrencyConverter.php');

/**
 * Dummy web service returning random exchange rates
 *
 */
class CurrencyWebservice {

    /**
     * @todo return random value here for basic currencies like GBP USD EUR (simulates real API)
     *
     */
    private $_dep;

    public function __construct(CurrencyConverter $dep) {
        $this->_dep = $dep->convert();
    }

    function getExchangeRate() {
        return $this->_dep;
    }

}
