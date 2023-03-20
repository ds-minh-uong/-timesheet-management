<?php

namespace App\Services;

use App\Models\Task;
use App\Models\Timesheet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TimesheetService implements TimesheetServiceInterface
{

    public function list()
    {
        $this->user = Auth::user();
        $query = Timesheet::with(['tasks', 'creator']);

        if ($this->user->role == 0) {
            $query->where('user_id', $this->user->id);
        }
        elseif ($this->user->role == 2) {
            $query->where('manager_id', $this->user->id)->orWhere('user_id', $this->user->id);
        }

        return $query->get();
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

    public function updateStatus($timesheet, $params)
    {
        $timesheet->update([
            'status' => $params['status'],
        ]);
        return $timesheet;
    }
}
