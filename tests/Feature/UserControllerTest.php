<?php

namespace Tests\Unit;

use App\Http\Controllers\UserController;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Mockery;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_view_user_information()
    {
        $user = User::factory()->create();

        Auth::login($user);

        $controller = new UserController();
        $response = $controller->view();
        $this->assertInstanceOf(View::class, $response);
    }

    /** @test */
    public function it_can_update_user_information()
    {
        $user = User::factory()->create();

        $updatedData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ];

        $requestMock = Mockery::mock(UpdateUserProfileRequest::class);
        $requestMock->shouldReceive('validated')->andReturn($updatedData);
        $requestMock->shouldReceive('filled')->andReturn(false);

        $controller = new UserController();
        $response = $controller->update($requestMock, $user->id);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('home', ['page' => 1]), $response->headers->get('Location'));

        $user->refresh();

        $this->assertEquals($updatedData['name'], $user->name);
        $this->assertEquals($updatedData['email'], $user->email);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
