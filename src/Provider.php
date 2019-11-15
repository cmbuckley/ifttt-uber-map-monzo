<?php

namespace Starsquare\Monzo;

use Edcs\OAuth2\Client\Provider\Mondo as MonzoProvider,
    League\OAuth2\Client\Token\AccessToken;

class Provider extends MonzoProvider {
    protected $baseAuthorizationUrl;
    protected $baseUrl;

    public function getBaseAuthorizationUrl() {
        return $this->baseAuthorizationUrl;
    }

    public function getBaseUrl() {
        return $this->baseUrl;
    }

    protected function getApiUrl($url, array $query = []) {
        return $this->appendQuery($this->getBaseUrl() . $url, $this->buildQueryString($query));
    }

    public function getAccounts(AccessToken $token, $type = null) {
        $query = [];
        if ($type) { $query['account_type'] = $type; }

        $request = $this->getAuthenticatedRequest(self::METHOD_GET, $this->getApiUrl('/accounts', $query), $token);
        $response = $this->getResponse($request);
        return $response['accounts'];
    }

    public function getTransactions(AccessToken $token, $accountId, \DateTimeInterface $since = null, \DateTimeInterface $before = null) {
        $query = ['account_id' => $accountId, 'expand[]' => 'merchant'];
        if ($since) { $query['since'] = $since->format('c'); }
        if ($before) { $query['before'] = $before->format('c'); }

        $request = $this->getAuthenticatedRequest(self::METHOD_GET, $this->getApiUrl('/transactions', $query), $token);
        $response = $this->getResponse($request);
        return $response['transactions'];
    }

    public function registerAttachment(AccessToken $token, $transactionId, $fileUrl, $fileType) {
        $options = [
            'headers' => ['content-type' => 'application/x-www-form-urlencoded'],
            'body' => $this->buildQueryString([
                'external_id' => $transactionId,
                'file_url'    => $fileUrl,
                'file_type'   => $fileType,
            ]),
        ];

        $request = $this->getAuthenticatedRequest(self::METHOD_POST, $this->getApiUrl('/attachment/register'), $token, $options);
        return $this->getResponse($request);
    }
}
