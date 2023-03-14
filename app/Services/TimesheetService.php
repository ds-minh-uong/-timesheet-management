<?php

namespace App\Services;

use App\Models\Task;
use App\Models\Timesheet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TimesheetService extends BaseService
{
    public function __construct()
    {
        parent::__construct();
        $this->user = Auth::user();
    }

    public function list()
    {
        $this->user = Auth::user();
        if ($this->user->role == 0) {
            $timesheets = Timesheet::has('tasks')->has('creator')->where('user_id', $this->user->id)->get();
        } elseif ($this->user->role == 1) {
            $timesheets = Timesheet::has('tasks')->get();
        } elseif ($this->user->role == 2) {
            $timesheets = Timesheet::has('tasks')->has('creator')->where('manager_id', $this->user->id)->orWhere('user_id', $this->user->id)->get();
        }
        return $timesheets;
    }

    public function create($params)
    {
        $check = Timesheet::where('date', Carbon::now()->toDateString())->where('user_id', Auth::user()->id)->get();
        if (!empty($check[0])) {
            return Redirect::back()->withErrors('cannot create timesheet');
        }

        $user = Auth::user();
        $timesheet = $user->timesheets()->create([
            'difficult' => $params['difficult'],
            'schedule' => $params['schedule'],
            'date' => Carbon::now(),
            'manager_id' => $user->manager_id ?? 0
        ]);
        foreach ($params['task'] as $index => $task) {
            $timesheet->tasks()->create([
                'task_id' => $index,
                'content' => $task
            ]);
        }
        return $timesheet;
    }

    public function update($timesheet, $params)
    {
//        $tasks = Task::where('timesheet_id', $timesheet->id)->get();
//        foreach ($tasks as $task) {
//            $task->delete();
//        }

        $timesheet->tasks()->delete();
        $timesheet->update([
            'difficult' => $params['difficult'],
            'schedule' => $params['schedule'],
        ]);

        foreach ($params['task'] as $index => $task) {
            $timesheet->tasks()->create([
                'task_id' => $index,
                'content' => $task
            ]);
        }
        return $timesheet;
    }
}
