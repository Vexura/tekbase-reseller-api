<?php


namespace TekBaseAPI;

use GuzzleHttp\Client;
use TekBaseAPI\Exception\ParameterException;
use Psr\Http\Message\ResponseInterface;
use TekBaseAPI\Licenses\Licenses;

class TekBaseAPI
{
    private $httpClient;
    private $credentials;
    private $apiToken;
    private $accountingHandler;
    private $reseller_id;

    /**
     * TekBaseAPI constructor.
     *
     * @param string $token API Token for all requests
     * @param null $httpClient
     */
    public function __construct(string $token, string $reseller_id, $httpClient = null) {
        $this->apiToken = $token;
        $this->reseller_id = $reseller_id;
        $this->setHttpClient($httpClient);
        $this->setCredentials($token, $reseller_id);
    }


    public function setHttpClient(Client $httpClient = null)
    {
        $this->httpClient = $httpClient ?: new Client([
            'allow_redirects' => false,
            'follow_redirects' => false,
            'timeout' => 120,
            'http_errors' => false,
        ]);
    }

    public function setCredentials($api_token, $reseller_id)
    {
        $this->credentials  = new Credentials($api_token, $reseller_id);
    }

    /**
     * @return Client
     */
    public function getHttpClient(): Client
    {
        return $this->httpClient;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->apiToken;
    }

    /**
     * @return string
     */
    public function getResellerId()
    {
        return $this->reseller_id;
    }

    /**
     * @return Credentials
     */
    private function getCredentials(): Credentials
    {
        return $this->credentials;
    }


    /**
     * @param string $actionPath The resource path you want to request, see more at the documentation.
     * @param array $params Array filled with request params
     * @param string $method HTTP method used in the request
     *
     * @return ResponseInterface
     *
     * @throws ParameterException If the given field in params is not an array
     */
    private function request(string $actionPath, array $params = [], string $method = 'GET'): ResponseInterface
    {
        $url = $this->getCredentials()->getUrl() . $actionPath;

        if (!is_array($params)) {
            throw new ParameterException();
        }

        $params['authenticate'] = 'apikey=' . $this->apiToken;

        switch ($method) {
            case 'GET':
                return $this->getHttpClient()->get($url, ['verify' => false, 'headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json', 'authenticate' => 'apikey=' . $this->apiToken]]);
            case 'POST':
                return $this->getHttpClient()->post($url, ['verify' => false, 'headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json', 'authenticate' => 'apikey=' . $this->apiToken], 'form_params' => $params,]);
            case 'PUT':
                return $this->getHttpClient()->put($url, ['verify' => false, 'headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json', 'authenticate' => 'apikey=' . $this->apiToken], 'form_params' => $params,]);
            case 'DELETE':
                return $this->getHttpClient()->delete($url, ['verify' => false, 'headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json', 'authenticate' => 'apikey=' . $this->apiToken], 'form_params' => $params,]);
            default:
                throw new ParameterException('Wrong HTTP method passed');
        }
    }

    private function processRequest(ResponseInterface $response)
    {
        $response = $response->getBody()->__toString();
        $result = json_decode($response);
        if (json_last_error() == JSON_ERROR_NONE) {
            return $result;
        } else {
            return $response;
        }
    }


    public function get($actionPath, $params = [])
    {
        $response = $this->request($actionPath, $params);

        return $this->processRequest($response);
    }

    public function post($actionPath, $params = [])
    {
        $response = $this->request($actionPath, $params, 'POST');

        return $this->processRequest($response);
    }

    public function put($actionPath, $params = [])
    {
        $response = $this->request($actionPath, $params, 'PUT');

        return $this->processRequest($response);
    }

    public function delete($actionPath, $params = [])
    {
        $response = $this->request($actionPath, $params, 'DELETE');

        return $this->processRequest($response);
    }

    /**
     * @return Licenses
     */
    public function licenses(): Licenses
    {
        if (!$this->accountingHandler) $this->accountingHandler = new Licenses($this);
        return $this->accountingHandler;
    }


}
