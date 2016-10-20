<?php

namespace App\Reporting;

use Guzzle\Http\Client as HttpClient;
use Guzzle\Http\Message\Response as HttpResponse;
use Doctrine\ORM\EntityManager;

abstract class BaseClient
{
    protected $client;

    public function __construct(HttpClient $client, EntityManager $em = null)
    {
        $this->client = $client;
        $this->em = $em;
    }

    public static function createCLient($baseUrl, $config, EntityManager $em, array $plugins = null)
    {
        $requestOptions = isset($config['request.options']) ? $config['request.options'] : [];
        $config['request.options'] = array_merge([
            'timeout' => 120,
            'connect_timeout' => 5,
        ], $requestOptions);

        $client = new HttpClient($baseUrl, $config);

        if (is_array($plugins)) {
            foreach ($plugins as $plugin) {
                $client->addSubscriber($plugin);
            }
        }

        return new static($client, $em);
    }

    protected function request($path)
    {
        $response = $this->client->get($path)->send();

        return $this->responseCallback($response);
    }

    public function parallelRequests(array $paths, $concurrentLimit = null)
    {
        if ($concurrentLimit === null) {
            $concurrentLimit = count($paths);
        }

        $return = [];

        for ($offset = 0; $offset < count($paths); $offset += $concurrentLimit) {
            $sendPaths = array_slice($paths, $offset, $concurrentLimit);

            $requests = [];
            foreach ($sendPaths as $path) {
                $requests[] = $this->client->get($path);
            }

            $responses = $this->client->send($requests);
            foreach ($responses as $response) {
                $return[] = $this->responseCallback($response);
            }
        }

        return $return;
    }

    protected function responseCallback(HttpResponse $response)
    {
        return $response;
    }
}
