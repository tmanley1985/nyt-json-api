<?php

declare(strict_types=1);

namespace App\DTOs;


class BestSellersOptions
{

    public function __construct(
        public ?string $isbn = null,
        public ?string $author = null,
        public ?string $title = null,
        public ?int $offset = null,
    ) {}

    public static function fromArray(array $options)
    {
        return new self(
            isbn: self::formatIsbn($options['isbn'] ?? null),
            author: $options['author'] ?? null,
            title: $options['title'] ?? null,
            offset: (int) $options['offset'] ?? null,
        );
    }

    private static function formatIsbn(mixed $isbn): ?string
    {
        return is_array($isbn) ? implode(';', $isbn) : $isbn;
    }

}
