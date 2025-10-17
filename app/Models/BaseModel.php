<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function toArray(): array
    {
        //toCamelCase
        $array = parent::toArray();
        $camelCaseArray = [];
        foreach ($array as $key => $value) {
            $camelCaseKey = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));
            $camelCaseArray[$camelCaseKey] = $value;
        }
        return $camelCaseArray;
    }
}