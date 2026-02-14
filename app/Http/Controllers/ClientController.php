<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Список всех клиентов
     * GET /clients
     */
    public function index()
    {
        $clients = Client::with('manager')
            ->latest()
            ->paginate(10);

        return view('clients.index', compact('clients'));
    }

    /**
     * Форма создания клиента
     * GET /clients/create
     */
    public function create()
    {
        $managers = User::role('manager')->orRole('admin')->get();

        return view('clients.create', compact('managers'));
    }

    /**
     * Сохранить нового клиента
     * POST /clients
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'nullable|email|max:255',
            'phone'      => 'nullable|string|max:50',
            'company'    => 'nullable|string|max:255',
            'notes'      => 'nullable|string',
            'manager_id' => 'required|exists:users,id',
        ]);

        Client::create($validated);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Клиент успешно создан!');
    }

    /**
     * Просмотр клиента
     * GET /clients/{client}
     */
    public function show(Client $client)
    {
        // Загружаем связанные данные
        $client->load([
            'manager',
            'deals' => function ($query) {
                $query->latest();
            }
        ]);

        return view('clients.show', compact('client'));
    }

    /**
     * Форма редактирования клиента
     * GET /clients/{client}/edit
     */
    public function edit(Client $client)
    {
        $managers = User::role('manager')->orRole('admin')->get();

        return view('clients.edit', compact('client', 'managers'));
    }

    /**
     * Обновить клиента
     * PUT /clients/{client}
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'nullable|email|max:255',
            'phone'      => 'nullable|string|max:50',
            'company'    => 'nullable|string|max:255',
            'notes'      => 'nullable|string',
            'manager_id' => 'required|exists:users,id',
        ]);

        $client->update($validated);

        return redirect()
            ->route('clients.show', $client)
            ->with('success', 'Клиент успешно обновлён!');
    }

    /**
     * Удалить клиента
     * DELETE /clients/{client}
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Клиент удалён!');
    }
}
