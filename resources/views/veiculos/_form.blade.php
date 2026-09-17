@php($situacaoAtual = old('status', $veiculo->status ?? 'ativo'))

<div class="row g-3">
    <div class="col-sm-4">
        <label for="placa" class="form-label">Placa</label>
        <input type="text" id="placa" name="placa" maxlength="8" required autofocus
               value="{{ old('placa', $veiculo->placa) }}" placeholder="ABC1D23"
               class="form-control text-uppercase @error('placa') is-invalid @enderror">
        @error('placa')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-text">Padrão antigo ou Mercosul.</div>
    </div>

    <div class="col-sm-8">
        <label for="modelo" class="form-label">Modelo</label>
        <input type="text" id="modelo" name="modelo" maxlength="80" required
               value="{{ old('modelo', $veiculo->modelo) }}" placeholder="VW Constellation 17.280 compactador"
               class="form-control @error('modelo') is-invalid @enderror">
        @error('modelo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-4">
        <label for="capacidade_kg" class="form-label">Capacidade de carga (kg)</label>
        <input type="number" id="capacidade_kg" name="capacidade_kg" min="500" max="30000" step="1" required
               value="{{ old('capacidade_kg', $veiculo->capacidade_kg) }}"
               class="form-control @error('capacidade_kg') is-invalid @enderror">
        @error('capacidade_kg')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-sm-8">
        <label for="status" class="form-label">Situação</label>
        <select id="status" name="status" required class="form-select @error('status') is-invalid @enderror">
            @foreach (\App\Models\Veiculo::STATUS as $valor => $rotulo)
                <option value="{{ $valor }}" @selected($situacaoAtual === $valor)>{{ $rotulo }}</option>
            @endforeach
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
