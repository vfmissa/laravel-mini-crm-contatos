<?php

namespace App\Domain\Contact\Events;

interface EventDispatcherInterface
{
    public function dispatch(object $event): void;
}