<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailTest extends TestCase
{
       /**
     * @test
     * @testdox Testa se tem acesso a rota da tela de verificação de email
      */  
      public function teste_tela_verificacao_email(): void
      {
          $user = User::factory()->create([
              'email_verified_at' => null,
          ]);

          $response = $this->actingAs($user)->get('/verify-email');

          $response->assertStatus(200);
      }

       /**
     * @test
     * @testdox Testa se o email pode ser verificado
      */  
      public function teste_verificacao_email(): void
      {
          $user = User::factory()->create([
              'email_verified_at' => null,
          ]);

          Event::fake();

          $verificationUrl = URL::temporarySignedRoute(
              'verification.verify',
              now()->addMinutes(60),
              ['id' => $user->id, 'hash' => sha1($user->email)]
          );

          $response = $this->actingAs($user)->get($verificationUrl);

          Event::assertDispatched(Verified::class);
          $this->assertTrue($user->fresh()->hasVerifiedEmail());
          $response->assertRedirect(RouteServiceProvider::HOME.'?verified=1');
      }

       /**
     * @test
     * @testdox Testa se o email não é verificado quando o hash é inválido
      */  
      public function testa_se_nao_verificado_por_hash_invalido(): void
      {
          $user = User::factory()->create([
              'email_verified_at' => null,
          ]);

          $verificationUrl = URL::temporarySignedRoute(
              'verification.verify',
              now()->addMinutes(60),
              ['id' => $user->id, 'hash' => sha1('wrong-email')]
          );

          $this->actingAs($user)->get($verificationUrl);

          $this->assertFalse($user->fresh()->hasVerifiedEmail());
      }
}
