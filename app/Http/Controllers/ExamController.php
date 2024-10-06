<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamRequest;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->success(
            Exam::with("questions")->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExamRequest $request)
    {
        //
        $exam = Exam::create($request->all());
        return response()->success($exam, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Exam $exam)
    {
        return response()->success($exam->load('questions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExamRequest $request, Exam $exam)
    {
        $wasUpdated = false;
        if ($exam->title === $exam->getOriginal('title') || $exam->type === $exam->getOriginal('type')) {
            $wasUpdated = true;
        }
        $exam->update($request->all());
        return response()->json([
            'data' => $exam,
            'updated' => $wasUpdated
        ], 203);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam)
    {
        $exam->delete();
        return response()->success(['message' => 'Exam deleted'], 200);
    }
}
