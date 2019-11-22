<?php

namespace App\Repositories; 

use App\Models\EmailToken;
use Illuminate\Support\Str;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Middleware\CheckTokenInterface;
use App\Contracts\Repositories\EmailTokenRepositoryInterface;

class EmailTokenRepository extends Repository implements 
                                            EmailTokenRepositoryInterface,
                                            CheckTokenInterface
{
    protected $model;

    public function __construct(EmailToken $emailToken)
    {
        $this->model = $emailToken;
    }

    protected function getModel()
    {
        return $this->model;
    }

    public function createToken(Int $id): Model
    {
        return $this->getModel()->create(['token' => Str::random(60), 'user_id' => $id]);
    }

    public function getToken(Int $id): String
    {
        return $this->getModel()->where('user_id', $id)->first()->token;
    }

    public function validate(String $token, Int $id): Bool
    {
        $token = $this->getModel()
            ->where('token', $token)
            ->where('user_id', $id)
            ->where('created_at', '<=', now()->addHours()->toDateTimeString());

        return $token ? true : false; 
    }
}