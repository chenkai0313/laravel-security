<?php

use Illuminate\Database\Seeder;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['1', 'admin', '管理员', '1', '$2y$10$muSTmhe4yF7yH3sWlUEilev63loHMYRwPKjVOgk9nAs4bYy7MCV.m', null, '', null, '1', '', '', '', '', '', null, '0', '', '2017-07-25 17:11:30', '2017-11-07 11:12:06', null],
            ['2', 'police', '民警', '1', '$2y$10$6B4pYpDFHfVMzt43Tefhxe3Xb4RdrPA2TYQSEg9VmEqvLV.VVxEyC', '2017-09-30', '', null, '0', '', '', '', '', '', null, '0', '', '2017-09-22 11:47:12', '2017-11-08 10:36:44', null],
            ['3', 'edit', '运维', '1', '$2y$10$vK6Z/NaHBAweJVHmCKc8veee4D4r4KlXKQRtcSrBAIfMxPZRg/g3C', null, '', null, '0', '', '', '', '', '', null, '0', '', '2017-11-02 15:47:23', '2017-11-08 10:42:06', null],
            ['4', 'owner', '业主', '1', '$2y$10$/k8hU/.IMIKNHJX6yn9AruVXvx9n3aZ8swvwBihE2v/lr6Sr6XSrK', null, '', null, '0', '', '', '', '', '', null, '0', '', '2017-11-02 16:09:39', '2017-11-08 10:32:00', null],
        ];

        $field = ['admin_id','admin_name','admin_nick','admin_sex','admin_password','admin_birthday','admin_mobile','remember_token','is_super','province','city','district','address','login_ip','login_at','is_first','remark','created_at','updated_at','deleted_at'];

        DB::table('admins')->insert(sql_batch_str($field,$data));

        $data = [
            ['1', '1', '0', '', '', null, null, '2017-11-06 17:18:35', '2017-11-10 18:05:28', null],
            ['2', '2', '0', '', '', null, null, '2017-11-06 17:18:35', '2017-11-10 09:02:31', null],
            ['3', '3', '0', '', '', null, null, '2017-11-03 15:40:28', '2017-11-09 19:36:47', null],
            ['4', '4', '0', '', '', null, null, '2017-11-03 15:57:54', '2017-11-10 16:55:02', null],
        ];

        $field = ['info_id','admin_id','scan_times_count','admin_url','company_name','position','department','created_at','updated_at','updated_at'];

        DB::table('admin_info')->insert(sql_batch_str($field,$data));
    }
}
