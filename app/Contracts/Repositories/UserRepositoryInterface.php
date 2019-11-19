<?php

namespace App\Contracts\Repositories;

interface UserRepositoryInterface {
    function createToken(string $type): UserRepositoryInterface;
    function notify(string $class): UserRepositoryInterface;
    function getToken(string $type): String;
    function name(): String; 
}