<?php
/**
 * 网络预警（公告）
 * User: 张燕
 * Date: 2017/10/30
 * Time: 10:46
 */

namespace Modules\Backend\Models;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use SoftDeletes;
    protected $table = 'notices';
    protected $primaryKey = 'notice_id';
    protected $fillable = ['notice_title','notice_content','admin_id','desc'];
    protected $dates = ['deleted_at'];
    /**
     * 公告 列表
     * @params int $limit 每页显示数量
     * @params int $page 当前页数
     * @params string $keyword 关键词
     * @return array
     */
    public static function noticeList($params)
    {
        $limit = isset($params['limit']) ? $params['limit'] : 10;
        $params['keyword'] = isset($params['keyword']) ? $params['keyword'] : null;
        $data = Notice::select([ 'notice_id' , 'notice_title' , 'notice_content' , 'desc' ,'admin_id','created_at'] )
            ->where('notice_title','like','%'.strip_tags($params['keyword']).'%')
            ->orderByDesc('notice_id')
            ->orderByDesc('created_at')
            ->paginate($limit);
        $res['total'] = $data->total();
        $res['page'] = ceil($data->total() / $limit);
        $res['list'] = $data -> items();
        return $res;
    }
    /**
     * 添加公告
     * @return array
     */
    public static function noticeAdd($params)
    {
        $res = Notice::create($params);
        return $res->notice_id;
    }
    /**
     * 编辑公告
     * string $notice_title 公告标题
     * string $notice_content 公告内容
     * string $admin_id 操作员ID
     * @return array
     */
    public static function noticeEdit($params)
    {
        $data = Notice::find($params['notice_id']);
        $data -> notice_title = $params['notice_title'];
        $data -> notice_content = $params['notice_content'];
        $data -> desc = $params['desc'];
        $data -> admin_id = $params['admin_id'];
        $res = $data->save();
        return $res;
    }
    /**
     * 删除公告
     * string $notice_id 公告id
     * @return array
     */
    public static function noticeDelete($params)
    {
      $res = Notice::where('notice_id',$params['notice_id'])->delete();
      return $res;
    }
    /**
     * 公告详情
     * string $notice_id 公告id
     * string $notice_title 公告标题
     * string $notice_content 公告内容
     * string $admin_id 操作员ID
     * string $create_time 创建时间
     * @return array
     */
    public static function noticeDetail($params)
    {
        $data = Notice::select(['notice_id','notice_title','notice_content','desc','admin_id','created_at'])
            ->where('notice_id',$params['notice_id'])->first();
        return $data;
    }
    /**
     * 最新公告
     * string $notice_id 公告id
     * string $notice_title 公告标题
     * string $notice_content 公告内容
     * string $admin_id 操作员ID
     * string $create_time 创建时间
     * @return array
     */
    public static function noticeNew()
    {
        $data = $data = Notice::select(['notice_id','notice_title','notice_content','desc','admin_id','created_at'])
            ->orderByDesc('created_at')
            ->limit(2)
            ->get();
        return $data;
    }
}