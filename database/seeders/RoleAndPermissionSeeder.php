<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //Define Permissions 
        $add_product = 'create-product';
        $edit_product = 'edit-product';
        $delete_product = 'delete-product';
        $add_article = 'add-article';
        $edit_article = 'edit-article';
        $delete_article = 'delete-article';


        // permission Product
        Permission::create(['name' => $add_product]);
        Permission::create(['name' => $edit_product]);
        Permission::create(['name' => $delete_product]);

        // permission Article
        Permission::create(['name' => $add_article]);
        Permission::create(['name' => $edit_article]);
        Permission::create(['name' => $delete_article]);

        //Define Roles
        $bayer = 'bayer';
        $writer = 'writer';

        //Create Permissions Via Roles
        Role::create(['name' => $bayer])->givePermissionTo($add_product, $edit_product, $delete_product);
        Role::create(['name' => $writer])->givePermissionTo([$add_article, $edit_article, $delete_article]);
    }
}
