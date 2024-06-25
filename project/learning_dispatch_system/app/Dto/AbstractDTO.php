<?php

namespace App\Dto;

class AbstractDTO
{
    public function setFieldEach(array $setParams): void
    {
        if($setParams === []) return;
        
        $self = app()->make(static::class);

        $reflection = new \ReflectionClass($self);
        $properties = $reflection->getProperties(\ReflectionProperty::IS_PROTECTED);

        $fieldNames = array_map(fn(\ReflectionProperty $p) => $p->name, $properties);

        foreach($fieldNames as $fieldName){
            if(isset($setParams[$fieldName]) === false){
                continue;
            }

            $this->$fieldName = $setParams[$fieldName];
        }
    }
}