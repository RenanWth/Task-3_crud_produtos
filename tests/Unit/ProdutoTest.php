<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Produto;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProdutoTest extends TestCase
{
      /**
     * @test
     * @testdox Tenta criar um produto na memória (sem salvar no banco)
     */
    public function test_criar_produto_em_memoria() 
    {
        $produto = new Produto(['nome' => 'Café', 'preco' => 10.5]);
        $this->assertEquals('Café', $produto->nome);
    }

     /**
     * @test
     * @testdox Verifica se o preço pode ser salvo como float
     */
    public function test_preco_do_produto() 
    {
        $produto = new Produto(['preco' => 5.99]);
        $this->assertIsFloat($produto->preco);
    }

     /**
     * @test
     * @testdox Testa se o preço do produto salvo pode ser zero
     */
    public function test_valor_zero_e_valido() 
    {
        $produto = new Produto(['preco' => 0]);
        $this->assertEquals(0, $produto->preco);
    }

     /**
     * @test
     * @testdox Testa se o nome do produto é um string com (assertIsString)
     */
    public function test_nome_e_string() 
    {
        $produto = new Produto(['nome' => 'Leite']);
        $this->assertIsString($produto->nome);
    }
}
