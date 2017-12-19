<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['1', 'admin', '超级管理员', '系统管理员，拥有所有权限(市公安局)', '1', '2017-07-27 14:11:09', '2017-08-01 14:46:06', null],
            ['2', 'police', '民警', '区公安局', '3', '2017-07-28 10:55:17', '2017-11-08 10:22:30', null],
            ['3', 'editor', '运维', '区网站管理者', '1', '2017-07-28 10:55:47', '2017-11-10 17:04:13', null],
            ['4', 'owner', '业主', '业主单元', '2', '2017-10-09 16:09:23', '2017-10-09 16:09:30', null],
        ];

        $field = ['id','name','display_name','description','r_level','created_at','updated_at','deleted_at'];

        DB::table('roles')->insert(sql_batch_str($field,$data));
    }
}
