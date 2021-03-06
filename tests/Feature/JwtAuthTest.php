<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JwtAuthTest extends TestCase
{


    public function testRegister() {

        $data = [
            'email' => 'test@gmail.com',
            'name' => 'ta',
            'password' => 'secret1234'
        ];



//        var_dump($response->json()["message"]);

        $response = $this->json('POST', route('auth.register'), $data);

        $response->assertStatus(201);

        $this->assertArrayHasKey('user', $response->json());

        User::where('email', 'test@gmail.com')->delete();
        //wrong way

    }

    public function testWrongRegister() {

        $data = [
            'email' => 'test@gmail.com',
            'name' => 't',
            'password' => 'secret1234'
        ];
        $response = $this->json('POST', route('auth.register'), $data);

//        var_dump($response->json()["message"]);


        $response->assertStatus(422);
    }


    public function testLogin()
    {
        User::create([
            'name' => 'test',
            'email'=>'test@gmail.com',
            'password' => bcrypt('secret1234')
        ]);

        $response = $this->json('POST',route('auth.login'),[
            'email' => 'test@gmail.com',
            'password' => 'secret1234',
        ]);

        $response->assertStatus(200);
        $this->assertArrayHasKey('access_token',$response->json());

        User::where('email','test@gmail.com')->delete();
    }

}
