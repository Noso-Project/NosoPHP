<?php

declare(strict_types = 1);

namespace Noso;

use Noso\NosoClient;
use Noso\Pool\PoolInfo;
use Noso\Pool\Miner;
use Noso\Blocks\Balance;

class NosoPool{
    private $name;
    private $host;
    private $port;
    private $password;

    private $client;

    public function __construct($name, $host, $port, $password){
        $this->name = $name;
        $this->host = $host;
        $this->port = $port;
        $this->password = $password;

        $this->client = new NosoClient($this->host, $this->port, 300);
    }

    private function _fetch($request){
        //echo "->request: {$request}\n";
        //echo "Connecting to {$this->host}:{$this->port}\n";
        $this->client->connect();
        $this->client->write("${request}\r\n");
        $response = $this->client->read();
        $this->client->disconnect();
        //echo "<-response: {$response}\n";
        return trim($response);
    }

    public function getInfo($address) {
        try {
            $response = $this->_fetch("{$this->password} {$address} STATUS");

            if (!empty($response)) {
                $response = explode(' ', $response);
                if ($response[0] != 'STATUS') {
                    throw new \Exception('Wrong response');
                }
                $poolInfo = new PoolInfo();
                $poolInfo->name = $this->name;
                $poolInfo->hashRate = intval($response[1]);
                $poolInfo->fee = intval($response[2]);
                $poolInfo->share = intval($response[3]);
                $poolInfo->minerCount = intval($response[4]);
                if ($poolInfo->minerCount > 0) {
                    for ($index=5; $index < count($response); $index++) {
                        $data = explode(':', $response[$index]);
                        $miner = new Miner();
                        $miner->address = $data[0];
                        $miner->balance = intval($data[1]);
                        $miner->blocks_until_payment = intval($data[2]);
                        $poolInfo->miners[] = $miner;
                    }
                }
                return $poolInfo;
            } else {
                return null;
            }
        } catch (\Exception $e){
            return null;
        }
    }

    public function getBalance($address, $balance_address) {
        try {
            $response = $this->_fetch("{$this->password} {$address} ADDRESSBAL {$balance_address}");

            if (!empty($response)) {
                $response = explode(' ', $response);
                if ($response[0] != 'ADDRESSBAL') {
                    throw new \Exception('Wrong response');
                }
                $balance = new Balance();
                $balance->address = $response[1];
                $balance->summary = $response[2];
                $balance->incoming = $response[3];
                $balance->outgoing = $response[4];
                $balance->available = $response[5];
                return $balance;
            } else {
                return null;
            }
        } catch (\Exception $e){
            return null;
        }
    }
}
