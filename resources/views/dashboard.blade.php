<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create timesheet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action={{ route('timesheet.store') }}>
                        @csrf
{{--                        <div>--}}
{{--                            <x-input-label for="date" :value="__('Date')" />--}}
{{--                            <div class="relative">--}}
{{--                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">--}}
{{--                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>--}}
{{--                                </div>--}}
{{--                                <input datepicker id="date" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date" name="date">--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                        multiple-line--}}
                        <div class="row">
                            <x-input-label for="task[]" :value="__('Task')" />
                            <div class="col-lg-12">
                                <div id="inputFormRow">
                                    <div class="input-group mb-3">
                                        <input type="text" name="task[]" class="form-control m-input" placeholder="Enter title" autocomplete="off">
                                        <div class="input-group-append">
                                            <button id="removeRow" type="button" class="btn btn-danger">Remove</button>
                                        </div>
                                    </div>
                                </div>

                                <div id="newRow"></div>
                                <button id="addRow" type="button" class="btn btn-info">Add Task</button>
                            </div>
                        </div>
                        <div>
                            <x-input-label for="difficult" :value="__('Khó khăn')" />
                            <x-text-input id="difficult" class="block mt-1 w-full" type="text" name="difficult" :value="old('difficult')" required autofocus />
                            <x-input-error :messages="$errors->get('difficult')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="schedule" :value="__('Dự định sẽ làm trong ngày tiếp theo')" />
                            <x-text-input id="schedule" class="block mt-1 w-full" type="text" name="schedule" :value="old('schedule')" required autofocus />
                            <x-input-error :messages="$errors->get('schedule')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-3">
                                {{ __('Create') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script type="text/javascript">
    // add row
    $("#addRow").click(function () {
        var html = '';
        html += '<div id="inputFormRow">';
        html += '<div class="input-group mb-3">';
        html += '<input type="text" name="task[]" class="form-control m-input" placeholder="Enter title" autocomplete="off">';
        html += '<div class="input-group-append">';
        html += '<button id="removeRow" type="button" class="btn btn-danger">Remove</button>';
        html += '</div>';
        html += '</div>';

        $('#newRow').append(html);
    });

    // remove row
    $(document).on('click', '#removeRow', function () {
        $(this).closest('#inputFormRow').remove();
    });
</script>
