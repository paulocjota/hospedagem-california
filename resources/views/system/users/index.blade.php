@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <x-title-with-breadcrumbs title="Usuários">
        {{ Breadcrumbs::render('system.users.index') }}
    </x-title-with-breadcrumbs>
@stop

@section('content')
    <x-page-card>
        <x-alerts />

        <x-action-bar>
            <x-slot:right>
                @can('create users')
                    <a class="btn btn-primary" href="{{ route('system.users.create') }}" role="button">Adicionar usuário</a>
                @endcan
            </x-slot>
        </x-action-bar>

        <x-search-bar :action="route('system.users.index')" />

        <div class="table-responsive table-striped">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Funções / Papéis</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach ($user->roles as $role)
                                    <span class="badge badge-pill badge-info">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <x-table.action-wrapper>

                                    @can('delete users', $user)
                                        <x-table.button.delete
                                            target="#modal-delete-user"
                                            title="Excluir usuário"
                                            text="Deseja realmente excluir o usuário {{ $user->name }}?"
                                            :route="route('system.users.destroy', $user->id)"
                                        />
                                    @endcan

                                    @can('edit users', $user)
                                        <x-table.button.edit :href="route('system.users.edit', $user->id)" />
                                    @endcan

                                    @can('view users', $user)
                                        <x-table.button.show :href="route('system.users.show', $user->id)" />
                                    @endcan
                                </x-table.action-wrapper>
                            </td>
                        </tr>
                    @empty
                        <x-table.no-rows />
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-page-card>

    <x-modal.delete id="modal-delete-user" />
@endsection