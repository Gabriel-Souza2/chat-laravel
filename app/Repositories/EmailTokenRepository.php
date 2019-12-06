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

    public function createToken(int $id): Model
    {
        return $this->getModel()->create([
            'token' => Str::random(60),
            'user_id' => $id,
            'exp' => now()->addHours()
        ]);
    }

    public function getToken(int $id): String
    {
        return $this->getModel()->where('user_id', $id)->first()->token;
    }

    public function validate(string $token, int $id): Bool
    {
        $token = $this->getModel()
            ->where('token', $token)
            ->where('user_id', $id)
            ->where('exp', '>=', now())
            ->first();

        return $token ? $token->delete() : false;
    }
}
