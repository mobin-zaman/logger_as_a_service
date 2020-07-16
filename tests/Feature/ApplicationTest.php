<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApplicationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */




    public function testApplicationCreate() {

//
//        $response = $this->withHeader('Authorization' ,'Bearer '.$token)
//            ->json('post', route('applications.store'),[
//            'name' => 'test application',
//            'description' =>'test description'
//        ]);
        $user= factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->json('post', route('applications.store'),[
            'name' => 'test application',
            'description' =>'test description']);
//        var_dump($response->json());

        $response->assertStatus(201);

    }


    public function testApplicationCreateConflict() {
        $application = [
            'name' => 'test application',
            'description' =>'test description'
        ];

        $user= factory(User::class)->create();

        $response = $this->actingAs($user,'api')
        ->json('POST', route('applications.store'),$application);

        $response = $this->actingAs($user,'api')
            ->json('POST', route('applications.store'),$application);

        $response->assertStatus(409);

    }
//
    public function testApplicationCreateWithoutName() {
        $user= factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->json('post', route('applications.store'),[
                'description' =>'test description']);

        $response->assertStatus(422);

    }

}
