@extends('layouts.app')

@section('titulo', 'Editar veículo')

@section('conteudo')
    <h1 class="h3 mb-4">Editar veículo <span class="placa ms-2">{{ $veiculo->placa_formatada }}</span></h1>

    <form action="{{ route('veiculos.update', $veiculo) }}" method="POST" class="painel" novalidate>
        @csrf
        @method('PUT')
        @include('veiculos._form')

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary">Salvar alterações</button>
            <a href="{{ route('veiculos.index') }}" class="btn btn-link">Cancelar</a>
        </div>
    </form>
@endsection
