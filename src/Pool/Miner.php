<?php

declare(strict_types = 1);

namespace Noso\Pool;

class Miner {
    public $address;
    public $balance;
    public $blocks_until_payment;
    public $hashRate;

    public function __construct(){
        $this->address = '';
        $this->balance = -1;
        $this->blocks_until_payment = -1;
        $this->hashRate = -1;
    }

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

    private function hashRateFormatted(){
        // Tera Hashes per Second
        if ($this->hashRate >= 1000 * 1000 * 1000 - 1) {
            $value = $this->hashRate / (1000 * 1000 * 1000);
            if ($value < 10) {
                return sprintf('%.2f TH/s', $value);
            }
            if ($value < 100) {
                return sprintf('%.1f TH/s', $value);
            }
            if ($value < 1000) {
                return sprintf('%.0f TH/s', $value);
            }
        }
        // Giga Hashes per Second
        if ($this->hashRate >= 1000 * 1000 - 1) {
            $value = $this->hashRate / (1000 * 1000);
            if ($value < 10) {
                return sprintf('%.2f GH/s', $value);
            }
            if ($value < 100) {
                return sprintf('%.1f GH/s', $value);
            }
            if ($value < 1000) {
                return sprintf('%.0f GH/s', $value);
            }
        }
        // Mega Hashes per Second
        if ($this->hashRate >= 1000 - 1) {
            $value = $this->hashRate / (1000);
            if ($value < 10) {
                return sprintf('%.2f MH/s', $value);
            }
            if ($value < 100) {
                return sprintf('%.1f MH/s', $value);
            }
            if ($value < 1000) {
                return sprintf('%.0f MH/s', $value);
            }
        }
        // Kilo Hashes per Second
        $value = $this->hashRate;
        if ($value < 10) {
            return sprintf('%.2f KH/s', $value);
        }
        if ($value < 100) {
            return sprintf('%.1f KH/s', $value);
        }
        if ($value < 1000) {
            return sprintf('%.0f KH/s', $value);
        }
        return '';
    }

    public function __get($name){
        if ($name == 'Balance') {
            return $this->balanceFormatted();
        }
        if ($name == 'HashRate') {
            return $this->hashRateFormatted();
        }
    }
}
