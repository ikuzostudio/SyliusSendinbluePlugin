<?php

declare(strict_types=1);

namespace Ikuzo\SyliusSendinbluePlugin\Model;

use Doctrine\ORM\Mapping as ORM;

trait SendinblueChannelTrait
{
    /**
     * @ORM\Column(name="sendinblue_active", type="boolean")
     **/
    protected $isSendinblueActive = false;

    /**
     * @ORM\Column(name="sendinblue_api_key", type="string", length="255", nullable="true")
     **/
    protected $sendinblueApiKey = null;

    /**
     * @ORM\Column(name="sendinblue_list_id", type="string", length="255", nullable="true")
     **/
    protected $sendinblueListId = null;

    public function getIsSendinblueActive(): bool
    {
        return $this->isSendinblueActive;
    }

    public function setIsSendinblueActive(bool $isSendinblueActive): void
    {
        $this->isSendinblueActive = $isSendinblueActive;
    }

    public function setSendinblueApiKey(?string $sendinblueApiKey): void
    {
        $this->sendinblueApiKey = $sendinblueApiKey;
    }

    public function getSendinblueApiKey(): ?string
    {
        return $this->sendinblueApiKey;
    }

    public function setSendinblueListId(?string $sendinblueListId): void
    {
        $this->sendinblueListId = $sendinblueListId;
    }

    public function getSendinblueListId(): ?string
    {
        return $this->sendinblueListId;
    }
}
