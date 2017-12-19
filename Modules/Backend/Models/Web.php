<?php
/**
 * Created by PhpStorm.
 * User: zy
 * Date: 2017/12/7
 * Time: 14:56
 */

namespace Modules\Backend\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Web extends Model
{
    use SoftDeletes;
    protected $table      = 'web';

    protected $primaryKey = 'web_id';

    protected $fillable = array('admin_id','web_name','web_link');
    /**
     * 添加业主网站
     * return $array
     */
    public static function webAdd($params){
        if(isset($params['s'])){
            unset($params['s']);
        }
        $res = Web::create($params);
        return $res;
    }
    /**
     * 编辑业主网站
     * return $array
     */
    public static function webEdit($params){
        $data = Web::find($params['web_id']);
        $data->web_name = $params['web_name'];
        $data->web_link = $params['web_link'];
        $res = $data->save();
        return $res;
    }
    /**
     * 业主网站列表
     * return $array
     */
    public static function webList($params){
        $data = Web::select('*')
            ->Where('admin_id', '=', $params['admin_id'])
            ->get();
        return $data;
    }
    /**
     * 删除业主网站
     * return $array
     */
    public static function webDelete($params){
        $res = Web::where('web_id','=',$params['web_id'])
            ->delete();
        return $res;
    }
}