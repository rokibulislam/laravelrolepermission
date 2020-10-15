<?php

namespace App\Providers;

use Gate;
use Illuminate\Support\ServiceProvider;
use App\Permission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Blade;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        Permission::get()->map( function( $permission ) {
            Gate::define( $permission->name, function( $user ) use ( $permission ) {
                return $user->hasPermissionTo( $permission );
            } );
        });

        Blade::directive('role', function( $role ) {
            return "<?php if( auth()->check() && auth()->user()->hasRole( {$role} ) ): ?>";
        });

        Blade::directive('endrole', function( $role ) {
            return "<?php endif; ?>";
        });
    }
}
