<?php

namespace Kemlu\Oauth\Client\Grant;

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
