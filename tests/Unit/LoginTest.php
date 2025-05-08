<?php

namespace Tests\Feature;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * @test
     * @testdox Testa se tem acesso a rota da tela de login
      */  
    public function testa_se_tem_acesso_a_tela_de_login(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * @test
     * @testdox Testa se a tela de login autentica
     */
    public function testa_autenticacao_tela_login(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    /**
     * @test
     * @testdox Testa se o sistema não autentica ao usar a senha errada
     */
    public function teste_se_nao_autentica_com_a_senha_errada(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    /**
     * @test
     * @testdox Testa se a ação de logout está funcionando
     */
    public function testa_se_consegue_fazer_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

     /**
     * @test
     * @testdox Testa se o registro de usuário está funcionando
     */
    public function testa_registro_funciona(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
