<?php

namespace Kemlu\Oauth2\Client\Provider;

use League\OAuth2\Client\Exception\HostedDomainException;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;
use League\OAuth2\Client\Provider\AbstractProvider;
use UnexpectedValueException;

/**
 *
 */
class Kemlu extends AbstractProvider
{
  use BearerAuthorizationTrait;

    /**
     * @var string If set, this will be sent to kemlu as the "access_type" parameter.
     * @link
     */
    protected $accessType;

    /**
     * @var string If set, this will be sent to kemlu as the "prompt" parameter.
     */
    protected $prompt;


    /**
     * @var array List of scopes that will be used for authentication.
     * @link https://developer.kemlu.go.id/identity/protocols/scopes
     */
    protected $scopes = [];

    protected $identityUrl = "https://identity.kemlu.go.id" ;

    public function setIdentityUrl($url):self
    {
        $this->identityUrl = $url;
        return $this;
    }

    public function getBaseAuthorizationUrl(): string
    {
        return $this->identityUrl.'/authorize';
    }

    public function getBaseAccessTokenUrl(array $params): string
    {
        return $this->identityUrl.'/token';
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token): string
    {
        return $this->identityUrl.'/api/user_infos';
    }

    protected function getAuthorizationParameters(array $options): array
    {

        if (empty($options['access_type']) && $this->accessType) {
            $options['access_type'] = $this->accessType;
        }

        if (empty($options['prompt']) && $this->prompt) {
            $options['prompt'] = $this->prompt;
        }

        // Default scopes MUST be included for OpenID Connect.
        // Additional scopes MAY be added by constructor or option.
        $scopes = array_merge($this->getDefaultScopes(), $this->scopes);

        if (!empty($options['scope'])) {
            $scopes = array_merge($scopes, $options['scope']);
        }

        $options['scope'] = array_unique($scopes);

        $options = parent::getAuthorizationParameters($options);

        // The "approval_prompt" MUST be removed as it is not supported by kemlu, use "prompt" instead:
        // https://developers.kemlu.com/identity/protocols/oauth2/openid-connect#prompt
        unset($options['approval_prompt']);

        return $options;
    }

    protected function getDefaultScopes(): array
    {
        return [
            'read',
            'profile',
            'email',
        ];
    }

    protected function getScopeSeparator(): string
    {
        return ' ';
    }

    protected function checkResponse(ResponseInterface $response, $data): void
    {
        // @codeCoverageIgnoreStart
        if (empty($data['error'])) {
            return;
        }
        // @codeCoverageIgnoreEnd

        $code = 0;
        $error = $data['error'];

        if (is_array($error)) {
            $code = $error['code'];
            $error = $error['message'];
        }

        throw new IdentityProviderException($error, $code, $data);
    }

    protected function createResourceOwner(array $response, AccessToken $token): KemluUser
    {
        $user = new KemluUser($response);
        return $user;
    }


    /**
     * Returns a prepared request for requesting an access token.
     *
     * @param array $params Query string parameters
     * @return RequestInterface
     */
    protected function getAccessTokenRequest(array $params)
    {
        $method  = $this->getAccessTokenMethod();
        $url     = $this->getAccessTokenUrl($params);
        $options = $this->optionProvider->getAccessTokenOptions($this->getAccessTokenMethod(), $params);

        $options['verify'] = false;
        return $this->getRequest($method, $url, $options);

    }

}
