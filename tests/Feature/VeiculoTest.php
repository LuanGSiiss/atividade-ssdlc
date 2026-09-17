<?php

namespace Tests\Feature;

use App\Models\Veiculo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Cada teste comprova um critério de aceitação de specs/001-cadastro-veiculos/spec.md
 */
class VeiculoTest extends TestCase
{
    use RefreshDatabase;

    private function dadosValidos(array $sobrescrever = []): array
    {
        return array_merge([
            'placa' => 'abc-1d23',
            'modelo' => 'VW Constellation 17.280 compactador',
            'capacidade_kg' => 12000,
            'status' => 'ativo',
        ], $sobrescrever);
    }

    public function test_raiz_redireciona_para_a_lista(): void
    {
        $this->get('/')->assertRedirect(route('veiculos.index'));
    }

    public function test_ca01_cadastra_veiculo_com_dados_validos(): void
    {
        $this->post(route('veiculos.store'), $this->dadosValidos())
            ->assertRedirect(route('veiculos.index'))
            ->assertSessionHas('sucesso');

        $this->assertDatabaseHas('veiculos', [
            'placa' => 'ABC1D23',
            'capacidade_kg' => 12000,
            'status' => 'ativo',
        ]);
    }

    public function test_ca02_rejeita_placa_em_formato_invalido(): void
    {
        $this->post(route('veiculos.store'), $this->dadosValidos(['placa' => '12ABC34']))
            ->assertSessionHasErrors('placa');

        $this->assertDatabaseCount('veiculos', 0);
    }

    public function test_ca03_rejeita_placa_duplicada(): void
    {
        Veiculo::factory()->create(['placa' => 'ABC1234']);

        $this->post(route('veiculos.store'), $this->dadosValidos(['placa' => 'ABC-1234']))
            ->assertSessionHasErrors('placa');

        $this->assertDatabaseCount('veiculos', 1);
    }

    public function test_ca04_rejeita_capacidade_fora_da_faixa(): void
    {
        foreach ([499, 30001] as $capacidade) {
            $this->post(route('veiculos.store'), $this->dadosValidos(['capacidade_kg' => $capacidade]))
                ->assertSessionHasErrors('capacidade_kg');
        }

        $this->assertDatabaseCount('veiculos', 0);
    }

    public function test_ca05_rejeita_situacao_invalida(): void
    {
        $this->post(route('veiculos.store'), $this->dadosValidos(['status' => 'vendido']))
            ->assertSessionHasErrors('status');

        $this->assertDatabaseCount('veiculos', 0);
    }

    public function test_ca06_lista_veiculos_com_placa_formatada_e_situacao(): void
    {
        Veiculo::factory()->create(['placa' => 'ABC1234', 'status' => 'manutencao']);
        Veiculo::factory()->create(['placa' => 'BRA2E19', 'status' => 'ativo']);

        $this->get(route('veiculos.index'))
            ->assertOk()
            ->assertSee('ABC-1234')
            ->assertSee('BRA2E19')
            ->assertSee('Em manutenção')
            ->assertSee('Em operação');
    }

    public function test_ca07_lista_vazia_orienta_o_cadastro(): void
    {
        $this->get(route('veiculos.index'))
            ->assertOk()
            ->assertSee('Nenhum veículo cadastrado')
            ->assertSee('Cadastrar o primeiro veículo');
    }

    public function test_ca08_altera_situacao_mantendo_a_placa(): void
    {
        $veiculo = Veiculo::factory()->create(['placa' => 'ABC1D23', 'status' => 'ativo']);

        $this->put(route('veiculos.update', $veiculo), $this->dadosValidos([
            'placa' => 'ABC1D23',
            'status' => 'manutencao',
        ]))
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('veiculos.index'));

        $this->assertSame('manutencao', $veiculo->fresh()->status);
    }

    public function test_ca09_exclui_veiculo(): void
    {
        $veiculo = Veiculo::factory()->create();

        $this->delete(route('veiculos.destroy', $veiculo))
            ->assertRedirect(route('veiculos.index'));

        $this->assertModelMissing($veiculo);
    }

    public function test_ca10_health_check_e_versao(): void
    {
        $this->get('/up')->assertOk();

        $this->getJson(route('versao'))
            ->assertOk()
            ->assertJsonStructure(['aplicacao', 'versao']);
    }

    public function test_ca11_formularios_carregam(): void
    {
        $veiculo = Veiculo::factory()->create(['placa' => 'XYZ9876']);

        $this->get(route('veiculos.create'))
            ->assertOk()
            ->assertSee('Cadastrar veículo');

        $this->get(route('veiculos.edit', $veiculo))
            ->assertOk()
            ->assertSee('XYZ-9876')
            ->assertSee($veiculo->modelo);
    }
}
