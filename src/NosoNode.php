<?php

declare(strict_types = 1);

namespace Noso;

use Noso\NosoClient;
use Noso\Node\NodeInfo;

class NosoNode {
    private $host;
    private $port;

    public function __construct($host, $port){
        $this->host = $host;
        $this->port = $port;

        $this->client = new NosoClient($this->host, $this->port, 30);
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

    public function getInfo() {
        try {
            $response = $this->_fetch("NODESTATUS");

            $nodeInfo = new NodeInfo();
            $nodeInfo->host = $this->host;
            $nodeInfo->port = $this->port;
            if (!empty($response)) {
                $response = explode(' ', $response);
                if ($response[0] != 'NODESTATUS') {
                    throw new \Exception('Wrong response');
                }
                $nodeInfo->peers = isset($response[1])?$response[1]:-1;
                $nodeInfo->block = isset($response[2])?$response[2]:-1;
                $nodeInfo->pending = isset($response[3])?$response[3]:-1;
                $nodeInfo->syncDelta = isset($response[4])?$response[4]:-1;
                $nodeInfo->branch = isset($response[5])?$response[5]:'';
                $nodeInfo->version = isset($response[6])?$response[6]:'UNKNOWN';
            }
            return $nodeInfo;
        } catch (\Exception $e){
            return null;
        }
    }
}
