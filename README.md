# NosoPHP

Set of classes and tools to communicate with a Noso wallet using NosoP(Noso Protocol)

## Examples

### Node Info

```php
include __DIR__ . '/vendor/autoload.php';

use Noso\NosoNode;
$nodes = [
    ['name'=>'Win1','host'=>'192.210.226.118','port'=>8080],
    ['name'=>'Win2','host'=>'107.172.5.8','port'=>8080]


];

echo "Nodes\n";

foreach ($nodes as $node) {

    echo "   Name     : {$node['name']}\n";
    $nosoNode = new NosoNode($node['host'], intval($node['port']));
    $nodeInfo = $nosoNode->getInfo();
    if ($nodeInfo) {
        echo "   Version  : {$nodeInfo->version}\n";
        echo "   Host     : {$nodeInfo->host}\n";
        echo "   Port     : {$nodeInfo->port}\n";
        echo "   Peers    : {$nodeInfo->peers}\n";
        echo "   Block    : {$nodeInfo->block}\n";
        echo "   Pending  : {$nodeInfo->pending}\n";
        echo "   Branch   : {$nodeInfo->branch}\n";
        echo "   SyncDelta: {$nodeInfo->syncDelta}\n";
    }
    echo "====================================\n";
}
```

### Pool Info

```php
include __DIR__ . '/vendor/autoload.php';

use Noso\NosoPool;

$pools = [
    'DevNoso'=>
        ['host'=>'devnosoeu.nosocoin.com', 'port'=>8082, 'password'=>'UnMaTcHeD'],
    'RussiaPool'=>
        ['host'=>'95.54.44.147', 'port'=>8080, 'password'=>'RussiaPool'],
    'Leviable'=>
        ['host'=>'164.90.252.232', 'port'=>8080, 'password'=>'password'],
    'ITBPool'=>
        ['host'=>'2.tcp.ngrok.io', 'port'=>8080, 'password'=>'Password']
];

$name='DevNoso';
$pool = new NosoPool($name, $pools[$name]['host'], $pools[$name]['port'], $pools[$name]['password']);

$poolInfo = $pool->getInfo('gcarreno-main');
if ($poolInfo) {
    echo "Pool: {$name}\n";
    echo "   Hash rate: {$poolInfo->hashRate}\n";
    echo "   Hash rate: {$poolInfo->HashRate}\n";
    echo "   Fee      : {$poolInfo->fee}\n";
    echo "   Fee      : {$poolInfo->Fee}\n";
    echo "   Share    : {$poolInfo->share}\n";
    echo "   Share    : {$poolInfo->Share}\n";
    if ($poolInfo->minerCount > 0 ) {
        echo "   === Miners ({$poolInfo->minerCount})\n";
        foreach($poolInfo->miners as $miner) {
            echo "   Address: {$miner->address}\n";
            echo "      Balance: {$miner->balance}\n";
            echo "      Balance: {$miner->Balance}\n";
            echo "      Blocks : {$miner->blocks_until_payment}\n";
        }
        echo "   === Miners\n";
    } else {
        echo "   No Miners";
    }
} else {
    echo "Something went wrong!\n";
}
```
