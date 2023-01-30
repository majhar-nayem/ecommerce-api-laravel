<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_input_form_validation()
    {
        $response = $this->postJson('v1/user/register');

        $response->assertStatus(422)
            ->assertJsonValidationErrorFor('phone');
    }

    public function test_user_can_register_with_minimal_details()
    {
        $response = $this->post('v1/user/register', [
            'phone' => '01911131345'
        ]);

        $response->assertStatus(201)->assertJson([
            'phone' => '01911131345'
        ]);
    }

    public function test_register_with_full_details()
    {
        $request_data = [
            'phone' => '01911131345',
            'name' => 'Majharul Islam',
            'email' => 'majharul.nayem042@gmail.com',
            'street' => 'Uttara',
            'state' => 'dhaka',
            'zipcode' => 1230,
            'country' => 'Bangladesh',
        ];
        $response = $this->postJson('v1/user/register', array_merge($request_data, ['password' => '123456']));

        $response->assertStatus(201)
            ->assertJsonFragment($request_data)
            ->assertJsonMissing(['password']);
    }

    public function test_password_is_saved_in_hashed_format()
    {
        $request_data = [
            'phone' => '01911131345',
            'password' => '123456'
        ];
        $this->post('v1/user/register', $request_data);
        $user = User::query()->where('phone', $request_data['phone'])->first();
        $this->assertNotEquals($request_data['password'], $user->password);
        $this->assertTrue(Hash::check($request_data['password'], $user->password));
        $this->assertFalse(Hash::check('78234', $user->password));
    }
}
