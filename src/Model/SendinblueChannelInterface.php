<?php

declare(strict_types=1);

namespace Ikuzo\SyliusSendinbluePlugin\Model;

interface SendinblueChannelInterface {
    public function getIsSendinblueActive(): bool;
    public function setIsSendinblueActive(bool $input): void;
    public function setSendinblueApiKey(?string $input): void;
    public function getSendinblueApiKey(): ?string;
    public function setSendinblueListId(?string $input): void;
    public function getSendinblueListId(): ?string;
}