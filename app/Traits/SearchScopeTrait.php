<?php
namespace App\Traits;

use Illuminate\Contracts\Database\Eloquent\Builder;

trait SearchScopeTrait {

    public function scopeSearch(Builder $query, string $keyword, array $columns = [], array $relativeTables = []): Builder
    {
        if (empty($columns)) {
            $columns = $this->getFillable();
        }   

        $query->where(function ($query) use ($keyword, $columns) {
            foreach ($columns as $key => $column) {
                $clause = $key == 0 ? 'where' : 'orWhere';
                $query->$clause($column, "LIKE", "%$keyword%");
                    
                if (!empty($relativeTables)) {
                    $this->filterByRelationship($query, $keyword, $relativeTables);
                }
            }
        });

        return $query;
    }

    private function filterByRelationship(Builder $query, string $keyword, array $relativeTables): Builder
    {
        foreach ($relativeTables as $relationship => $relativeColumns) {
            $query->orWhereHas($relationship, function($relationQuery) use ($keyword, $relativeColumns) {
                foreach ($relativeColumns as $key => $column) {
                    $clause = $key == 0 ? 'where' : 'orWhere';
                    $relationQuery->$clause($column, "LIKE", "%$keyword%");
                }
            });
        }

        return $query;
    }

    public function scopeSortOrder(Builder $query, array $fields = [], array $columns = []): Builder
    {
        if (empty($columns)) {
            $columns = $this->getFillable();
        }   

        $orders = ['asc', 'desc'];
        $orderFields = [];

        foreach ($fields as $key => $value) {
            if(in_array($key, $columns)) {
                $orderFields[$key] = in_array($value, $orders) ? $value : 'desc';
            }       
        }
        if(empty($orderFields)) {
            return $query->orderByDesc('created_at');
        }
        
        foreach($orderFields as $key => $value) {
            $query = $query->orderBy($key, $value);
        }

        return $query;
    }
}
