<form action="{{ $url }}" method="post">
    @csrf

    @if($user->id !== null)
        @method('PUT')
    @endif

    <x-input label="Nome" name="name" id="user_name" :value="$user->name" autocomplete="off"/>
    <x-input label="E-mail" name="email" id="user_email" :value="$user->email" autocomplete="off" />
    <x-input label="Senha" name="password" id="user_password" type="password" autocomplete="one-time-code" />
    <x-input label="Confirmar senha" name="password_confirmation" id="user_password_confirmation" type="password" autocomplete="one-time-code" />
    <x-tag-selector
        label="Funções / Papéis"
        name="roles"
        :route="route('system.internal.get-roles')"
        :value="old('roles', !old('_token') ? $user->roles->makeHidden('pivot')->toArray() : [])"
    />

    <x-action-bar>
        <x-slot:right>
            <x-button.submit class="mr-2" />
            <x-button.back :href="route('system.users.index')" />
        </x-slot:right>
    </x-action-bar>
</form>