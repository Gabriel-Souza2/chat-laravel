<?php

namespace App\Contracts\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface
{
    function name(int $id): String;
    function notify(int $id, string $class): UserRepositoryInterface;
    function markEmailAsVerified(int $id): Bool;
    function loginSocial($data): User;
    function findByEmail(string $email);
    function sendResetPassword(string $email, string $token): Void;
    function resetPassword(string $email, string $password): Bool;
}
