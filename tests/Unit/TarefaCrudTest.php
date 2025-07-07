<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Tarefa;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\Email;

class TarefaCrudTest extends TestCase
{
    /**
     * @test
     * @testdox Testa se no banco existe uma tarefa nome->"Estudar" estado->"pendente" salva
     */
    public function test_tarefa_salva_no_banco() {
        $this->post('/tarefas', ['nome' => 'Estudar', 'estado' => 'pendente']);
        $this->assertDatabaseHas('tarefas', ['nome' => 'Estudar']);
    }

    /**
     * @test
     * @testdox Testa se é possível excluir uma tarefa
     */
    public function test_excluir_tarefa() {
        $tarefa = Tarefa::factory()->create();
        try {
            $response = $this->delete("/tarefas/{$tarefa->id}");
            $this->assertDatabaseMissing('tarefas', ['id' => $tarefa->id]);
        } catch (\Exception $e) {
            $this->fail("Erro ao excluir tarefa: " . $e->getMessage());
        }
    }

    /**
     * @test
     * @testdox Testa se com login tem acesso ao formulario de criacao .create
     */
    public function test_acesso_formulario_criacao()
    {
        $user = User::first(); 
        $this->actingAs($user);
        $response = $this->get('/tarefas/create');
        $response->assertStatus(200);
    }

    /**
     * @test
     * @testdox Testa a rota de listar tarefas (com login)
     */
    public function test_listar_tarefas()
    {
        $user = User::first();
        $this->actingAs($user);
        $response = $this->get('/tarefas');
        $response->assertStatus(200);
    }

    /**
     * @test
     * @testdox Testa a rota de edicao de tarefa (com login)
     */
    public function test_acesso_formulario_edicao()
    {
        $user = User::first();
        $this->actingAs($user);
        $tarefa = Tarefa::factory()->create();
        $response = $this->get("/tarefas/{$tarefa->id}/edit");
        $response->assertStatus(200);
    }

    /**
     * @test
     * @testdox Atualiza uma tarefa para testar o update (put)
     */
    public function test_atualizar_tarefa()
    {
        $user = User::first();
        $this->actingAs($user);
        $tarefa = Tarefa::factory()->create([
            'nome' => 'TESTE',
            'estado' => 'pendente',
        ]);
        $response = $this->put("/tarefas/{$tarefa->id}", [
            'nome' => 'teste2',
            'estado' => 'concluida',
        ]);
        $response->assertRedirect('/tarefas');
        $this->assertDatabaseHas('tarefas', ['nome' => 'teste2', 'estado' => 'concluida']);
    }

    /**
     * @test
     * @testdox Testa a rota do pdf (com login)
     */
    public function test_rota_gerar_pdf_funciona()
    {
        $user = User::first();
        $this->actingAs($user);
        $response = $this->get('/tarefas/pdf');
        $response->assertStatus(200);
    }

    /**
     * @test
     * @testdox Testa o conteudo retornado do /tarefas/pdf (com login)
     */
    public function test_conteudo_pdf_retornado()
    {
        $user = User::first();
        $this->actingAs($user);
        $response = $this->get('/tarefas/pdf');
        $response->assertHeader('content-type', 'application/pdf');
    }
}
