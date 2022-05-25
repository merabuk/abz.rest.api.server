<?php
namespace App\Services;

use http\Exception\InvalidArgumentException;
use Tinify\AccountException;
use Tinify\ClientException;
use Tinify\Source;
use Tinify\Tinify as Service;

class Tinify
{
    /**
     * @var string
     */
    private $apikey;

    /**
     * @var Service
     */
    private $client;

    /**
     * Get api key from env, fail if any are missing.
     * Instantiate API client and set api key.
     *
     * @throws InvalidArgumentException
     */
    public function __construct() {
        $this->apikey = env('TINIFY_APIKEY');
        if(!$this->apikey) {
            throw new InvalidArgumentException('Please set TINIFY_APIKEY environment variables.');
        }
        $this->client = new Service();
        $this->client->setKey($this->apikey);
    }

    public function setKey($key) {
        return $this->client->setKey($key);
    }

    public function setAppIdentifier($appIdentifier) {
        return $this->client->setAppIdentifier($appIdentifier);
    }

    public function getCompressionCount() {
        return $this->client->getCompressionCount();
    }

    public function compressionCount() {
        return $this->client->getCompressionCount();
    }

    public function fromFile($path) {
        return Source::fromFile($path);
    }

    public function fromBuffer($string) {
        return Source::fromBuffer($string);
    }

    public function fromUrl($string) {
        return Source::fromUrl($string);
    }

    function validate() {
        try {
            Service::getClient()->request("post", "/shrink");
        } catch (AccountException $err) {
            if ($err->status == 429) return true;
            throw $err;
        } catch (ClientException $err) {
            return true;
        }
    }
}
