<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Logic to display a listing of repairs.
        // For example:
        // $repairs = Repair::all();
        // return view('admin.repairs.index', compact('repairs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Logic to show the create repair form.
        // For example:
        // return view('admin.repairs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Logic to store a new repair.
        // For example:
        // $validatedData = $request->validate([...]);
        // $repair = Repair::create($validatedData);
        // Log activity
        if (auth()->check()) {
            \App\Models\Activity::create([
                'user_id' => auth()->id(),
                'action' => 'created',
                'subject_type' => Repair::class,
                'subject_id' => isset($repair) ? $repair->id : null,
                'description' => 'Created a new repair',
            ]);
        }
        // return redirect()->route('admin.repairs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Repair  $repair
     * @return \Illuminate\Http\Response
     */
    public function show(Repair $repair)
    {
        // Logic to display a single repair.
        // For example:
        // return view('admin.repairs.show', compact('repair'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Repair  $repair
     * @return \Illuminate\Http\Response
     */
    public function edit(Repair $repair)
    {
        // Logic to show the edit repair form.
        // For example:
        // return view('admin.repairs.edit', compact('repair'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Repair  $repair
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Repair $repair)
    {
        // Logic to update a repair.
        // For example:
        // $validatedData = $request->validate([...]);
        // $repair->update($validatedData);
        // Log activity
        if (auth()->check()) {
            \App\Models\Activity::create([
                'user_id' => auth()->id(),
                'action' => 'updated',
                'subject_type' => Repair::class,
                'subject_id' => $repair->id,
                'description' => 'Updated a repair',
            ]);
        }
        // return redirect()->route('admin.repairs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Repair  $repair
     * @return \Illuminate\Http\Response
     */
    public function destroy(Repair $repair)
    {
        // Logic to delete a repair.
        // For example:
        // $repair->delete();
        // return redirect()->route('admin.repairs.index');
    }

    // API endpoint for auto-suggesting repair IDs
    public function getRepairIds(Request $request)
    {
        $term = $request->input('term');
        $repairs = \App\Models\Repair::where('id', 'like', "%$term%")
            ->pluck('id');
        return response()->json($repairs);
    }
}
