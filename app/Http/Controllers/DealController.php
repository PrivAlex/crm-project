<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class DealController extends Controller
{
    /**
     * Список всех сделок
     * GET /deals
     */
    public function index()
    {
        $deals = Deal::with(['client', 'manager'])
            ->latest()
            ->paginate(10);

        return view('deals.index', compact('deals'));
    }

    /**
     * Форма создания сделки
     * GET /deals/create
     */
    public function create()
    {
        $clients  = Client::orderBy('name')->get();
        $managers = User::role('manager')->orRole('admin')->get();

        return view('deals.create', compact('clients', 'managers'));
    }

    /**
     * Сохранить новую сделку
     * POST /deals
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id'           => 'required|exists:clients,id',
            'manager_id'          => 'required|exists:users,id',
            'title'               => 'required|string|max:255',
            'amount'              => 'required|numeric|min:0',
            'status'              => 'required|in:new,contacted,qualified,proposal,negotiation,won,lost',
            'expected_close_date' => 'nullable|date',
        ]);

        Deal::create($validated);

        return redirect()
            ->route('deals.index')
            ->with('success', 'Сделка успешно создана!');
    }

    /**
     * Просмотр сделки
     * GET /deals/{deal}
     */
    public function show(Deal $deal)
    {
        $deal->load([
            'client',
            'manager',
            'activities' => fn($q) => $q->latest(),
            'tasks'      => fn($q) => $q->latest(),
        ]);

        // Получить доступные статусы для перехода
        $allowedTransitions = $deal->getAllowedTransitions();

        return view('deals.show', compact('deal', 'allowedTransitions'));
    }

    /**
     * Форма редактирования сделки
     * GET /deals/{deal}/edit
     */
    public function edit(Deal $deal)
    {
        $clients  = Client::orderBy('name')->get();
        $managers = User::role('manager')->orRole('admin')->get();

        return view('deals.edit', compact('deal', 'clients', 'managers'));
    }

    /**
     * Обновить сделку
     * PUT /deals/{deal}
     */
    public function update(Request $request, Deal $deal)
    {
        $validated = $request->validate([
            'client_id'           => 'required|exists:clients,id',
            'manager_id'          => 'required|exists:users,id',
            'title'               => 'required|string|max:255',
            'amount'              => 'required|numeric|min:0',
            'status'              => 'required|in:new,contacted,qualified,proposal,negotiation,won,lost',
            'expected_close_date' => 'nullable|date',
        ]);

        // Проверка перехода статуса
        if ($validated['status'] !== $deal->status) {
            if (!$deal->canTransitionTo($validated['status'])) {
                return back()->withErrors([
                    'status' => 'Нельзя перейти из статуса "' . $deal->status . '" в "' . $validated['status'] . '"'
                ]);
            }
        }

        $deal->update($validated);

        return redirect()
            ->route('deals.show', $deal)
            ->with('success', 'Сделка успешно обновлена!');
    }

    /**
     * Удалить сделку
     * DELETE /deals/{deal}
     */
    public function destroy(Deal $deal)
    {
        $deal->delete();

        return redirect()
            ->route('deals.index')
            ->with('success', 'Сделка удалена!');
    }
}
