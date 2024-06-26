<?php
 
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

/**
 * 基本的にModelとRepositoryは一対一で作成
 *
 */
abstract class AbstractRepository
{
    protected ?object $model;
 
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

    public function tableName(): string
    {
        return $this->model->getTable();
    }

    public function find(string|int $findByVal): ?Model
    {
        return $this->model->find($findByVal);
    }

    public function allHardDelete(): int
    {
        $tableName = $this->tableName();

        return DB::table($tableName)->delete();
    }

    public function factories(?int $num = null, array $override = []): Collection
    {
        if($override === []){
            return $this->model->factory($num)->create();
        }
        else{
            return $this->model->factory($num)->create($override);
        }
        
    }
}