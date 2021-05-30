<?php

namespace Kemlu\Oauth2\Client\Grant;

use League\OAuth2\Client\Grant\AbstractGrant;

/**
 *
 */
class KemluExchangeToken extends AbstractGrant
{
  public function __toString(): string
  {
    return 'kemlu_exchange_token';
  }

  protected function getRequiredRequestParameters(): array
    {
        return [
            'kemlu_exchange_token',
        ];
    }

    protected function getName(): string
    {
        return 'kemlu_exchange_token';
    }

}
