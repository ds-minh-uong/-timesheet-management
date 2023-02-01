<x-app-layout>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-1 d-flex justify-content-between">
        <div class="p-6 text-gray-900">
            <div>{{$timesheet->date}}</div>
            @foreach($timesheet->tasks as $task)
                <div>- {{$task->content}}</div>
            @endforeach
            <div>Khó khăn: {{$timesheet->difficult}}</div>
            <div>Dự định: {{$timesheet->schedule}}</div>
        </div>
        <div>
            <x-secondary-button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'edit-timesheet-{{$timesheet->id}}')"
            >{{ __('Edit') }}</x-secondary-button>
            <x-danger-button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-timesheet-deletion-{{$timesheet->id}}')"
            >{{ __('Delete') }}</x-danger-button>
        </div>
    </div>
    <x-modal name="edit-timesheet-{{$timesheet->id}}" :show="false" focusable>
        <form method="post" action="/timesheet/{{$timesheet->id}}" class="p-6">
            @csrf
            @method('patch')

            <div class="row">
                <x-input-label for="task[]" :value="__('Task')" />
                <div class="col-lg-12">
                    @foreach($timesheet->tasks as $task)
                        <div id="inputFormRow">
                            <div class="input-group mb-3">
                                <input type="text" name="task[]" class="form-control m-input" value="{{$task->content}}" placeholder="Enter title" autocomplete="off">
                                <div class="input-group-append">
                                    <button id="removeRow" type="button" class="btn btn-danger">Remove</button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div id="newRow"></div>
                    <button id="addRow" type="button" class="btn btn-info">Add Task</button>
                </div>
            </div>
            <div>
                <x-input-label for="difficult" :value="__('Khó khăn')" />
                <x-text-input id="difficult" class="block mt-1 w-full" type="text" name="difficult" :value="$timesheet->difficult" required autofocus />
                <x-input-error :messages="$errors->get('difficult')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="schedule" :value="__('Dự định sẽ làm trong ngày tiếp theo')" />
                <x-text-input id="schedule" class="block mt-1 w-full" type="text" name="schedule" :value="$timesheet->schedule" required autofocus />
                <x-input-error :messages="$errors->get('schedule')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Update') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
    <x-modal name="confirm-timesheet-deletion-{{$timesheet->id}}" :show="false" focusable>
        hi
        <form method="post" action="/timesheet/{{$timesheet->id}}" class="p-6">
            @csrf
            @method('delete')
            <div>
                Delete this timesheet?
            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Delete') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>

</x-app-layout>
