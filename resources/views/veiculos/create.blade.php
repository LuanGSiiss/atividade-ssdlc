@extends('layouts.app')

@section('titulo', 'Cadastrar veículo')

@section('conteudo')
    <h1 class="h3 mb-4">Cadastrar veículo</h1>

    <form action="{{ route('veiculos.store') }}" method="POST" class="painel" novalidate>
        @csrf
        @include('veiculos._form')

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary">Salvar veículo</button>
            <a href="{{ route('veiculos.index') }}" class="btn btn-link">Cancelar</a>
        </div>
    </form>
@endsection
