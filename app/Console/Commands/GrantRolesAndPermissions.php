<?php

namespace App\Console\Commands;

use Exception;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GrantRolesAndPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roles-permissions:grant';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Concede uma role específica para usuários predeterminados';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->grantRole();
        $this->grantPermissions();
        $this->info('Processo finalizado');
        return 0;
    }

    private function grantRole()
    {
        if (!$roles = config('roles-permissions-to-grant.roles')) return;
        DB::transaction(function () use ($roles) {
            foreach ($roles as $role => $users) {
                foreach ($users as $user) {
                    $this->info('Concedendo a role [' . $role . '] para o usuário de nome [' . $user['name']  . '] e email [' . $user['email'] . ']');

                    $model = User::where([
                        ['name', '=', $user['name']],
                        ['email', '=', $user['email']],
                    ])->first();

                    if (!$model) {
                        throw new Exception('Um dos usuários informados não foi encontrado. O processo foi abortado!');
                    }

                    DB::table('model_has_roles')->updateOrInsert([
                        'role_id' => (Role::findByName($role))->id,
                        'model_type' => 'App\Models\User',
                        'model_id' => $model->id,
                    ]);
                }
            }
        });
    }

    private function grantPermissions()
    {
        if (!$permissions = config('roles-permissions-to-grant.permissions')) return;
        DB::transaction(function () use ($permissions) {
            foreach ($permissions as $permission => $users) {
                foreach ($users as $user) {
                    $this->info('Concedendo a permission [' . $permission . '] para o usuário de nome [' . $user['name']  . '] e email [' . $user['email'] . ']');

                    $model = User::where([
                        ['name', '=', $user['name']],
                        ['email', '=', $user['email']],
                    ])->first();

                    if (!$model) {
                        throw new Exception('Um dos usuários informados não foi encontrado. O processo foi abortado!');
                    }

                    DB::table('model_has_permissions')->updateOrInsert([
                        'permission_id' => (Permission::findByName($permission))->id,
                        'model_type' => 'App\Models\User',
                        'model_id' => $model->id,
                    ]);
                }
            }
        });
    }
}
