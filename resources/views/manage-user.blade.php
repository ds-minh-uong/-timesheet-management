<x-app-layout>
    @foreach($users as $user)
        <div class="d-flex m-2">
            <div>{{$user->name}}</div>
            <div class="ml-3">{{$user->email}}</div>
            <div>
                <x-secondary-button
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'edit')"
                >{{ __('Edit') }}</x-secondary-button>
                <x-danger-button
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{$user->id}}')"
                >{{ __('Delete') }}</x-danger-button>
            </div>
        </div>
        <x-modal name="confirm-deletion-{{$user->id}}" :show="false" focusable>
            <form method="post" action="/manage/{{$user->id}}" class="p-6">
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

    @endforeach
</x-app-layout>
