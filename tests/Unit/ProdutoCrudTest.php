<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Produto;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\Email;

class ProdutoCrudTest extends TestCase
{
    /**
     * @test
     * @testdox Testa se no banco existe um produto nome->"Queijo" preco->"12" salvo
     */
    public function test_produto_salvo_no_banco() {
        $this->post('/produtos', ['nome' => 'Queijo', 'preco' => 12.00]);
        $this->assertDatabaseHas('produtos', ['nome' => 'Queijo']);
    }

    /**
     * @test
     * @testdox Testa se é possível excluir um produto
     */
    public function test_excluir_produto() {
        // Criando um produto para excluir
        $produto = Produto::factory()->create();

        try {
            // Enviando o pedido de exclusão (DELETE)
            $response = $this->delete("/produtos/{$produto->id}");

            // Verificando se o produto foi realmente removido do banco
            $this->assertDatabaseMissing('produtos', ['id' => $produto->id]);
        } catch (\Exception $e) {
            $this->fail("Erro ao excluir produto: " . $e->getMessage());
        }
    }

      /**
     * @test
     * @testdox Testa se com login tem acesso ao formulario de criacao .create
     */
    public function test_acesso_formulario_criacao()
    {
        $user = User::first(); 
    
        $this->actingAs($user); // aqui autentica o usuario para chamar a rota
    
        $response = $this->get('/produtos/create');
        $response->assertStatus(200);
    }

    /**
     * @test
     * @testdox Testa a rota de listar produtos (com login)
     */
    public function test_listar_produtos()
    {
        $user = User::first();
        $this->actingAs($user);

        $response = $this->get('/produtos');
        $response->assertStatus(200);
    }

    /**
     * @test
     * @testdox Testa a rota de edicao de produto (com login)
     */
    public function test_acesso_formulario_edicao()
    {
        $user = User::first();
        $this->actingAs($user);

        $produto = Produto::factory()->create();

        $response = $this->get("/produtos/{$produto->id}/edit");
        $response->assertStatus(200);
    }

    /**
     * @test
     * @testdox Atualiza um produto para testar o update (put)
     */
    public function test_atualizar_produto()
    {
        $user = User::first();
        $this->actingAs($user);

        $produto = Produto::factory()->create([
            'nome' => 'TESTE',
            'preco' => 10.00,
        ]);

        $response = $this->put("/produtos/{$produto->id}", [
            'nome' => 'teste2',
            'preco' => 20.00,
        ]);

        $response->assertRedirect('/produtos');
        $this->assertDatabaseHas('produtos', ['nome' => 'Queijo']);
    }

    /**
     * @test
     * @testdox Testa a rota do pdf (com login)
     */
    public function test_rota_gerar_pdf_funciona()
    {
        $user = User::first();
        $this->actingAs($user);

        $response = $this->get('/produtos/pdf');

        $response->assertStatus(200);
    }

    /**
     * @test
     * @testdox Testa o conteudo retornado do /produtos/pdf (com login)
     */
    public function test_conteudo_pdf_retornado()
    {
        $user = User::first();
        $this->actingAs($user);

        $response = $this->get('/produtos/pdf');

        $response->assertHeader('content-type', 'application/pdf');
    }

}
