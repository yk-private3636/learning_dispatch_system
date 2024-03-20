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
        $this->model = is_null($model) ? app()->make($this->getModelClass()) : $model;
    }
}