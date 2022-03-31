<?php

namespace App\Http\Controllers\System;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::orderBy('name', 'ASC');

        $q = trim($request->input('q'));

        if (!empty($q)) {
            $users->where('name', 'like', '%' . $q . '%');
        }

        $users = $users->paginate();

        return view('system.users.index')->with([
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('system.users.create')->with([
            'user' => new User,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = bcrypt($data['password']);
            $data['email_verified_at'] = now();
            $data['remember_token'] = Str::random(10);

            if (!array_key_exists('roles_ids', $data) || $data['roles_ids'] === null) {
                $data['roles_ids'] = [];
            }

            DB::beginTransaction();
            $user = User::create($data);
            $user->syncRoles($data['roles_ids']);
            DB::commit();
            return redirect()->route('system.users.index')
                ->with('success', 'Usuário adicionado com sucesso');
        } catch (\Exception $e) {
            DB::rollBack();
            $message = 'Erro ao adicionar usuário';

            if (config('app.debug')) {
                $message = $e->getMessage();
            }

            return redirect()->route('system.users.index')
                ->with('error', $message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('system.users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('system.users.edit')->with([
            'user' => User::with(['roles' => function ($query) {
                $query->select('id', 'name');
            }])->where('id', $user->id)->first(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        try {
            $data = $request->validated();
            if (array_key_exists('password', $data) && $data['password'] !== null) {
                $data['password'] = bcrypt($data['password']);
            } elseif (array_key_exists('password', $data) && $data['password'] === null) {
                unset($data['password']);
            }

            if (!array_key_exists('roles_ids', $data) || $data['roles_ids'] === null) {
                $data['roles_ids'] = [];
            }

            DB::beginTransaction();
            $user->update($data);
            $user->syncRoles($data['roles_ids']);
            DB::commit();
            return redirect()->route('system.users.index')
                ->with('success', 'Usuário editado com sucesso');
        } catch (\Exception $e) {
            DB::rollBack();
            $message = 'Falha ao editar usuário';

            if (config('app.debug')) {
                $message = $e->getMessage();
            }

            return redirect()->route('system.users.index')
                ->with('error', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('system.users.index')
                ->with('success', 'Usuário excluído com sucesso');
        } catch (\Exception $e) {
            $message = 'Falha ao excluir usuário';

            if (config('app.debug')) {
                $message = $e->getMessage();
            }

            return redirect()->route('system.users.index')
                ->with('error', $message);
        }
    }
}
