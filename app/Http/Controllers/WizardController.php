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

        return view('wizard.step2'); // 
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

    // Verifica se os dados do usuário estão presentes
    if (!$user || !isset($user['id'])) {
        return redirect()->route('register')->withErrors(['message' => 'Dados do usuário não encontrados.']);
    }

    // Atualizar o status do usuário para 'completed'
    User::where('id', $user['id'])->update(['status' => 'completed']);

    // Limpar dados da sessão se necessário
    session()->forget('dados_pessoais');
    session()->forget('endereco');

    return redirect()->route('login')->with('success', 'Cadastro realizado com sucesso! Você pode fazer login agora.');
}
}