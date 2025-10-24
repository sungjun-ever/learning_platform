<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected Model $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    protected function readConnection(): Builder
    {
        return $this->model->on('sqlite');
    }

    protected function writeConnection(): Builder
    {
        return $this->model->on('sqlite');
    }
}