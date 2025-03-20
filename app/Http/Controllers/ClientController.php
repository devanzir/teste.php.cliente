<?php
namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Services\ClientService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;


class ClientController extends Controller
{

    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }
    
    public function index()
    {
        $clients = Client::paginate(10);
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:clients',
            'cpf' => 'required|string|max:14|unique:clients',
            'contract_attachment' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

       # dd('Validação bem-sucedida!');
         
        $filePath = $request->file('contract_attachment')->store('contracts');
        #dd('Caminho do arquivo:', $filePath);

        Client::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'contract_attachment' => $filePath,
            
        ]);
        #dd('Cliente salvo com sucesso!');

        #Client::create($request->all());
        return redirect()->route('clients.index')->with('success', 'Cliente criado com sucesso!');
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:clients,email,'.$client->id,
            'cpf' => 'required|string|max:14|unique:clients,cpf,'.$client->id,
            'contract_attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);
    
        // Atualiza os dados do cliente
        $client->update($request->except('contract_attachment'));
    
       
        if ($request->hasFile('contract_attachment')) {
            $filePath = $request->file('contract_attachment')->store('contracts');
            $client->update(['contract_attachment' => $filePath]);
        }
    
        return redirect()->route('clients.index')->with('success', 'Cliente atualizado com sucesso!');
    }
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Cliente excluído com sucesso!');
    }
}