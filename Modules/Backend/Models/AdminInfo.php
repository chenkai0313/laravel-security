<?php
/**
 * admin附表 信息表
 * Author: caohan
 * Date: 2017/10/31
 */

namespace Modules\Backend\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminInfo extends Model
{
    use SoftDeletes;

    protected $table = 'admin_info';

    protected $primaryKey = 'info_id';

    protected $fillable = ['admin_id', 'scan_times_count','contact_name','contact_mobile', 'address','admin_url', 'company_name', 'position', 'department'];

    public static function adminInfoAdd($params)
    {
        $res = AdminInfo::create($params);
        return $res->info_id;
    }

    public static function adminInfoEdit($params)
    {
        $data = [];
        if (isset($params['scan_times_count'])) {
            $data['scan_times_count'] = $params['scan_times_count'];
        }
        if (isset($params['admin_url'])) {
            $data['admin_url'] = $params['admin_url'];
        }
        if (isset($params['company_name'])) {
            $data['company_name'] = $params['company_name'];
        }
        if (isset($params['position'])) {
            $data['position'] = $params['position'];
        }
        if (isset($params['department'])) {
            $data['department'] = $params['department'];
        }
        if (isset($params['contact_name'])) {
        $data['contact_name'] = $params['contact_name'];
        }
        if (isset($params['contact_mobile'])) {
        $data['contact_mobile'] = $params['contact_mobile'];
        }
        if (isset($params['address'])) {
        $data['address'] = $params['address'];
        }

        if (empty($data)) {
            return true;
        } else {
            $result = AdminInfo::where('admin_id', $params['admin_id'])->update($data);
            return $result;
        }
    }

    public static function adminInfoChange($admin_id, $params)
    {
        $result = AdminInfo::where('admin_id', $admin_id)->update($params);
        return $result;
    }

    public static function adminInfoDel($params)
    {
        $result = AdminInfo::where('admin_id', $params['admin_id'])->delete();
        return $result;
    }

    public static function adminInfoList($params)
    {
        $res = AdminInfo::whereIn('admin_id', $params)->get();
        return $res;
    }

    public static function adminInfo($params)
    {
        $res = AdminInfo::where('admin_id', $params)->first();
        return $res;
    }

    /**
     * 公司是否唯一
     * @params int $company_name 单位名称
     * @return array
     */
    public static function adminInfoExist($company_name){
        $result = AdminInfo::where('company_name',$company_name)->count();
        return $result;
    }

    /**
     * 业主概况(查看所有)
     *
     * @return mixed
     */
    public static function clientInfoListAll($params)
    {
        $offset = ($params['page'] - 1) * $params['limit'];
        $res = AdminInfo::select('info_id', 'admin_id', 'scan_times_count', 'company_name', 'admin_url', 'created_at', 'updated_at')
            ->orwhere(function ($query) use ($params) {
                $query->where('company_name', 'like', '%' . $params['keyword'] . '%');
            })
            ->skip($offset)
            ->orderBy('created_at', 'desc')
            ->take($params['limit'])
            ->get();
        foreach ($res as $v) {
            $risk_level = Report::select('risk_level', 'report_id')->where('to_admin_id', $v['admin_id'])->get();
            $v['risk_level'] = floor($risk_level->avg('risk_level'));
            if (is_null($v['risk_level']))
                $v['risk_level'] = 0;
        }
        foreach ($res as $v) {
            switch ($v['risk_level']) {
                case 1;
                    $v['risk_level_name'] = '绝对安全';
                    break;
                case 2;
                    $v['risk_level_name'] = '比较安全';
                    break;
                case 3;
                    $v['risk_level_name'] = '相对危险';
                    break;
                case 4;
                    $v['risk_level_name'] = '绝对危险';
                    break;
                case 0;
                    $v['risk_level_name'] = '暂无风险评测';
                    break;
            }
        }
        return $res;
    }

    /**
     * 业主概况(查看自己)
     *
     * @return mixed
     */
    public static function clientInfoListSelf($params)
    {
        $offset = ($params['page'] - 1) * $params['limit'];
        $res = AdminInfo::select('info_id', 'admin_id', 'scan_times_count', 'company_name', 'admin_url', 'created_at', 'updated_at')
            ->orwhere(function ($query) use ($params) {
                $query->where('company_name', 'like', '%' . $params['keyword'] . '%')
                    ->where('admin_id', '=', $params['admin_id']);
            })
            ->skip($offset)
            ->orderBy('created_at', 'desc')
            ->take($params['limit'])
            ->get();
        foreach ($res as $v) {
            $risk_level = Report::select('risk_level', 'report_id')->where('to_admin_id', $v['admin_id'])->get();
            $v['risk_level'] = floor($risk_level->avg('risk_level'));
            if (is_null($v['risk_level']))
                $v['risk_level'] = 0;
        }
        foreach ($res as $v) {
            switch ($v['risk_level']) {
                case 1;
                    $v['risk_level_name'] = '绝对安全';
                    break;
                case 2;
                    $v['risk_level_name'] = '比较安全';
                    break;
                case 3;
                    $v['risk_level_name'] = '相对危险';
                    break;
                case 4;
                    $v['risk_level_name'] = '绝对危险';
                    break;
                case 0;
                    $v['risk_level_name'] = '暂无风险评测';
                    break;
            }
        }
        return $res;
    }
    /**
     * 业主概况(查看自己)
     *
     * @return mixed
     */
    public static function clientDetail($params){
        $data = AdminInfo::select('company_name','address','contact_name','contact_mobile','department','position')
        ->where('admin_id','=',$params['admin_id'])
        ->get();
        return $data;
    }
}