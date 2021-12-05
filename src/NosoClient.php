<?php

declare(strict_types = 1);

namespace Noso;

class NosoClient{
    private $host;
    private $port;
    private $timeout;
    private $lastError;
    private $socket;
    private $connected;

    function __construct($host, $port, $timeout = 30){
        $this->host = $host;
        $this->port = $port;
        $this->timeout = $timeout;
        $this->connected = false;
    }

    public function connect(){
        $this->socket = fsockopen($this->host, $this->port, $errno, $errstr, $this->timeout);
        if (!$this->socket) {
            $this->lastError = "{$errno}: {$errstr}";
            $this->connected = false;
            throw new \Exception("{$errno}: {$errstr}");
        }
        $this->connected = true;
    }

    public function disconnect(){
        fclose($this->socket);
    }

    public function isConnected(){
        return $this->connected;
    }

    public function getLastError(){
        return $this->lastError;
    }

    public function write($data){
        fwrite($this->socket, $data);
    }

    public function read(){
        $response = '';
        while (!feof($this->socket)) {
            $response .= fgets($this->socket, 256);
        }
        return trim($response);
    }
}
