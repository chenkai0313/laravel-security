<?php

use Illuminate\Database\Seeder;

class RoleAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            ['1', '2'],
            ['2', '2'],
            ['3', '3'],
            ['4', '4'],
        ];

        $field = ['admin_id','role_id'];

        DB::table('role_admin')->insert(sql_batch_str($field,$data));
    }
}
