<?php

namespace App\Repositories; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\Repositories\RepositoryInterface;

abstract class Repository implements RepositoryInterface 
{
    protected abstract function getModel();

    public function create(array $data): Model
    {
        return $this->getModel()->create($data);
    }

    public function find(int $id): Model
    {
        return $this->getModel()->find($id);
    }

    public function all(): Collection
    {
        return $this->getModel()->all();
    }

    public function update(int $id, array $data): Bool
    {
        return $this->getModel()->find($id)->update($data);
    }

    public function delete(int $id): Bool
    {
        return $this->getModel()->find($id)->delete();
    }
}