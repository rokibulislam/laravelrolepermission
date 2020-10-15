<?php

namespace App\Permissions;

use App\{Role,Permission};

trait HasPermissionsTrait {

    public function givePermissionTo( ...$permissions ) {
        $permissions = $this->getAllPermissions( $permissions );

        if( $permissions === null ) {
            return $this;
        }

        $this->permissions()->saveMany( $permissions );

        return $this;
    }

    public function withdrawPermissionTo( ...$permissions ) {
        $permissions = $this->getAllPermissions( $permissions );

        $this->permissions()->detach( $permissions );

        return $this;
    }

    public function updatePermissionTo( ...$permissions ) {
        $this->permissions()->detach();

        $this->givePermissionTo( $permissions );

        return $this;
    }

    public function getAllPermissions( array $permissions ){
        return Permission::whereIn('name', $permissions )->get();
    }

    public function hasPermissionTo( $permission ) {
        return $this->hasPermissionThroughRole( $permission ) || $this->hasPermission( $permission );
    }

    public function hasPermission( $permission ) {
        return (bool) $this->permissions->where('name', $permission->name )->count();
    }

    public function hasPermissionThroughRole( $permission ) {

        foreach ($permission->roles as $role ) {
            if( $this->roles->contains($role ) ) {
                return true;
            }
        }

        return false;
    }

    public function hasRole( ...$roles) {
        foreach ($roles as $role) {
            if( $this->roles->contains( 'name', $role ) ) {
                return true;
            }
        }

        return false;
    }

    public function roles() {
        return $this->belongsToMany( Role::class,'users_roles' );
    }

    public function permissions() {
        return  $this->belongsToMany( Permission::class,'users_permissions' );
    }
}
