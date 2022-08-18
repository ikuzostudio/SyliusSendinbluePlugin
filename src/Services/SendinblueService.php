<?php

declare(strict_types=1);

namespace Ikuzo\SyliusSendinbluePlugin\Services;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Customer\Model\CustomerInterface;

class SendinblueService
{
    const API_URL = 'https://api.sendinblue.com/v3';

    public function __construct(private ClientInterface $client, private ChannelContextInterface $channelContext)
    {
    }

    public function postContact(CustomerInterface $customer): bool
    {
        $method = 'POST';
        $endpoint = '/contacts';

        $header = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'api-key' => $this->getApiKey()
        ];

        $body = [
            'email' => $customer->getEmail(),
            'attributes' => [
                'PRENOM' => $customer->getFirstName(),
                'NOM' => $customer->getLastName(),
            ],
            'listIds' => $this->getListIds()
        ];

        $customerPhoneNumber = trim(str_replace(' ', '', $customer->getPhoneNumber()));

        if (preg_match('/^\+\d|00/', $customerPhoneNumber)) {
            $body['attributes']['SMS'] = $customerPhoneNumber;
        }

        $params = [
            'headers' => $header,
            'json' => $body
        ];

        try {
            $this->sendRequest($method, $endpoint, $params);
        } catch (\Exception $ex) {
            return false;
        } catch (\Throwable $ex) {
            return false;
        }
        return true;
    }

    public function deleteContact(CustomerInterface $customer)
    {
        $method = 'DELETE';
        $endpoint = '/contacts/' . $customer->getEmail();
        $header = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'api-key' => $this->getApiKey()
        ];
        $body = [];

        $params = [
            'headers' => $header,
            'json' => $body
        ];

        try {
            $this->sendRequest($method, $endpoint, $params);
        } catch (\Exception $ex) {
            return false;
        } catch (\Throwable $ex) {
            return false;
        }
        return true;
    }

    private function sendRequest($method, $endpoint, $params): array
    {
        $res = $this->client->request($method, self::API_URL . $endpoint, $params);
        $response = json_decode((string) $res->getBody());

        $this->handleResponse($res);

        return $response;
    }

    private function handleResponse(ResponseInterface $response): void
    {
        $statsuCode = $response->getStatusCode();
        switch($statsuCode) {
        }
    }

    private function getListIds(): array
    {
        return [(int) $this->channelContext->getChannel()->getSendinblueListId()];
    }

    private function getApiKey(): string
    {
        return $this->channelContext->getChannel()->getSendinblueApiKey() ?? 'missing_key';
    }
}