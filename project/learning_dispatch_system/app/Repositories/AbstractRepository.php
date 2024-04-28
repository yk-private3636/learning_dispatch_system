<?php
 
namespace App\Repository;
 
/**
 * 基本的にModelとRepositoryは一対一で作成
 *
 */
abstract class AbstractRepository
{
    protected $model;
 
    abstract public function getModelClass(): string;
 
    public function __construct(?object $model = null)
    {
        if(is_null($model)){
            $this->model = app()->make($this->getModelClass());
        }
        else{
            $this->model = $model;
        }
    }
}