<?php

namespace App\Http\Controllers;

use App\Http\Requests\VeiculoRequest;
use App\Models\Veiculo;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VeiculoController extends Controller
{
    /** US-02 */
    public function index(): View
    {
        $veiculos = Veiculo::orderBy('placa')->paginate(15);

        return view('veiculos.index', compact('veiculos'));
    }

    public function create(): View
    {
        return view('veiculos.create', ['veiculo' => new Veiculo()]);
    }

    /** US-01 */
    public function store(VeiculoRequest $request): RedirectResponse
    {
        Veiculo::create($request->validated());

        return redirect()
            ->route('veiculos.index')
            ->with('sucesso', 'Veículo cadastrado.');
    }

    public function edit(Veiculo $veiculo): View
    {
        return view('veiculos.edit', compact('veiculo'));
    }

    /** US-03 */
    public function update(VeiculoRequest $request, Veiculo $veiculo): RedirectResponse
    {
        $veiculo->update($request->validated());

        return redirect()
            ->route('veiculos.index')
            ->with('sucesso', 'Alterações salvas.');
    }

    /** US-04 */
    public function destroy(Veiculo $veiculo): RedirectResponse
    {
        $veiculo->delete();

        return redirect()
            ->route('veiculos.index')
            ->with('sucesso', 'Veículo excluído.');
    }
}
