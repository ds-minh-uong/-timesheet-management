<x-app-layout>
    @foreach($users as $user)
        <div class="d-flex m-2">
            <div>{{$user->name}}</div>
            <div class="ml-3">{{$user->email}}</div>
            <div>
                <form method="post" action="/manage/user/{{$user->id}}">
                    @csrf
                    @method('patch')
                    <select name="role" id="role" value={{$user->role}}>
                        <option {{$user->role === 1 ? "selected" : ""}} value="1">Admin</option>
                        <option {{$user->role === 2 ? "selected" : ""}} value="2">Manager</option>
                        <option {{$user->role === 0 ? "selected" : ""}} value="0">Employee</option>
                    </select>
{{--                    <input type="submit" value="Change">--}}
                    <x-secondary-button type="submit">
                        {{ __('Change') }}
                    </x-secondary-button>
                </form>
{{--                <x-danger-button--}}
{{--                    x-data=""--}}
{{--                    x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{$user->id}}')"--}}
{{--                >{{ __('Delete') }}</x-danger-button>--}}
            </div>
        </div>

    @endforeach
</x-app-layout>
