<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

abstract class BaseRepository
{
    abstract protected function readConnection(): Builder;
    abstract protected function writeConnection(): Builder;
}