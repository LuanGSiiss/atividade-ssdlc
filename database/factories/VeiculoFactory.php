<?php

namespace Database\Factories;

use App\Models\Veiculo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Veiculo>
 */
class VeiculoFactory extends Factory
{
    protected $model = Veiculo::class;

    public function definition(): array
    {
        return [
            'placa' => fake()->unique()->regexify('[A-Z]{3}[0-9][A-Z][0-9]{2}'),
            'modelo' => fake()->randomElement([
                'VW Constellation 17.280 compactador',
                'Mercedes-Benz Atego 1719 compactador',
                'Ford Cargo 1119 basculante',
            ]),
            'capacidade_kg' => fake()->numberBetween(4000, 15000),
            'status' => 'ativo',
        ];
    }
}
