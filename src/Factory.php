<?php

namespace React\HttpClient;

use React\EventLoop\LoopInterface;
use React\Dns\Resolver\Resolver;
use React\SocketClient\Connector;
use React\SocketClient\SecureConnector;
use InvalidArgumentException;

class Factory
{
    public function __construct(LoopInterface $loop, ConnectorInterface $connector = null, SecureConnector $secureConnector = null)
    {
        if ($connector === null) {
            $connector = new Connector();
        }
    }

    public function create(LoopInterface $loop, Resolver $resolver)
    {
        $connector = new Connector($loop, $resolver);
        $secureConnector = new SecureConnector($connector, $loop);

        return new Client($connector, $secureConnector);
    }

    public function createClient();

    public function createProxyClient($proxyUrl)
    {
        $parts = parse_url($proxyUrl);
        if (!$parts || !isset($parts['host'])) {
            throw new \InvalidArgumentException('Invalid proxy URL given, expected "http://HOST:port/"');
        }

        // TODO: P1 for plain HTTP requests ONLY, not for https
        // 'request_fulluri' => true,

        // TODO: P2 proxy authentication
        // $auth = base64_encode("$PROXY_USER:$PROXY_PASS");
        // "Proxy-Authorization: Basic $auth"

        // TODO: P3 use proxy connector over secureConnector for HTTPS proxy (irrespective of http request)

        // TODO: P2 use HttpConnectConnector for HTTPS requests

        $connector = new \ProxyConnector($parts['host'], $parts['port'] ?: 80, $this->connector);
        $secureConnector = new DummyConnector();

        return new Client($connector, $secureConnector);
    }
}
