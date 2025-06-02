<?php

namespace Laratoor\Models;

use JsonSerializable;

class Placement implements JsonSerializable
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getNumber(): int
    {
        return $this->data['number'];
    }

    public function getParticipantId(): ?string
    {
        return $this->data['participant_id'] ?? null;
    }

    public function isLocked(): ?bool
    {
        return $this->data['locked'] ?? null;
    }

    public function toArray(): array
    {
        return $this->data;
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}