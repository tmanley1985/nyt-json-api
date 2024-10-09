<?php

declare(strict_types=1);

namespace App\ValueObjects;

use InvalidArgumentException;

final class CacheDuration
{
    private int $minutes;

    public function __construct(int $minutes)
    {
        if ($minutes < 0) {
            throw new InvalidArgumentException('Cache duration cannot be negative.');
        }
        $this->minutes = $minutes;
    }

    public static function fromMinutes(int $minutes)
    {
        return new self($minutes);
    }

    public function inMinutes(): int
    {
        return $this->minutes;
    }

    public function inSeconds(): int
    {
        return $this->minutes * 60;
    }
}
