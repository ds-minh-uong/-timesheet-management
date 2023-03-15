<?php

namespace App\Services;

interface TimesheetServiceInterface
{
    public function list();

    public function create($params);

    public function update($timesheet, $params);

    public function updateStatus($timesheet, $params);

}
