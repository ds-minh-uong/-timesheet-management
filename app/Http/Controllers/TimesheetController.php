<?php

namespace App\Http\Controllers;

use App\Models\Line;
use App\Models\Timesheet;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTimesheetRequest;
use App\Http\Requests\UpdateTimesheetRequest;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Termwind\Components\Li;

class TimesheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role == 0) {
            $timesheet = Timesheet::has('tasks')->where('user_id', $user->id)->get();
        } elseif ($user->role == 1) {
            $timesheet = Timesheet::has('tasks')->get();
        } elseif ($user->role == 2) {
            $timesheet = Timesheet::has('tasks')->where('manager_id', $user->id)->get();
        }
        return view('timesheet', ['timesheet' => $timesheet]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreTimesheetRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTimesheetRequest $request)
    {
        $req = $request->validated();
        $check = Timesheet::where('date', Carbon::now()->toDateString())->where('user_id', Auth::user()->id)->get();
        if (!empty($check[0])) {
            return Redirect::back()->withErrors('cannot create timesheet');

        }
        $timesheet = Timesheet::create([
            'difficult' => $req['difficult'],
            'schedule' => $req['schedule'],
            'user_id' => Auth::user()->id,
            'date' => Carbon::now(),
        ]);
        $tasks = [];
        foreach ($request->task as $index => $task) {
            $tasks[$index] = Line::create([
                'task_id' => $index,
                'content' => $task,
                'timesheet_id' => $timesheet->id,
                'manager_id' => Auth::user()->manager_id ?? 0
            ]);
        }
        return Redirect::route('timesheet');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Timesheet $timesheet
     * @return \Illuminate\Http\Response
     */
    public function show(Timesheet $timesheet)
    {

        return $timesheet;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Timesheet $timesheet
     * @return \Illuminate\Http\Response
     */
    public function edit(Timesheet $timesheet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateTimesheetRequest $request
     * @param \App\Models\Timesheet $timesheet
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Timesheet $timesheet, UpdateTimesheetRequest $request)
    {
        $this->authorize('update', $timesheet);

        $req = $request->validated();
        $tasks = Line::where('timesheet_id', $timesheet->id)->get();
        foreach ($tasks as $task) {
            $task->delete();
        }

        Timesheet::find($timesheet->id)->update([
            'difficult' => $req['difficult'],
            'schedule' => $req['schedule'],
        ]);

        foreach ($request->task as $index => $task) {
            $tasks[$index] = Line::create([
                'task_id' => $index,
                'content' => $task,
                'timesheet_id' => $timesheet->id
            ]);
        }
        return Redirect::route('timesheet');

    }

    public function updateStatus(Timesheet $timesheet, UpdateTimesheetRequest $request)
    {
        $this->authorize('updateStatus', $timesheet);
        $req = $request->validated();

        Timesheet::find($timesheet->id)->update([
            'status' => $req['status'],
        ]);

        return Redirect::route('timesheet');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Timesheet $timesheet
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Timesheet $timesheet)
    {
        $tasks = Line::where('timesheet_id', $timesheet->id)->get();
        foreach ($tasks as $task) {
            $task->delete();
        }
        $timesheet->delete();
        return Redirect::route('timesheet');
    }
}
