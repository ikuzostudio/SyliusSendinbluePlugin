<?php

declare(strict_types=1);

namespace Ikuzo\SyliusSendinbluePlugin\EventSubscriber;

use Doctrine\ORM\EntityManagerInterface;
use Ikuzo\SyliusSendinbluePlugin\Message\SendContactToSendinblue;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Customer\Model\CustomerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Messenger\MessageBusInterface;

class CustomerSubscriber implements EventSubscriberInterface
{
    public function __construct(private EntityManagerInterface $em, private MessageBusInterface $bus, private ChannelContextInterface $channelContext)
    {
    }

    public function onCustomerPreUpdate(GenericEvent $event)
    {
        if(!$this->channelContext->getChannel()->getIsSendinblueActive() || $this->channelContext->getChannel()->getSendinblueApiKey() == '') {
            return;
        }
        
        if ($event->getSubject() instanceof CustomerInterface) {
            $customer = $event->getSubject();
            $uow = $this->em->getUnitOfWork();
            $uow->computeChangeSets();
            $changeset = $uow->getEntityChangeSet($customer);

            if(in_array('subscribedToNewsletter', array_keys($changeset))) {
                if($changeset['subscribedToNewsletter'][1] == true) {
                    $this->bus->dispatch(new SendContactToSendinblue($customer->getId(), 'POST'));
                } else {
                    $this->bus->dispatch(new SendContactToSendinblue($customer->getId(), 'DELETE'));
                }
            }
        }
    }

    public function onCustomerPostRegister(GenericEvent $event)
    {
        if(!$this->channelContext->getChannel()->getIsSendinblueActive() || $this->channelContext->getChannel()->getSendinblueApiKey() == '') {
            return;
        }

        if ($event->getSubject() instanceof CustomerInterface) {
            $customer = $event->getSubject();
            if($customer->getSubscribedToNewsletter()) {
                $this->bus->dispatch(new SendContactToSendinblue($customer->getId(), 'POST'));
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'sylius.customer.pre_update' => 'onCustomerPreUpdate',
            'sylius.customer.post_register' => 'onCustomerPostRegister',
        ];
    }
}
