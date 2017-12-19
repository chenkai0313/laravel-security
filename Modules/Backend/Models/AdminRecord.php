<?php
/**
 * 登录记录表
 * Author: CK
 * Date: 2017/12/6
 */

namespace Modules\Backend\Models;

use Illuminate\Database\Eloquent\Model;


class AdminRecord extends Model
{

    protected $table = 'admin_record';

    protected $primaryKey = 'record_id';

    protected $fillable = ['record_ip', 'admin_id', 'record_status'];


    /**
     * 添加登录记录
     * @return array
     */
    public static function recordAdd($params)
    {
        return AdminRecord::create($params);
    }

    /**
     * 解除登录限制
     * @return array
     */
    public static function unclogLogin($params)
    {
        $data = AdminRecord::where('admin_id', $params['admin_id'])->orderBy('updated_at', 'asc')->get();
        $res = $data->max();
        $record_status = ['record_status' => 1];
        $reslut = AdminRecord::where('record_id', $res['record_id'])->update($record_status);
        return $reslut;
    }

    /**
     * 所有用户最后登录时间记录列表
     * @return array
     */
    public static function recordList($params)
    {

        $data = AdminRecord::select( '*')
            ->where('admin_id', 'like', '%' . $params['keyword'] . '%')
            ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();
        return $data;
    }
}