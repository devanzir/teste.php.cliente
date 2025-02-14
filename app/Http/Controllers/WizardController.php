<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class WizardController extends Controller
{
    public function step2(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'cep' => 'required',
                'rua' => 'required|string|max:255',
                'cidade' => 'required|string|max:255',
                'estado' => 'required|string|max:2',
            ]);

            // Armazenar endereço na sessão
            session(['endereco' => $request->only('cep', 'rua', 'cidade', 'estado')]);

            return redirect()->route('wizard.confirm');
        }

        return view('wizard.step2'); // Certifique-se de ter essa view
    }

    public function confirm()
    {
        $dados = session('dados_pessoais');
        $endereco = session('endereco');

        if (!$dados || !$endereco) {
            return redirect()->route('register')->withErrors(['message' => 'Dados não encontrados.']);
        }

        return view('wizard.confirm', compact('dados', 'endereco'));
    }

    public function submit()
    {
        $user = session('dados_pessoais');
        // Atualizar o status do usuário para 'completed'
        User::where('id', $user->id)->update(['status' => 'completed']);

        return redirect()->route('login')->with('success', 'Cadastro realizado com sucesso! Você pode fazer login agora.');
    }
}