<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Tarefa;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TarefaTest extends TestCase
{
    /**
     * @test
     * @testdox Tenta criar uma tarefa na memória (sem salvar no banco)
     */
    public function test_criar_tarefa_em_memoria() 
    {
        $tarefa = new Tarefa(['nome' => 'Estudar', 'estado' => 'pendente']);
        $this->assertEquals('Estudar', $tarefa->nome);
    }

    /**
     * @test
     * @testdox Verifica se o estado pode ser salvo corretamente
     */
    public function test_estado_da_tarefa() 
    {
        $tarefa = new Tarefa(['estado' => 'em andamento']);
        $this->assertEquals('em andamento', $tarefa->estado);
    }

    /**
     * @test
     * @testdox Testa se o nome da tarefa é uma string
     */
    public function test_nome_e_string() 
    {
        $tarefa = new Tarefa(['nome' => 'Ler livro']);
        $this->assertIsString($tarefa->nome);
    }
}
