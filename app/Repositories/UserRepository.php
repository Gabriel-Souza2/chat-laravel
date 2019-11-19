<?php

namespace App\Repositories; 

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
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

    public function createToken(string $type): UserRepositoryInterface
    {
        $this->getModel()->verificationToken()->create([
            'token' => Str::random(60),
            'exp' => Carbon::now()->addHours(),
            'type' => $type,
        ]);

        return $this;
    }

    public function notify(string $class): UserRepositoryInterface
    {
        $this->getModel()->notify(new $class($this));
        return $this;
    }

    public function getToken(string $type): String
    {
        return $this->getModel()
                ->verificationToken()
                ->where('type', $type)
                ->first()
                ->token;
    }

    public function name(): String
    {
        return $this->getModel()->profile->name;
    }
}