<?php

namespace App\Events\Apply;

use Illuminate\Support\Collection;
use LaravelCode\EventSourcing\Contracts\ApplyEventInterface;
use LaravelCode\EventSourcing\Event\Apply\ApplyEvent;

class ItemWasDeleted extends ApplyEvent implements ApplyEventInterface
{
}
