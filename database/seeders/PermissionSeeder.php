<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            [
                'guard_name' => 'web',
                'name' => 'create customer',
                'group' => 'customers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'edit customer',
                'group' => 'customers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'view customer',
                'group' => 'customers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'delete customer',
                'group' => 'customers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'create product',
                'group' => 'products',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'edit product',
                'group' => 'products',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'view product',
                'group' => 'products',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'delete product',
                'group' => 'products',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'create category',
                'group' => 'categories',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'edit category',
                'group' => 'categories',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'view category',
                'group' => 'categories',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'delete category',
                'group' => 'categories',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'create order',
                'group' => 'orders',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'edit order',
                'group' => 'orders',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'view order',
                'group' => 'orders',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'delete order',
                'group' => 'orders',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'dashboard',
                'group' => 'dashboard',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'report',
                'group' => 'report',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'create supplier',
                'group' => 'suppliers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'edit supplier',
                'group' => 'suppliers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'view supplier',
                'group' => 'suppliers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'delete supplier',
                'group' => 'suppliers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'create generic',
                'group' => 'generic',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'edit generic',
                'group' => 'generic',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'view generic',
                'group' => 'generic',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'delete generic',
                'group' => 'generic',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'create purchase',
                'group' => 'purchases',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'edit purchase',
                'group' => 'purchases',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'view purchase',
                'group' => 'purchases',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'delete purchase',
                'group' => 'purchases',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'pos',
                'group' => 'pont of sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'create role',
                'group' => 'role',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'edit role',
                'group' => 'role',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'delete role',
                'group' => 'role',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'guard_name' => 'web',
                'name' => 'view role',
                'group' => 'role',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
