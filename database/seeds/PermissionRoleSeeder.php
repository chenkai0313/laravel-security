<?php

use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['1', '1'],
            ['3', '1'],
            ['4', '1'],
            ['5', '1'],
            ['6', '1'],
            ['7', '1'],
            ['8', '1'],
            ['9', '1'],
            ['10', '1'],
            ['11', '1'],
            ['12', '1'],
            ['15', '1'],
            ['16', '1'],
            ['17', '1'],
            ['18', '1'],
            ['19', '1'],
            ['22', '1'],
            ['23', '1'],
            ['24', '1'],
            ['25', '1'],
            ['26', '1'],
            ['27', '1'],
            ['28', '1'],
            ['29', '1'],
            ['33', '1'],
            ['34', '1'],
            ['35', '1'],
            ['36', '1'],
            ['37', '1'],
            ['38', '1'],
            ['39', '1'],
            ['41', '1'],
            ['44', '1'],
            ['45', '1'],
            ['46', '1'],
            ['47', '1'],
            ['48', '1'],
            ['49', '1'],
            ['50', '1'],
            ['51', '1'],
            ['52', '1'],
            ['53', '1'],
            ['54', '1'],
            ['56', '1'],
            ['57', '1'],
            ['58', '1'],
            ['60', '1'],
            ['61', '1'],
            ['62', '1'],
            ['63', '1'],
            ['64', '1'],
            ['65', '1'],
            ['66', '1'],
            ['67', '1'],
            ['68', '1'],
            ['70', '1'],
            ['71', '1'],
            ['72', '1'],
            ['74', '1'],
            ['75', '1'],
            ['76', '1'],
            ['82', '1'],
            ['83', '1'],
            ['84', '1'],
            ['85', '1'],
            ['86', '1'],
            ['87', '1'],
            ['1', '2'],
            ['3', '2'],
            ['4', '2'],
            ['5', '2'],
            ['6', '2'],
            ['7', '2'],
            ['8', '2'],
            ['11', '2'],
            ['12', '2'],
            ['15', '2'],
            ['16', '2'],
            ['17', '2'],
            ['18', '2'],
            ['19', '2'],
            ['22', '2'],
            ['23', '2'],
            ['24', '2'],
            ['25', '2'],
            ['26', '2'],
            ['27', '2'],
            ['28', '2'],
            ['29', '2'],
            ['36', '2'],
            ['37', '2'],
            ['38', '2'],
            ['39', '2'],
            ['41', '2'],
            ['44', '2'],
            ['45', '2'],
            ['46', '2'],
            ['47', '2'],
            ['48', '2'],
            ['49', '2'],
            ['50', '2'],
            ['51', '2'],
            ['67', '2'],
            ['68', '2'],
            ['70', '2'],
            ['82', '2'],
            ['83', '2'],
            ['84', '2'],
            ['85', '2'],
            ['86', '2'],
            ['87', '2'],
            ['7', '3'],
            ['8', '3'],
            ['9', '3'],
            ['10', '3'],
            ['22', '3'],
            ['23', '3'],
            ['24', '3'],
            ['25', '3'],
            ['26', '3'],
            ['27', '3'],
            ['28', '3'],
            ['29', '3'],
            ['33', '3'],
            ['34', '3'],
            ['35', '3'],
            ['36', '3'],
            ['37', '3'],
            ['38', '3'],
            ['39', '3'],
            ['41', '3'],
            ['44', '3'],
            ['45', '3'],
            ['47', '3'],
            ['48', '3'],
            ['52', '3'],
            ['53', '3'],
            ['54', '3'],
            ['56', '3'],
            ['57', '3'],
            ['58', '3'],
            ['60', '3'],
            ['61', '3'],
            ['62', '3'],
            ['63', '3'],
            ['64', '3'],
            ['65', '3'],
            ['66', '3'],
            ['67', '3'],
            ['68', '3'],
            ['70', '3'],
            ['71', '3'],
            ['72', '3'],
            ['74', '3'],
            ['75', '3'],
            ['76', '3'],
            ['85', '3'],
            ['86', '3'],
            ['5', '4'],
            ['6', '4'],
            ['7', '4'],
            ['8', '4'],
            ['10', '4'],
            ['11', '4'],
            ['12', '4'],
            ['15', '4'],
            ['16', '4'],
            ['17', '4'],
            ['18', '4'],
            ['19', '4'],
            ['24', '4'],
            ['25', '4'],
            ['26', '4'],
            ['27', '4'],
            ['28', '4'],
            ['29', '4'],
            ['33', '4'],
            ['34', '4'],
            ['35', '4'],
            ['36', '4'],
            ['37', '4'],
            ['38', '4'],
            ['39', '4'],
            ['41', '4'],
            ['44', '4'],
            ['45', '4'],
            ['47', '4'],
            ['52', '4'],
            ['53', '4'],
            ['54', '4'],
            ['56', '4'],
            ['57', '4'],
            ['58', '4'],
            ['60', '4'],
            ['61', '4'],
            ['62', '4'],
            ['63', '4'],
            ['70', '4'],
            ['71', '4'],
            ['72', '4'],
            ['74', '4'],
            ['75', '4'],
            ['76', '4'],
            ['85', '4'],
            ['86', '4'],

        ];

        $field = ['permission_id','role_id'];

        DB::table('permission_role')->insert(sql_batch_str($field,$data));
    }
}