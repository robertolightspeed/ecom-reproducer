<?php
namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Reproducer
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $token;

    private $response;

    public function __construct()
    {
        $this->token = getenv('TOKEN');
        $this->setClient();
    }

    private function setClient()
    {
        if (!$this->client) {
            $this->client = new Client([
                'base_uri' => getenv('SHOP_URL'),
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->token,
                ]
            ]);
        }
    }

    /**
     * @param $method
     * @param $uri
     * @param $params
     * @return $this
     */
    private function call($method, $uri, $params)
    {
        try
        {
            $this->response = $this->client->request($method, $uri, [ 'form_params' => $params ]);
            $this->checkRateLimit();
        }
        catch (ClientException $e)
        {
            var_dump($e->getMessage());
        }

        return $this;
    }

    private function checkRateLimit()
    {
        $rateLimit = explode('/', $this->response->getHeaders()['X-Rate-Limit'][0]);
        if ((int) $rateLimit[0] == ( (int) $rateLimit[1]) - 1)
        {
            sleep(5);
        }
    }
    /**
     * @param $uri
     * @param $params
     * @return Reproducer
     */
    protected function post($uri, $params)
    {
        return $this->call('POST', $uri, $params);
    }

    /**
     * @return int
     */
    protected function getStatusCode()
    {
        return $this->response->getStatusCode();
    }

    /**
     * @return array
     */
    protected function getJson()
    {
        return json_decode($this->response->getBody(), true);
    }

    public function _action()
    {

    }

    public function _prepare()
    {

    }
}