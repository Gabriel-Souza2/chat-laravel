<?php

namespace App\Repositories; 

use App\Models\User;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Repositories\UserRepositoryInterface;

class UserRepository extends Repository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    protected function getModel()
    {
        return $this->model;
    }

    public function create(array $data): Model
    {
        $user = $this->getModel()->create($data);
        $user->profile()->create($data);
        return $user;
    }

    public function notify(Int $id, String $class): UserRepositoryInterface
    {
        $this->getModel()->find($id)->notify(resolve($class));
        return $this;
    }

    public function name(Int $id = null): String
    {
        return $this->getModel()->find($id)->profile->name;
    }

   public function markEmailAsVerified(Int $id): Bool
   {
        return $this->getModel()->find($id)->markEmailAsVerified();
   }
}