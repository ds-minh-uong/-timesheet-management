<?php

namespace App\Http\Controllers;

use App\Http\Requests\Timesheets\StoreTimesheetRequest;
use App\Http\Requests\Timesheets\UpdateTimesheetRequest;
use App\Models\Task;
use App\Models\Timesheet;
use App\Services\TimesheetService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TimesheetController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function __construct(TimesheetService $timesheetService)
    {
        parent::__construct();
        $this->timesheetService = $timesheetService;
    }

    public function index()
    {
        $timesheets = $this->timesheetService->list();
        return view('timesheet', ['timesheet' => $timesheets]);
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
     * @param \App\Http\Requests\Timesheets\StoreTimesheetRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTimesheetRequest $request)
    {
        $req = $request->validated();
        $req['task'] = $request->task;
        $timesheet = $this->timesheetService->create($req);
        return Redirect::route('timesheet');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Timesheet  $timesheet
     * @return \Illuminate\Http\Response
     */
    public function show(Timesheet $timesheet)
    {

        return view('timesheet-detail', ['timesheet' => $timesheet]);

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
     * @param \App\Http\Requests\Timesheets\UpdateTimesheetRequest $request
     * @param \App\Models\Timesheet $timesheet
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Timesheet $timesheet, UpdateTimesheetRequest $request)
    {
        $this->authorize('update', $timesheet);
        $req = $request->validated();
        $req['task'] = $request->task;
        $timesheet = $this->timesheetService->update($timesheet, $req);
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
        $timesheet->delete();
        return Redirect::route('timesheet');
    }
}
