<?php

namespace ProjectSaturnStudios\LaravelDesignPatterns\DataTransferObjects;

use ProjectSaturnStudios\PhpDesignPatterns\Contracts\DataTransferArchitecture;
use Spatie\LaravelData\Data;

class PublishableConfig extends Data implements DataTransferArchitecture
{
    public function __construct(
        public readonly string $key,
        public readonly string $file_path,
        public readonly array $groups = [],
    ) {}
}
