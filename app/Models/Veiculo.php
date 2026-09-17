<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    /** @use HasFactory<\Database\Factories\VeiculoFactory> */
    use HasFactory;

    /** Situações permitidas (RN-04): valor gravado => rótulo exibido. */
    public const STATUS = [
        'ativo' => 'Em operação',
        'manutencao' => 'Em manutenção',
        'inativo' => 'Inativo',
    ];

    protected $table = 'veiculos';

    protected $fillable = ['placa', 'modelo', 'capacidade_kg', 'status'];

    protected function casts(): array
    {
        return ['capacidade_kg' => 'integer'];
    }

    /** Padrão antigo ganha hífen (ABC-1234); Mercosul fica como está (ABC1D23). */
    protected function placaFormatada(): Attribute
    {
        return Attribute::get(function (): string {
            $placa = (string) $this->placa;

            if (strlen($placa) === 7 && ctype_digit($placa[4])) {
                return substr($placa, 0, 3) . '-' . substr($placa, 3);
            }

            return $placa;
        });
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::get(
            fn (): string => self::STATUS[(string) $this->status] ?? (string) $this->status
        );
    }
}
