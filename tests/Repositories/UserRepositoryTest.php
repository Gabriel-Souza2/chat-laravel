<?php

namespace Tests\Repositories\Repository;

use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RepositoryTest extends TestCase
{    
    use RefreshDatabase;

    public $repository;
    
    public $user;

    protected function setUp(): void
    {
        parent::setUp();   
        $this->repository = resolve(UserRepository::class);  
        $this->user = \factory(user::class)->create();  
    }

    public function testCreate()
    {
        $data = ['email' => 'email@test.com', 'password' => 'password'];
        $profile = \factory(Profile::class)->make()->toArray();
        $user = $this->repository->create(array_merge($data, $profile));

        $this->assertInstanceOf(Model::class, $user);
        $this->assertDatabaseHas('users', ['email' => $data['email']]);
        $this->assertDatabaseHas('profiles', $profile);
    }
}
