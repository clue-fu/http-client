<?php

namespace React\HttpClient;

use React\HttpClient\Client;

class ProxyClient extends Client
{
    public function __construct($connector, $secureConnector);
}
