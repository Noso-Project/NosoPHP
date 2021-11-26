<?php

declare(strict_types = 1);

namespace Noso\Pool;

use Noso\Pool\Miner;

class PoolInfo{
    public $name;
    public $hashRate;
    public $fee;
    public $share;
    public $minerCount;
    public $miners;

    public function __construct(){
        $this->miners = array();
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

    private function feeFormatted(){
        return sprintf('%4.2f%%', $this->fee / 100);
    }

    private function shareFormatted(){
        return sprintf('%d%%', $this->share);
    }

    public function __get($name){
        $return = '';
        if ($name == 'HashRate'){
            $return = $this->hashRateFormatted();
        }
        if ($name == 'Fee'){
            $return = $this->feeFormatted();
        }
        if ($name == 'Share'){
            $return = $this->shareFormatted();
        }
        return $return;
    }
}
