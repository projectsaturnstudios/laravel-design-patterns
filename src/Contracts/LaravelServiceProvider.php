<?php

namespace ProjectSaturnStudios\LaravelDesignPatterns\Contracts;

interface LaravelServiceProvider
{
    public function register(): void;
    public function boot(): void;
}
