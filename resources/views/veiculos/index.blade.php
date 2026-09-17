@extends('layouts.app')

@section('titulo', 'Veículos')

@section('conteudo')
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Veículos da coleta</h1>
            <p class="text-secondary mb-0">
                {{ $veiculos->total() }} {{ $veiculos->total() === 1 ? 'veículo cadastrado' : 'veículos cadastrados' }}
            </p>
        </div>
        <a href="{{ route('veiculos.create') }}" class="btn btn-primary">Cadastrar veículo</a>
    </div>

    @if ($veiculos->isEmpty())
        <div class="vazio">
            <p class="fs-5 mb-1">Nenhum veículo cadastrado</p>
            <p class="text-secondary">Cadastre os caminhões da frota para acompanhar a situação de cada um.</p>
            <a href="{{ route('veiculos.create') }}" class="btn btn-outline-primary">Cadastrar o primeiro veículo</a>
        </div>
    @else
        <div class="table-responsive">
            <table class="table align-middle border">
                <thead>
                <tr>
                    <th scope="col">Placa</th>
                    <th scope="col">Modelo</th>
                    <th scope="col" class="text-end">Capacidade</th>
                    <th scope="col">Situação</th>
                    <th scope="col" class="text-end">Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($veiculos as $veiculo)
                    <tr>
                        <td><span class="placa">{{ $veiculo->placa_formatada }}</span></td>
                        <td>{{ $veiculo->modelo }}</td>
                        <td class="text-end">{{ number_format($veiculo->capacidade_kg, 0, ',', '.') }} kg</td>
                        <td><span class="status status-{{ $veiculo->status }}">{{ $veiculo->status_label }}</span></td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('veiculos.edit', $veiculo) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                            <form action="{{ route('veiculos.destroy', $veiculo) }}" method="POST" class="d-inline"
                                  data-confirmar="Excluir o veículo {{ $veiculo->placa_formatada }}?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{ $veiculos->links('pagination::bootstrap-5') }}
    @endif
@endsection
