<?php

namespace Kemlu\Oauth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class KemluUser implements ResourceOwnerInterface
{
    /**
     * @var string
     */
    protected $response;

    /**
     * @param array $response
     */
    public function __construct($response)
    {
        $this->response = $response;
        $this->response = $this->toArray();
    }

    public function getId()
    {
        return $this->response['id'];
    }

    /**
     * Get email address.
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->getResponseValue('email');
    }


    /**
     * Get user data as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return json_decode($this->response,true);
    }


    private function getResponseValue($key)
    {
        return $this->response->[$key] ?? null;
    }
}
