<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Timesheet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach($timesheet as $timesheet_detail)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-1">
                    <div class="p-6 text-gray-900">
                        <div>{{$timesheet_detail->date}}</div>
                        @foreach($timesheet_detail->tasks as $task)
                            <div>{{$task->content}}</div>
                        @endforeach
                        <div>Khó khăn: {{$timesheet_detail->difficult}}</div>
                        <div>Dự định: {{$timesheet_detail->schedule}}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>

