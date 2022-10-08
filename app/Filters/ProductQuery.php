<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ProductQuery {
    protected $params = [
        'title' => ['eq', 'lk'],
        'category' => ['eq'],
        'brand' => ['eq', 'lk']
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lk' => 'like'
    ];

    public function transform (Request $request) {
        $eloQuery = [];
        
        foreach ($this->params as $parameter => $operators) {
            $query = $request->query($parameter);
            
            if (!isset($query))
                continue;
            
            foreach ($operators as $op) {
                if (isset($query[$op]))
                    $eloQuery[] = [$parameter, $this->operatorMap[$op], $query[$op]];
            }
        }
        return $eloQuery;
    }
}