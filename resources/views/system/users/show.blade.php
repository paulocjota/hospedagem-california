@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <x-title-with-breadcrumbs title="Visualizando usuário <strong>{{ $user->name }}</strong>">
        {{ Breadcrumbs::render('system.users.show', $user) }}
    </x-title-with-breadcrumbs>
@stop

@section('content')
    <x-page-card>
        <x-alerts />

        <x-action-bar>
            <x-slot:right>
                <x-button.back :href="route('system.users.index')" />
            </x-slot>
        </x-action-bar>

        <table class="table">
            <tbody>
                <tr>
                    <th>Nome</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>E-mail</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Funções / Papéis</th>
                    <td>
                        @foreach ($user->roles as $role)
                            <span class="badge badge-pill badge-info">{{ $role->name }}</span>
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
    </x-page-card>
@endsection