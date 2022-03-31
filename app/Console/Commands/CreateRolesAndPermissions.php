<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateRolesAndPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roles-permissions:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria as roles e permissions da aplicação no banco de dados';

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
        $this->createPermissions();
        $this->info('Processo de criação de roles e permissions finalizado');
        return 0;
    }

    private function createPermissions()
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        DB::transaction(function () {
            foreach (config('roles-permissions') as $role => $permissions) {
                $this->info('Criando a role [' . $role . ']');
                Role::updateOrCreate(['name' => $role]);

                foreach ($permissions as $permission) {
                    $this->info('Criando a permission [' . $permission . '] e associando com a role [' . $role . ']');
                    $lastPermission = Permission::updateOrCreate(['name' => $permission]);
                    (Role::findByName($role))->givePermissionTo($lastPermission);
                }
            }
        });
    }
}
