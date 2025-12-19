<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questionnaires = Questionnaire::where('tenant_id', Auth::user()->tenant_id)
            ->latest()
            ->get();

        return view('questionnaires.index', compact('questionnaires'));
    }

    /**
     * Show the template selection page.
     */
    public function create()
    {
        $templates = config('questionnaire_templates');
        return view('questionnaires.create', compact('templates'));
    }

    /**
     * Store a new questionnaire from a template.
     */
    public function store(Request $request)
    {
        // dd('Store method hit', Auth::user()->id);
        $request->validate([
            'template' => 'required|string',
        ]);

        $templateKey = $request->input('template');
        $templates = config('questionnaire_templates');

        if (!isset($templates[$templateKey])) {
            return back()->withErrors(['template' => 'Invalid template selected.']);
        }

        $template = $templates[$templateKey];

        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = Auth::user()->restaurant ?? \App\Models\Restaurant::where('tenant_id', Auth::user()->tenant_id)->firstOrFail();

        $questionnaire = $restaurant->questionnaires()->create([
            'title' => $template['name'], // Default title to template name
            'template_type' => $templateKey,
            'questions' => $template['questions'],
        ]);

        return redirect()->route('questionnaires.edit', $questionnaire->id)
            ->with('status', 'questionnaire-created');
    }

    /**
     * Show the form for editing the specified questionnaire.
     */
    public function edit(Questionnaire $questionnaire)
    {
        // Ensure user owns the questionnaire
        $restaurantId = Auth::user()->restaurant->id ?? \App\Models\Restaurant::where('tenant_id', Auth::user()->tenant_id)->value('id');

        if ($questionnaire->restaurant_id !== $restaurantId && $questionnaire->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        return view('questionnaires.edit', compact('questionnaire'));
    }

    /**
     * Update the specified questionnaire in storage.
     */
    public function update(Request $request, Questionnaire $questionnaire)
    {
        if ($questionnaire->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'questions' => 'required|array|min:1',
            'questions.*.id' => 'required|string', // Allow string ID for UUIDs
            'questions.*.text' => 'required|string',
            'questions.*.type' => 'required|in:rating,text,boolean',
            'questions.*.options' => 'nullable|array',
            'questions.*.required' => 'boolean',
        ]);

        $questionnaire->update([
            'title' => $validated['title'],
            'questions' => $validated['questions'],
        ]);

        return back()->with('status', 'questionnaire-updated');
    }

    /**
     * Preview the questionnaire.
     */
    public function preview(Questionnaire $questionnaire)
    {
        if ($questionnaire->tenant_id !== Auth::user()->tenant_id) {
            abort(403);
        }

        return view('questionnaires.preview', compact('questionnaire'));
    }
}
