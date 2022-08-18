<?php

namespace Ikuzo\SyliusSendinbluePlugin\MessageHandler;

use Ikuzo\SyliusSendinbluePlugin\Message\SendContactToSendinblue;
use Ikuzo\SyliusSendinbluePlugin\Services\SendinblueService;
use Sylius\Component\Core\Repository\CustomerRepositoryInterface;
use Sylius\Component\Customer\Model\CustomerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SendContactToSendinblueHandler implements MessageHandlerInterface
{
    private CustomerRepositoryInterface $customerRepository;
    private SendinblueService $webservice;

    public function __construct(CustomerRepositoryInterface $customerRepository, SendinblueService $webservice)
    {
        $this->customerRepository = $customerRepository;
        $this->webservice = $webservice;
    }

    public function __invoke(SendContactToSendinblue $message)
    {
        $customer = $this->customerRepository->find($message->getCustomerId());
        $method = $message->getMethod();
        if($customer instanceof CustomerInterface) {
            switch($method) {
                case 'POST':
                    $this->webservice->postContact($customer);
                    break;
                case 'DELETE':
                    $this->webservice->deleteContact($customer);
                    break;
                default:
                    break;
            }
        }
    }
}