<?php

namespace App\Repositories;

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
        $user = parent::create($data);
        $user->profile()->create($data);
        return $user;
    }

    public function findByEmail(string $email)
    {
         return $this->getModel()->where('email', $email)->first();
    }

    public function notify(int $id, string $class): UserRepositoryInterface
    {
        $this->find($id)->notify(resolve($class));
        return $this;
    }

    public function name(int $id): String
    {
        return $this->find($id)->profile->name;
    }

   public function markEmailAsVerified(int $id): Bool
   {
        return $this->find($id)->markEmailAsVerified();
   }

   public function loginSocial($data): User
   {
        $user = $this->findByEmail($data->getEmail());
        return $user ? $user : $this->createSocial($data);
   }

   protected function createSocial($data): User
   {
        $name = explode(' ', $data->getName());
        return $this->create([
            'email' => $data->getEmail(),
            'password' => Str::random(10),
            'first_name' => $name[0],
            'last_name' => $name[1],
            'avatar' => $data->getAvatar()
        ]);
   }

   public function sendResetPassword(string $email, string $token): Void
   {
        $this->findByEmail($email)->sendPasswordResetNotification($token);
   }

   public function resetPassword(string $email, string $password): Bool
   {
        return $this->findByEmail($email)->update(['password' => $password]);
   }
}
