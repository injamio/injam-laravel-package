<?php

namespace Injamio\InjamLaravelPackage;

use GuzzleHttp\Client;
use Aghasoroush\InjamLaravelPackage\Exceptions\InvalidArgumentException as InvalidArgument;
use Aghasoroush\InjamLaravelPackage\Exceptions\InvalidResponseException;

/**
 * Class InjamLaravelPackage
 * @package Aghasoroush\InjamLaravelPackage
 * @author me@soroo.sh
 */
class InjamLaravelPackage{

    /**
     * Injam.io API key
     * @var string
     */
    protected $apiKey;

    /**
     * Injam.io API interface
     * @var string
     */
    protected $apiAddress;

    /**
     * Number of seconds that http client waits for response
     * @var float
     */
    protected $httpTimeout;

    /**
     * GuzzleHttp Client instance
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * Set API key
     * @param string $apiKey
     * @return $this
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    /**
     * Get API key
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Set API interface
     * @param string $address
     * @return $this
     */
    public function setApiAddress($address)
    {
        $this->apiAddress = $address;
        return $this;
    }

    /**
     * Get API interface
     * @return string
     */
    public function getApiAddress()
    {
        return $this->apiAddress;
    }

    /**
     * Set http request timeout in seconds
     * @param float $timeout
     * @return $this
     * @throws InvalidArgument
     */
    public function setHttpTimeout($timeout)
    {
        if (is_numeric($timeout) && $timeout > 0) {
            $this->httpTimeout = $timeout;
        } else {
            throw new InvalidArgument('$timeout must be numeric and greater than 0');
        }

        return $this;
    }

    /**
     * Get http request timeout
     * @return float
     */
    public function getHttpTimeout()
    {
        return $this->httpTimeout;
    }

    public function __construct()
    {
        $apiKey = config('injam-laravel-package.api_key');
        $apiAddress = config('injam-laravel-package.api_address');
        $httpTimeout = config('injam-laravel-package.http_request_timeout');

        $this->apiKey = $apiKey;
        $this->apiAddress = $apiAddress;
        $this->httpTimeout = $httpTimeout;
        $client = new Client([
            'timeout'  => $httpTimeout,
        ]);

        $this->httpClient = $client;
    }

    /**
     * Create http request and send it to Injam.io servers
     * @param string $path
     * @param string $method
     * @param mixed $body
     * @return array
     * @throws InvalidArgumentException
     * @throws InvalidResponseException
     */
    protected function sendRequest($path, $method, $body=null)
    {
        $method = strtoupper($method);
        $resp = null;

        if (in_array($method, ['PUT', 'POST', 'UPDATE', 'PATCH'])) {
            if (!is_array($body)) {
                throw new InvalidArgument('$body should be array');
            }
        }

        $options = [];

        if (!in_array($method, ['GET', 'DELETE'])) {
            $options['json'] = $body;
        }

        $options['headers'] = [
            'X-AUTHORIZATION'   =>  $this->apiKey
        ];

        try {
            $resp = $this->httpClient->request($method, $this->apiAddress . $path, $options);
//            dd($resp->getBody()->getContents());
            return json_decode($resp->getBody()->getContents(), true);
        } catch (\Exception $e) {
            throw new InvalidResponseException('Invalid response. ' . $e->getMessage());
        }
    }

    /**
     * Add a tracker
     * @param string $trackingPhysicalId
     * @param string $trackerMobile
     * @param string $title
     * @param string $description
     * @param string $trackingName
     * @param string $trackingMobile
     * @param string $trackingAvatar
     * @return array
     */
    public function addTracker($trackingPhysicalId,
                               $trackerMobile,
                               $title=null,
                               $description=null,
                               $trackingName=null,
                               $trackingMobile=null,
                               $trackingAvatar=null)
    {
        $params = [
            'tracking_physical_id'  =>  $trackingPhysicalId,
            'tracker_mobile'        =>  $trackerMobile,
            'title'                 =>  $title,
            'description'           =>  $description,
            'tracking_name'         =>  $trackingName,
            'tracking_mobile'       =>  $trackingMobile,
            'tracking_avatar'       =>  $trackingAvatar
        ];

        return $this->sendRequest('trackers/add', 'POST', $params);
    }

    /**
     * Set status of a tracker to done(the tracker link will not be working after this api call)
     * @param string $trackingPhysicalId
     * @return array
     */
    public function doneTracker($trackingPhysicalId)
    {
        $params = [];
        $path = 'trackers/' . $trackingPhysicalId . '/done';
        return $this->sendRequest($path, 'POST', $params);
    }

    /**
     * Add Geofence webhook for a tracker
     * @param string $objectType
     * @param string $objectPhysicalId
     * @param string $targetPoint
     * @param integer $radius
     * @param string $endpoint
     * @param string  $detect
     * @return array
     * @throws InvalidArgument
     */
    public function addGeoFenceWebhook($objectType,
                                       $objectPhysicalId,
                                       $targetPoint,
                                       $radius,
                                       $endpoint,
                                       $detect=null)
    {
        $params = [
            'object_type'           =>  $objectType,
            'object_physical_id'    =>  $objectPhysicalId,
            'target_point'          =>  $targetPoint,
            'radius'                =>  $radius,
            'endpoint'              =>  $endpoint,
            'detect'                =>  $detect
        ];

        return $this->sendRequest('webhooks/fence/add', 'POST', $params);
    }

    public function deleteWebhook($webhookId)
    {
        $params = [];
        $path = 'webhooks/fence/' . $webhookId;
        return $this->sendRequest($path, 'DELETE', $params);
    }
}
