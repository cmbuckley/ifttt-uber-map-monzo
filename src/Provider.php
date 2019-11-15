<?php

namespace Starsquare\Monzo;

use Edcs\OAuth2\Client\Provider\Mondo as MonzoProvider;

class Provider extends MonzoProvider {
    protected $baseAuthorizationUrl;

    public function getBaseAuthorizationUrl() {
        return $this->baseAuthorizationUrl;
    }
}
