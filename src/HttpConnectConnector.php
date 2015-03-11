<?php

namespace React\HttpClient;

use React\SocketClient\ConnectorInterface;
use React\Stream\Stream;
use React\Promise\Deferred;

class HttpConnectConnector implements ConnectorInterface
{
    private $proxyHost;
    private $proxyPort;
    private $connector;

    public function __construct($proxyHost, $proxyPort, ConnectorInterface $connector)
    {
        $this->proxyHost = $proxyHost;
        $this->proxyPort = $proxyPort;
        $this->connector = $connector;
    }

    public function connect($host, $port)
    {
        return $this->connector->create($this->proxyHost, $this->proxyPort)->then(function (Stream $stream) use ($host, $port) {
            $stream->write("CONNECT $host:$port HTTP/1.0\r\n\r\n");

            // TODO: write Host
            // TODO: write ProxyAuthentication

            $deferred = new Deferred();

            // TODO: wait until \r\n\r\n
            // TODO: check status
            // TODO: enable StreamEncryption

            return $deferred->promise();
        });
    }
}
