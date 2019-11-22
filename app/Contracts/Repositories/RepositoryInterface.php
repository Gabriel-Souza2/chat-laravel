<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface RepositoryInterface {

    function create(array $data): Model;

    function find(int $id): Model;

    function all(): Collection;

    function update(int $id, array $data): Bool;

    function delete(int $id): Bool;
}
