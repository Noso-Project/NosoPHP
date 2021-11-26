<?php

declare(strict_types = 1);

namespace Noso\Node;

class NodeInfo {
    public $host;
    public $port;
    public $peers;
    public $block;
    public $pending;
    public $syncDelta;
    public $branch;
    public $version;

    public function __construct() {
        $this->host = '';
        $this->port = 8080;
        $this->peers = -1;
        $this->block = -1;
        $this->pending = -1;
        $this->syncDelta = -1;
        $this->branch = 'NONE';
        $this->version = 'UNKNOWN';
    }
}
