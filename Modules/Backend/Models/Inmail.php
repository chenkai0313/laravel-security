<?php
/**
 * 站内信
 * Author: CK
 * Date: 2017/10/30
 */

namespace Modules\Backend\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inmail extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = 'inmail';

    protected $primaryKey = 'inmail_id';

    protected $fillable = ['inmail_content', 'sender_id', 'receiver_id', 'status', 'pid', 'inmail_id', 'inmail_title'];


    /**
     * 添加站内信
     * @param $params ['inmail_content']  内容
     * @param $params ['sender_id']  发件人ID
     * @param $params ['receiver_id']  收件人ID
     * @param $params ['status']  状态（0 未读 1已读）
     * @param $params ['pid']  所属上一条ID
     * @return array
     */
    public static function InmailAdd($params)
    {
        return Inmail::create($params);
    }

    /**
     * 站内信的状态改变（未读->已读）
     * @return array
     */
    public static function inmailEditStatus($params)
    {
        $data = Inmail::find($params['inmail_id']);
        if($data['status']==0){
            if($data['sender_id']!==$params['user_id']){
                $data->status = 1;
                $data->status_at = date("Y-m-d H:i:s", time());
                $result = $data->update();
            }elseif($data['sender_id']==$params['user_id']){
                $data->status = 0;
                $result = $data->update();
            }
        }elseif($data['status']==1){
                $data->status = 1;
                $result = $data->update();
        }
        return $result;
    }

    /**
     * 查看聊天历史记录
     *
     * @return array
     */
    public static function inmailHistory($params)
    {
        $offset = ($params['page'] - 1) * $params['limit'];
        $data = Inmail::select('inmail_id', 'inmail_content', 'sender_id', 'receiver_id',
            'status', 'created_at')
            ->where(function ($query) use ($params) {
                $query->where('sender_id', $params['sender_id'])
                    ->where('receiver_id', $params['receiver_id']);
            })
            ->orwhere(function ($query) use ($params) {
                $query->where('sender_id', $params['receiver_id'])
                    ->where('receiver_id', $params['sender_id']);
            })
            ->skip($offset)
            ->take($params['limit'])
            ->orderBy('created_at', 'desc')
            ->get();
        foreach ($data as $v) {
            $name = AdminInfo::whereIn('admin_id', [$params['sender_id'], $params['receiver_id']])->get();
            foreach ($name as $m) {
                if ($m['admin_id'] == $v['sender_id']) {
                    $v['sender_name'] = $m['company_name'];
                } elseif ($m['admin_id'] == $v['receiver_id']) {
                    $v['receiver_name'] = $m['company_name'];
                }
            }
        }
        return $data;
    }

    public static function inmailHistoryCount($params)
    {
        $data = Inmail::select('inmail_id', 'inmail_content', 'sender_id', 'receiver_id',
            'status', 'created_at')
            ->where(function ($query) use ($params) {
                $query->where('sender_id', $params['sender_id'])
                    ->where('receiver_id', $params['receiver_id']);
            })
            ->orwhere(function ($query) use ($params) {
                $query->where('sender_id', $params['receiver_id'])
                    ->where('receiver_id', $params['sender_id']);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        return count($data);
    }

    /**
     * 模糊查找用户
     *
     * @return array
     */
    public static function inmailSearchUser($params)
    {
        return AdminInfo::select('company_name', 'admin_id')->where('company_name', 'like', '%' . $params['company_name'] . '%')->get();
    }

    /**
     * 删除站内信（支持批量删除）
     *
     * @return array
     */
    public static function inmailDelete($inmail_id)
    {
        return $res = Inmail::destroy($inmail_id);
    }

    /**
     * 站内信列表
     *
     * @return array
     */
    public static function inmailList($params)
    {
        $offset = ($params['page'] - 1) * $params['limit'];
        $mailSing = $params['mailsign']; // 1是收件， 2是发件
        if ($mailSing == 1) {
          $data = Inmail::select('sender_id','receiver_id', 'status', 'inmail_content','inmail_title', 'created_at', 'inmail_id')
              ->where(function ($query) use ($params) {
                  $query->where('receiver_id', $params['user_id']);
                      // ->orwhere('receiver_id', $params['user_id']);
              })
              ->Search($params)
              ->skip($offset)
              ->orderBy('created_at', 'desc')
              ->take($params['limit'])
              ->get();
        } else if ($mailSing == 2) {
          $data = Inmail::select('sender_id','receiver_id', 'status', 'inmail_content','inmail_title', 'created_at', 'inmail_id')
              ->where(function ($query) use ($params) {
                  $query->where('sender_id', $params['user_id']);
                      // ->orwhere('receiver_id', $params['user_id']);
              })
              ->Search($params)
              ->skip($offset)
              ->orderBy('created_at', 'desc')
              ->take($params['limit'])
              ->get();
        }
        foreach ($data as $v) {
            $sender_name = AdminInfo::find($v['sender_id']);
            $v['sender_name'] = $sender_name['company_name'];
            if(is_null($v['sender_name'])){
                $v['sender_name']='该用户不存在';
            }
            switch ($v['status']) {
                case 0;
                    $v['status_name'] = '未读';
                    break;
                case 1;
                    $v['status_name'] = '已读';
                    break;
            }
        }
        return $data;
    }
    public function scopeSearch($query, $params)
    {
        if(isset($params['status']) && isset($params['keyword']) ){
            $admin_id=AdminInfo::select('admin_id')->where('company_name','like','%'.$params['keyword'].'%');
            return   $query->whereIn('sender_id',$admin_id)
                       ->where('status','=', $params['status']);
        }else{
            if (isset($params['keyword'])) {
                $admin_id=AdminInfo::select('admin_id')->where('company_name','like','%'.$params['keyword'].'%');
                return   $query->whereIn('sender_id',$admin_id);
            }
            if(isset($params['status'])){
                return   $query->where('status','=', $params['status']);
            }
        }


    }

    public static function inmailListCount($params)
    {
        $data = Inmail::select('sender_id','receiver_id', 'status', 'inmail_content','inmail_title', 'created_at', 'inmail_id')
            ->where(function ($query) use ($params) {
                $query->where('sender_id', $params['user_id'])
                    ->orwhere('receiver_id', $params['user_id']);
            })
            ->Search($params)
            ->orderBy('created_at', 'desc')
            ->get();
        return count($data);
    }

    /**
     * 当前存在未读信息个数
     *
     * @return array
     */
    public static function inmailUnreadCount($params)
    {
        $data = Inmail::select('sender_id', 'status')
            ->where(function ($query) use ($params) {
                $query->where('receiver_id', $params['user_id'])
                    ->where('status', 0);
            })
            ->get();
        return count($data);
    }

    /**
     * 站内信详情
     * @return array
     */
    public static function inmailDetail($params)
    {
        $data = Inmail::leftJoin('admin_info', 'admin_info.admin_id', '=', 'inmail.sender_id')
            ->select('inmail.inmail_id', 'inmail.inmail_title', 'inmail.inmail_content', 'inmail.created_at', 'admin_info.company_name')
            ->where('inmail.inmail_id', $params['inmail_id'])
            ->first();
        $data['sender_name'] = $data['company_name'];
        unset($data['company_name']);
        return $data;
    }
}
