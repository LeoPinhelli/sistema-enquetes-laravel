<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PollController extends Controller
{
    // API: Lista todas as enquetes com opções
    public function apiIndex()
    {
        return response()->json(Poll::with('options')->get());
    }

    // API: Mostra uma enquete individual
    public function apiShow($id)
    {
        $poll = Poll::with('options')->findOrFail($id);
        return response()->json($poll);
    }

    // API: Cria uma nova enquete
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'options' => 'required|array|min:1',
            'options.*' => 'required|string',
        ]);

        $poll = null;

        DB::transaction(function () use ($request, &$poll) {
            $poll = Poll::create($request->only('title', 'start_at', 'end_at'));
            foreach ($request->options as $text) {
                $poll->options()->create(['text' => $text]);
            }
        });

        if ($poll) {
            return response()->json($poll->load('options'), 201);
        } else {
            return response()->json(['error' => 'Falha ao criar enquete.'], 500);
        }
    }

    // API: Atualiza uma enquete existente
    public function update(Request $request, $id)
    {
        $poll = Poll::with('options')->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'options' => 'required|array|min:1',
            'options.*.id' => 'sometimes|exists:poll_options,id',
            'options.*.text' => 'required|string',
        ]);

        DB::transaction(function () use ($request, $poll) {
            $poll->update($request->only('title', 'start_at', 'end_at'));

            $existingIds = $poll->options->pluck('id')->toArray();
            $sentIds = collect($request->options)->pluck('id')->filter()->toArray();
            $toDelete = array_diff($existingIds, $sentIds);
            PollOption::destroy($toDelete);

            foreach ($request->options as $option) {
                if (isset($option['id'])) {
                    PollOption::where('id', $option['id'])->update(['text' => $option['text']]);
                } else {
                    $poll->options()->create(['text' => $option['text']]);
                }
            }
        });

        return response()->json($poll->load('options'));
    }

    // API: Deleta uma enquete
    public function destroy($id)
    {
        $poll = Poll::findOrFail($id);
        $poll->options()->delete();
        $poll->delete();

        return response()->json(['message' => 'Enquete deletada com sucesso']);
    }

    // API/WEB: Registra voto em uma enquete
public function vote(Request $request, $id)
{
    $poll = Poll::with('options')->findOrFail($id);

    if (!$poll->isActive()) {
        if ($request->wantsJson()) {
            return response()->json(['error' => 'Enquete não está ativa.'], 403);
        } else {
            return back()->withErrors(['error' => 'Enquete não está ativa.']);
        }
    }

    $validated = $request->validate([
        'option_id' => 'required|exists:poll_options,id',
    ]);

    $option = PollOption::where('id', $validated['option_id'])
        ->where('poll_id', $poll->id)
        ->firstOrFail();

    $option->increment('votes');
    $option->refresh();

    // Resposta para API
    if ($request->wantsJson()) {
        return response()->json([
            'message' => 'Voto registrado com sucesso!',
            'poll' => $poll,
            'option' => $option,
        ], 200);
    }

    // Resposta para Web (HTML)
    return view('vote-success', [
        'poll' => $poll,
        'option' => $option,
    ]);
}


    // WEB: Lista enquetes
    public function index()
    {
        $polls = Poll::all()->map(function ($poll) {
            $now = Carbon::now();

            $poll->status = $now->lt(Carbon::parse($poll->start_at)) ? 'Não iniciada'
                : ($now->lte(Carbon::parse($poll->end_at)) ? 'Em andamento' : 'Finalizada');

            $poll->start_at_formatted = Carbon::parse($poll->start_at)->format('d/m/Y');
            $poll->end_at_formatted = Carbon::parse($poll->end_at)->format('d/m/Y');
            return $poll;
        });

        return view('polls.index', compact('polls'));
    }

    // WEB: Mostra enquete individual
    public function showWeb($id)
    {
        $poll = Poll::with('options')->findOrFail($id);

        $now = Carbon::now();
        $poll->status = $now->lt(Carbon::parse($poll->start_at)) ? 'Não iniciada'
            : ($now->lte(Carbon::parse($poll->end_at)) ? 'Em andamento' : 'Finalizada');

        $poll->start_at_formatted = Carbon::parse($poll->start_at)->format('d/m/Y');
        $poll->end_at_formatted = Carbon::parse($poll->end_at)->format('d/m/Y');

        return view('poll', compact('poll'));
    }
}
