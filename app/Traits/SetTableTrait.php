<?php
namespace App\Traits;

trait SetTableTrait {
    
    public function __construct(array $attributes = [])
    {
        $tableName = $this->getTable();
        $this->setTable(config("dbtables.{$tableName}", $tableName));
        parent::__construct($attributes);
    }
}
