<?php

namespace App\Http\Query;
use Illuminate\Support\Collection;

class Query {

    private static $types = [
        'gt' => '>', 
        'gte' => '>=', 
        'lt' => '<', 
        'lte' => '<=', 
        'eq' => '=', 
        'ne' => '<>',
    ];

    public static function filtering(array $filters, array $requestQuery, Collection $collection)
    {
        foreach ($requestQuery as $input => $value) {
            /// Check if column is allow for filtering
            if (in_array($input, array_keys($filters))) {
                $input = str($input)->snake()->value();

                /// Check If request query is array, If yes then check for operator exist in filters
                /// $filters[$input] gives All the allowed operator
                /// Since $value is array, Its key is operator and value is input value
                if (is_array($value) and in_array(key($value), $filters[$input])) {
                    $key = key($value);
                    $collection = $collection->where($input, self::$types[$key], $value[$key]);
                } else {            
                    $collection = $collection->where($input, '=', $value);
                }
            }
        }
        return $collection;
    }
    
}

