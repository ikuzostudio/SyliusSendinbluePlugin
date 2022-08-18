<?php

declare(strict_types=1);

namespace Tests\Ikuzo\SyliusSendinbluePlugin\Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ikuzo\SyliusSendinbluePlugin\Model\SendinblueChannelInterface;
use Ikuzo\SyliusSendinbluePlugin\Model\SendinblueChannelTrait;
use Sylius\Component\Core\Model\Channel as BaseChannel;

/**
 * @ORM\Table(name="sylius_channel")
 * @ORM\Entity()
 */
class Channel extends BaseChannel implements SendinblueChannelInterface
{
    use SendinblueChannelTrait;
}