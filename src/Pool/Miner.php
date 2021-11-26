<?php

declare(strict_types = 1);

namespace Noso\Pool;

class Miner {
    public $address;
    public $balance;
    public $blocks_until_payment;

    private function balanceFormatted(){
        if ($this->balance == 0) {
            return '0.00000000';
        }
        if ($this->balance < 100000000) {
            return '0.' . sprintf('%08d', $this->balance);
        }
        return  substr(strval($this->balance), 0, strlen(strval($this->balance)) - 8) .
            '.' .
            substr(strval($this->balance), -8);
    }

    public function __get($name){
        if ($name == 'Balance') {
            return $this->balanceFormatted();
        }
    }
}
