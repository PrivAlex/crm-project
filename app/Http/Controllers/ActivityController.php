<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Deal;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Форма создания активности
     * GET /activities/create?deal_id=1
     */
    public function create(Request $request)
    {
        $deal = Deal::findOrFail($request->deal_id);

        return view('activities.create', compact('deal'));
    }

    /**
     * Сохранить активность
     * POST /activities
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'deal_id'     => 'required|exists:deals,id',
            'type'        => 'required|in:call,email,meeting,note',
            'description' => 'required|string',
        ]);

        // Автоматически добавляем текущего пользователя
        $validated['user_id'] = auth()->id();

        Activity::create($validated);

        return redirect()
            ->route('deals.show', $validated['deal_id'])
            ->with('success', 'Активность добавлена!');
    }

    /**
     * Просмотр активности
     * GET /activities/{activity}
     */
    public function show(Activity $activity)
    {
        $activity->load(['deal', 'user']);

        return view('activities.show', compact('activity'));
    }

    /**
     * Удалить активность
     * DELETE /activities/{activity}
     */
    public function destroy(Activity $activity)
    {
        $dealId = $activity->deal_id;
        $activity->delete();

        return redirect()
            ->route('deals.show', $dealId)
            ->with('success', 'Активность удалена!');
    }
}
