<?php

namespace App\Search;

final class BookSearchCriteria
{
    public function __construct(
        public ?string $q = null,
        public ?string $author = null,
        public bool $available = false,
    )
    {
    }
}
