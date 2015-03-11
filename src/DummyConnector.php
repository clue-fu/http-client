<?php

namespace React\HttpClient;

use React\SocketClient\ConnectorInterface;
use React\Promise\Deferred;

class RejectingConnector implements ConnectorInterface
{
    public function create($host, $port)
    {
        $deferred = new Deferred();
        $deferred->reject(new Exception());
        return $deferred->promise();
    }
}
