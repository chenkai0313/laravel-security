<?php
/**
 * 公文流转表
 * Author: caohan
 * Date: 2017/10/30
 */

namespace Modules\Backend\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    protected $table = 'report';

    protected $primaryKey = 'report_id';

    protected $fillable = ['sys_id','report_type', 'report_name', 'report_title', 'admin_id','police_id', 'to_admin_id', 'status', 'file_name',
        'file_path', 'company_name', 'deal_opinion', 'deal_time', 'is_read', 'scan_times', 'risk_level','is_examine','examine_admin_id'];

    use SoftDeletes;

    //修改report状态
    public static function reportChange($params){
        $report = Report::find($params['report_id']);
        $data['status'] = $params['status'];
        $report -> status = $data['status'];
        $res = $report->save();
        return $res;
    }
    /**
     * 业主根据status查找事务
     * 可搜索项（risk_level）
     */
    public static function reportListByStatus($params){
        $limit = isset($params['limit']) ? $params['limit'] : 10;
            if(isset($params['risk_level'])){
                $data = Report::select('*')
                    ->whereIn('status',$params['status'])
                    ->where('to_admin_id','=',$params['admin_id'])
                    ->where('risk_level','=',$params['risk_level'])
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            } else{
                $data = Report::select('*')
                    ->whereIn('status',$params['status'])
                    ->where('to_admin_id','=',$params['admin_id'])
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            }
        }
    /**
     * 民警根据status查找事务
     * 可搜索项（company_name,risk_level）
     */
    public static function reportListByStatusPolice($params){
        $limit = isset($params['limit']) ? $params['limit'] : 10;
        if ( isset($params['keyword']) && isset($params['risk_level'])){
            $data = Report::select('*')
                ->whereIn('status',$params['status'])
                ->where('police_id','=',$params['admin_id'])
                ->where('company_name','like','%'.$params['keyword'].'%')
                ->where('risk_level','=',$params['risk_level'])
                ->orderByDesc('updated_at')
                ->paginate($limit);
            return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
        }else{
            if(isset($params['risk_level'])){
                $data = Report::select('*')
                    ->whereIn('status',$params['status'])
                    ->where('police_id','=',$params['admin_id'])
                    ->where('risk_level','=',$params['risk_level'])
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            }
            if(isset($params['keyword'])){
                $data = Report::select('*')
                    ->whereIn('status',$params['status'])
                    ->where('police_id','=',$params['admin_id'])
                    ->where('company_name','like','%'.$params['keyword'].'%')
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            }
            else{
                $data = Report::select('*')
                    ->whereIn('status',$params['status'])
                    ->where('police_id','=',$params['admin_id'])
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            }
        }
    }
    //业主全部事务
    public static function reportListAll($params){
        $limit = isset($params['limit']) ? $params['limit'] : 10;
        if ( isset($params['keyword']) && isset($params['risk_level']) && isset($params['status'])) {
            $data = Report::select('*')
                ->where('police_id','=',$params['admin_id'])
                ->where('company_name','like','%'.$params['keyword'].'%')
                ->where('risk_level','=',$params['risk_level'])
                ->where('status','=',$params['status'])
                ->orderByDesc('updated_at')
                ->paginate($limit);
            return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
        }
        else {
            if(isset($params['risk_level']) && isset($params['keyword'])){
                $data = Report::select('*')
                    ->where('police_id','=',$params['admin_id'])
                    ->where('risk_level','=',$params['risk_level'])
                    ->where('company_name','like','%'.$params['keyword'].'%')
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            }
            if(isset($params['keyword']) && isset($params['status'])){
                $data = Report::select('*')
                    ->where('police_id','=',$params['admin_id'])
                    ->where('status','=',$params['status'])
                    ->where('company_name','like','%'.$params['keyword'].'%')
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            }
            if(isset($params['risk_level']) && isset($params['status'])){
                $data = Report::select('*')
                    ->where('police_id','=',$params['admin_id'])
                    ->where('status','=',$params['status'])
                    ->where('risk_level','=',$params['risk_level'])
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            }
            if(isset($params['risk_level'])){
//                dd($params);
                $data = Report::select('*')
                    ->where('police_id','=',$params['admin_id'])
                    ->where('risk_level','=',$params['risk_level'])
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            }
            if(isset($params['status'])){
                $data = Report::select('*')
                    ->where('police_id','=',$params['admin_id'])
                    ->where('status','=',$params['status'])
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            }
            if(isset($params['keyword'])){
                $data = Report::select('*')
                    ->where('police_id','=',$params['admin_id'])
                    ->where('company_name','like','%'.$params['keyword'].'%')
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            }
            else{
//                dd(111);
                $data = Report::select('*')
                    ->where('police_id','=',$params['admin_id'])
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            }
        }
    }
    //民警全部事务
    public static function reportListPolice($params){
        $limit = isset($params['limit']) ? $params['limit'] : 10;
        if ( isset($params['keyword']) && isset($params['risk_level']) && isset($params['status'])) {
//            dd(1);
            $data = Report::select('*')
                ->where('police_id','=',$params['admin_id'])
                ->where('company_name','like','%'.$params['keyword'].'%')
                ->where('risk_level','=',$params['risk_level'])
                ->whereIn('status','=',$params['status'])
                ->orderByDesc('updated_at')
                ->paginate($limit);
            return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
        }
        else {
            if(isset($params['risk_level']) && isset($params['keyword'])){
                $data = Report::select('*')
                    ->where('police_id','=',$params['admin_id'])
                    ->where('risk_level','=',$params['risk_level'])
                    ->where('company_name','like','%'.$params['keyword'].'%')
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            }
            if(isset($params['keyword']) && isset($params['status'])){
                $data = Report::select('*')
                    ->where('police_id','=',$params['admin_id'])
                    ->where('status','=',$params['status'])
                    ->where('company_name','like','%'.$params['keyword'].'%')
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            }
            if(isset($params['risk_level']) && isset($params['status'])){
                $data = Report::select('*')
                    ->where('police_id','=',$params['admin_id'])
                    ->where('status','=',$params['status'])
                    ->where('risk_level','=',$params['risk_level'])
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            }
            if(isset($params['status'])){
                $data = Report::select('*')
                    ->where('police_id','=',$params['admin_id'])
                    ->where('status','=',$params['status'])
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            }
            if(isset($params['risk_level'])){
//                dd($params);
                $data = Report::select('*')
                    ->where('police_id','=',$params['admin_id'])
                    ->where('risk_level','=',$params['risk_level'])
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            }
            if(isset($params['keyword'])){
                $data = Report::select('*')
                    ->where('police_id','=',$params['admin_id'])
                    ->where('company_name','like','%'.$params['keyword'].'%')
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            }
            else{
//                dd(111);
                $data = Report::select('*')
                    ->where('police_id','=',$params['admin_id'])
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            }
        }
    }
    //民警未处理事务
    public static function reportListPoliceUnfinish($params){
        $limit = isset($params['limit']) ? $params['limit'] : 10;
        if ( isset($params['keyword']) && isset($params['risk_level']) && isset($params['status'])) {
//            dd(1);
            $data = Report::select('*')
                ->where('police_id','=',$params['admin_id'])
                ->where('company_name','like','%'.$params['keyword'].'%')
                ->where('risk_level','=',$params['risk_level'])
                ->whereIn('status','=',$params['status'])
                ->orderByDesc('updated_at')
                ->paginate($limit);
            return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
        }
        else {
            if(isset($params['risk_level']) && isset($params['keyword'])){
                $data = Report::select('*')
                    ->where('police_id','=',$params['admin_id'])
                    ->where('risk_level','=',$params['risk_level'])
                    ->where('company_name','like','%'.$params['keyword'].'%')
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            }
            if(isset($params['keyword']) && isset($params['status'])){
                $data = Report::select('*')
                    ->where('police_id','=',$params['admin_id'])
                    ->where('status','=',$params['status'])
                    ->where('company_name','like','%'.$params['keyword'].'%')
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            }
            if(isset($params['risk_level']) && isset($params['status'])){
                $data = Report::select('*')
                    ->where('police_id','=',$params['admin_id'])
                    ->where('status','=',$params['status'])
                    ->where('risk_level','=',$params['risk_level'])
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            }
            if(isset($params['risk_level'])){
//                dd($params);
                $data = Report::select('*')
                    ->where('police_id','=',$params['admin_id'])
                    ->where('risk_level','=',$params['risk_level'])
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            }
            if(isset($params['status'])){
                $data = Report::select('*')
                    ->where('police_id','=',$params['admin_id'])
                    ->where('status','=',$params['status'])
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            }
            if(isset($params['keyword'])){
                $data = Report::select('*')
                    ->where('police_id','=',$params['admin_id'])
                    ->where('company_name','like','%'.$params['keyword'].'%')
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            }
            else{
//                dd(111);
                $data = Report::select('*')
                    ->where('police_id','=',$params['admin_id'])
                    ->orderByDesc('updated_at')
                    ->paginate($limit);
                return ['total'=>$data->total() , 'page'=> ceil($data->total()/ $limit),'list'=> $data->items()];
            }
        }
    }
    //添加
    public static function reportAdd($params)
    {
        $add = Report::create($params);
        return $add;
    }

    //编辑
    public static function reportEdit($report_id, $params)
    {
        $edit = Report::where('report_id', $report_id)->update($params);
        return $edit;
    }

    //所有列表
    public static function reportList($params)
    {
        $offset = ($params['page'] - 1) * $params['limit'];
        $report = Report::Search($params)->orderBy('created_at', 'desc')->skip($offset)->take($params['limit'])
            ->get()->toArray();
        return $report;
    }

    //某一用户列表
    public static function reportListByUser($params)
    {
        $offset = ($params['page'] - 1) * $params['limit'];
        $report = Report::Search($params)->where('to_admin_id', $params['admin_id'])->orderBy('created_at', 'desc')->skip($offset)->take($params['limit'])
            ->get()->toArray();
        return $report;
    }

    //民警看 自己发出的
    public static function reportListByAdmin($params)
    {
        $offset = ($params['page'] - 1) * $params['limit'];
        $report = Report::Search($params)->where('examine_admin_id', $params['admin_id'])->orderBy('created_at', 'desc')->skip($offset)->take($params['limit'])
            ->get()->toArray();
        return $report;
    }

    //所有count
    public static function reportCount($params)
    {
        return Report::Search($params)->count();
    }

    //某一用户count
    public static function reportCountByUser($params)
    {
        return Report::Search($params)->where('to_admin_id', $params['admin_id'])
            ->count();
    }

    //详情
    public static function reportDetail($params)
    {
        $report = Report::where($params)->first();
        return $report;
    }

    //批量删除
    public static function reportDel($params)
    {
        $del = Report::destroy($params);
        return $del;
    }

    #查询构造器 Like
    public function scopeSearch($query, $params)
    {
        //TODO 待优化
        return $query->where(function($query) use($params) {
            if (!is_null($params['keyword'])) {
                 $query->where('report_name', 'like', '%' . $params['keyword'] . '%')
                    ->orwhere('report_title', 'like', '%' . $params['keyword'] . '%')
                    ->orwhere('report_id', '=', $params['keyword']);
            }
        }) ->where(function($query) use($params) {
            if (!is_null($params['status']) ) {
                $query->where('status', '=', $params['status']);
            }
        }) ->where(function($query) use($params) {
            if (!is_null($params['is_read']) ) {
                $query->where('is_read', '=', $params['is_read']);
            }
        })->where(['is_examine'=>1]);

    }

    #管理员全部事务
    public static function affairAllList($params)
    {
        $offset = ($params['page'] - 1) * $params['limit'];
        $data = Report::leftJoin('admin_info', 'admin_info.admin_id', '=', 'report.to_admin_id')
            ->select('report.report_id', 'admin_info.company_name', 'report.status', 'admin_info.admin_url', 'report.risk_level', 'report.created_at', 'report.updated_at', 'report.is_read', 'report.deal_time')
            ->Sear($params)
            ->skip($offset)
            ->orderBy('report.created_at', 'desc')
            ->take($params['limit'])
            ->get();
        foreach ($data as $v) {
            switch ($v['status']) {
                case 0;
                    $v['status_name'] = '整改发送';
                    break;
                case  1;
                    $v['status_name'] = '整改中';
                    break;
                case  2;
                    $v['status_name'] = '整改回执';
                    break;
                case  3;
                    $v['status_name'] = '再次整改发送';
                    break;
                case  4;
                    $v['status_name'] = '审核通过';
                    break;
                case  5;
                    $v['status_name'] = '已超时';
                    break;
                case  6;
                    $v['status_name'] = '再次整改回执';
                    break;
            }
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
            switch ($v['is_read']) {
                case 0;
                    $v['is_read_name'] = '未读';
                case 1;
                    $v['is_read_name'] = '已读';
            }
        }
        return $data;
    }

    public function scopeSear($query, $params)
{
    if (isset($params['report_status']) & isset($params['keyword']) & isset($params['risk_level'])) {
        return $query->where('report.status', $params['report_status'])
            ->where('admin_info.company_name', 'like', '%' . $params['keyword'] . '%')
            ->where('report.risk_level', $params['risk_level']);
    } else {
        if (isset($params['report_status']) & isset($params['keyword'])) {
            return $query->where('report.status', $params['report_status'])
                ->where('admin_info.company_name', 'like', '%' . $params['keyword'] . '%');
        }
        if (isset($params['report_status']) & isset($params['risk_level'])) {
            return $query->where('report.status', $params['report_status'])
                ->where('report.risk_level', $params['risk_level']);
        }
        if (isset($params['keyword']) & isset($params['risk_level'])) {
            return $query->where('admin_info.company_name', 'like', '%' . $params['keyword'] . '%')
                ->where('report.risk_level', $params['risk_level']);
        }
        if (isset($params['report_status'])) {
            return $query->where('report.status', $params['report_status']);
        }
        if (isset($params['keyword'])) {
            return $query->where('admin_info.company_name', 'like', '%' . $params['keyword'] . '%');
        }
        if (isset($params['risk_level'])) {
            return $query->where('report.risk_level', $params['risk_level']);
        }
    }
}
    public function scopeCha($query, $params)
{
    if (isset($params['status']) & isset($params['keyword']) & isset($params['risk_level'])) {
        return $query->where('police_id','=',$params['admin_id'])
            ->where('company_name','like','%'.$params['keyword'].'%')
            ->where('risk_level','=',$params['risk_level'])
            ->where('status','=',$params['status']);
    } else {
        if (isset($params['status']) & isset($params['keyword'])) {
            return $query->where('police_id','=',$params['admin_id'])
                ->where('status','=',$params['status'])
                ->where('company_name','like','%'.$params['keyword'].'%');
        }
        if (isset($params['status']) & isset($params['risk_level'])) {
            return $query->where('risk_level','=',$params['risk_level'])
                ->where('police_id','=',$params['admin_id'])
                ->where('status','=',$params['status']);
        }
        if (isset($params['keyword']) & isset($params['risk_level'])) {
            return $query->where('risk_level','=',$params['risk_level'])
                ->where('police_id','=',$params['admin_id'])
                ->where('company_name','like','%'.$params['keyword'].'%');
        }
        if (isset($params['status'])) {
            return $query->where('police_id','=',$params['admin_id'])
                ->where('status','=',$params['status']);
        }
        if (isset($params['keyword'])) {
            return $query->where('police_id','=',$params['admin_id'])
                ->where('company_name','like','%'.$params['keyword'].'%');
        }
        if (isset($params['risk_level'])) {
            return $query->where('police_id','=',$params['admin_id'])
                ->where('risk_level', $params['risk_level']);
        }
    }
}

    #管理员未处理事务(未读)
    public static function unfinshedAllList($params)
    {
        $offset = ($params['page'] - 1) * $params['limit'];
        $data = Report::leftJoin('admin_info', 'admin_info.admin_id', '=', 'report.to_admin_id')
            ->select('report.report_id', 'admin_info.company_name', 'report.status', 'admin_info.admin_url', 'report.risk_level', 'report.created_at', 'report.updated_at', 'report.is_read', 'report.deal_time','report.admin_id')
            ->orwhere(function ($query) use ($params) {
                $query->where('report.admin_id', '=', $params['admin_id'])
                    ->where('report.status', '!=', 4);
            })
            ->Sear($params)
            ->skip($offset)
            ->orderBy('report.created_at', 'desc')
            ->take($params['limit'])
            ->get();
        foreach ($data as $v) {
            switch ($v['status']) {
                case 0;
                    $v['status_name'] = '整改发送';
                    break;
                case  1;
                    $v['status_name'] = '整改中';
                    break;
                case  2;
                    $v['status_name'] = '整改回执';
                    break;
                case  3;
                    $v['status_name'] = '再次整改发送';
                    break;
                case  4;
                    $v['status_name'] = '审核通过';
                    break;
                case  5;
                    $v['status_name'] = '已超时';
                    break;
                case  6;
                    $v['status_name'] = '再次整改回执';
                    break;
            }
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
            switch ($v['is_read']) {
                case 0;
                    $v['is_read_name'] = '未读';
                case 1;
                    $v['is_read_name'] = '已读';
            }
        }
        return $data;
    }

    #管理员已经处理事务
    public static function finshedAllList($params)
    {
        $offset = ($params['page'] - 1) * $params['limit'];
        $data = Report::leftJoin('admin_info', 'admin_info.admin_id', '=', 'report.to_admin_id')
            ->select('report.report_id', 'admin_info.company_name', 'report.status', 'admin_info.admin_url', 'report.risk_level', 'report.created_at', 'report.updated_at', 'report.is_read', 'report.deal_time','report.admin_id')
            ->orwhere(function ($query) use ($params) {
                $query->where('report.status', '=', 4);
            })
            ->Sear($params)
            ->skip($offset)
            ->orderBy('report.created_at', 'desc')
            ->take($params['limit'])
            ->get();
        foreach ($data as $v) {
            switch ($v['status']) {
                case 0;
                    $v['status_name'] = '整改发送';
                    break;
                case  1;
                    $v['status_name'] = '整改中';
                    break;
                case  2;
                    $v['status_name'] = '整改回执';
                    break;
                case  3;
                    $v['status_name'] = '再次整改发送';
                    break;
                case  4;
                    $v['status_name'] = '审核通过';
                    break;
                case  5;
                    $v['status_name'] = '已超时';
                    break;
                case  6;
                    $v['status_name'] = '再次整改回执';
                    break;
            }
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
            switch ($v['is_read']) {
                case 0;
                    $v['is_read_name'] = '未读';
                case 1;
                    $v['is_read_name'] = '已读';
            }
        }
        return $data;
    }

    #业主全部事务
    public static function affairAllListSelf($params)
    {
        $offset = ($params['page'] - 1) * $params['limit'];
        $data = Report::leftJoin('admin_info', 'admin_info.admin_id', '=', 'report.to_admin_id')
            ->select('report.report_id', 'admin_info.company_name', 'report.status', 'admin_info.admin_url', 'report.risk_level', 'report.created_at', 'report.updated_at', 'report.is_read', 'report.deal_time')
            ->where('report.to_admin_id', '=', $params['admin_id'])
            ->Sear($params)
            ->skip($offset)
            ->orderBy('report.created_at', 'desc')
            ->take($params['limit'])
            ->get();
        foreach ($data as $v) {
            switch ($v['status']) {
                case 0;
                    $v['status_name'] = '整改发送';
                    break;
                case  1;
                    $v['status_name'] = '整改中';
                    break;
                case  2;
                    $v['status_name'] = '整改回执';
                    break;
                case  3;
                    $v['status_name'] = '再次整改发送';
                    break;
                case  4;
                    $v['status_name'] = '审核通过';
                    break;
                case  5;
                    $v['status_name'] = '已超时';
                    break;
                case  6;
                    $v['status_name'] = '再次整改回执';
                    break;
            }
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
            switch ($v['is_read']) {
                case 0;
                    $v['is_read_name'] = '未读';
                case 1;
                    $v['is_read_name'] = '已读';
            }
        }
        return $data;
    }
    #业主未处理事务(未读)
    public static function unfinshedAllListSelf($params)
    {
        $offset = ($params['page'] - 1) * $params['limit'];
        $data = Report::leftJoin('admin_info', 'admin_info.admin_id', '=', 'report.to_admin_id')
            ->select('report.report_id', 'admin_info.company_name', 'report.status', 'admin_info.admin_url', 'report.risk_level', 'report.created_at', 'report.updated_at', 'report.is_read', 'report.deal_time')
            ->orwhere(function ($query) use ($params) {
                $query->where('report.to_admin_id', '=', $params['admin_id'])
                    ->where('report.status', '!=', 4);
            })
            ->Sear($params)
            ->skip($offset)
            ->orderBy('report.created_at', 'desc')
            ->take($params['limit'])
            ->get();
        foreach ($data as $v) {
            switch ($v['status']) {
                case 0;
                    $v['status_name'] = '整改发送';
                    break;
                case  1;
                    $v['status_name'] = '整改中';
                    break;
                case  2;
                    $v['status_name'] = '整改回执';
                    break;
                case  3;
                    $v['status_name'] = '再次整改发送';
                    break;
                case  4;
                    $v['status_name'] = '审核通过';
                    break;
                case  5;
                    $v['status_name'] = '已超时';
                    break;
                case  6;
                    $v['status_name'] = '再次整改回执';
                    break;
            }
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
            switch ($v['is_read']) {
                case 0;
                    $v['is_read_name'] = '未读';
                case 1;
                    $v['is_read_name'] = '已读';
            }
        }
        return $data;
    }

    #业主已经处理事务
    public static function finshedAllListSelf($params)
    {
        $offset = ($params['page'] - 1) * $params['limit'];
        $data = Report::leftJoin('admin_info', 'admin_info.admin_id', '=', 'report.to_admin_id')
            ->select('report.report_id', 'admin_info.company_name', 'report.status', 'admin_info.admin_url', 'report.risk_level', 'report.created_at', 'report.updated_at', 'report.is_read', 'report.deal_time')
            ->orwhere(function ($query) use ($params) {
                $query->where('report.to_admin_id', '=', $params['admin_id'])
                    ->where('report.status', '=', 4);
            })
            ->Sear($params)
            ->skip($offset)
            ->orderBy('report.created_at', 'desc')
            ->take($params['limit'])
            ->get();
        foreach ($data as $v) {
            switch ($v['status']) {
                case 0;
                    $v['status_name'] = '整改发送';
                    break;
                case  1;
                    $v['status_name'] = '整改中';
                    break;
                case  2;
                    $v['status_name'] = '整改回执';
                    break;
                case  3;
                    $v['status_name'] = '再次整改发送';
                    break;
                case  4;
                    $v['status_name'] = '审核通过';
                    break;
                case  5;
                    $v['status_name'] = '已超时';
                    break;
                case  6;
                    $v['status_name'] = '再次整改回执';
                    break;
            }
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
            switch ($v['is_read']) {
                case 0;
                    $v['is_read_name'] = '未读';
                case 1;
                    $v['is_read_name'] = '已读';
            }
        }
        return $data;
    }

    #管理员未处理事务个数
    public static function unfinshedAllListCount($params)
    {
        $data = Report::leftJoin('admin_info', 'admin_info.admin_id', '=', 'report.to_admin_id')
            ->select('report.report_id', 'admin_info.company_name', 'report.status', 'admin_info.admin_url', 'report.risk_level', 'report.created_at', 'report.updated_at','report.admin_id')
            ->orwhere(function ($query) use ($params) {
                $query->where('report.admin_id', '=', $params['admin_id'])
                    ->where('report.status', '!=', 4);
            })
            ->orderBy('report.created_at', 'desc')
            ->get();
        return $data;
    }

    #业主未处理事务个数
    public static function unfinshedAllListSelfCount($params)
    {
        $data = Report::leftJoin('admin_info', 'admin_info.admin_id', '=', 'report.to_admin_id')
            ->select('report.report_id', 'admin_info.company_name', 'report.status', 'admin_info.admin_url', 'report.risk_level', 'report.created_at', 'report.updated_at')
            ->orwhere(function ($query) use ($params) {
                $query->where('report.to_admin_id', '=', $params['admin_id'])
                    ->where('report.status', '!=', 4);
            })
            ->orderBy('report.created_at', 'desc')
            ->get();
        return $data;
    }

    #民警未处理事务个数
    public static function unfinshedAllListPoliceCount($params)
    {
        $data = Report::leftJoin('admin_info', 'admin_info.admin_id', '=', 'report.to_admin_id')
            ->select('report.report_id', 'admin_info.company_name', 'report.status', 'admin_info.admin_url', 'report.risk_level', 'report.created_at', 'report.updated_at')
            ->orwhere(function ($query) use ($params) {
                $query->where('report.admin_id', '=', $params['admin_id'])
                    ->where('report.status', '!=', 4);
            })
            ->orderBy('report.created_at', 'desc')
            ->get();
        return $data;
    }
    #民警
    #民警全部事务
    public static function affairAllListPolice($params)
    {
        $offset = ($params['page'] - 1) * $params['limit'];
        $data = Report::leftJoin('admin_info', 'admin_info.admin_id', '=', 'report.to_admin_id')
            ->select('report.report_id', 'admin_info.company_name', 'report.status', 'admin_info.admin_url', 'report.risk_level', 'report.created_at', 'report.updated_at', 'report.is_read', 'report.deal_time')
            ->where('report.admin_id', '=', $params['admin_id'])
            ->Sear($params)
            ->skip($offset)
            ->orderBy('report.created_at', 'desc')
            ->take($params['limit'])
            ->get();
        foreach ($data as $v) {
            switch ($v['status']) {
                case 0;
                    $v['status_name'] = '整改发送';
                    break;
                case  1;
                    $v['status_name'] = '整改中';
                    break;
                case  2;
                    $v['status_name'] = '整改回执';
                    break;
                case  3;
                    $v['status_name'] = '再次整改发送';
                    break;
                case  4;
                    $v['status_name'] = '审核通过';
                    break;
                case  5;
                    $v['status_name'] = '已超时';
                    break;
                case  6;
                    $v['status_name'] = '再次整改回执';
                    break;
            }
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
            switch ($v['is_read']) {
                case 0;
                    $v['is_read_name'] = '未读';
                case 1;
                    $v['is_read_name'] = '已读';
            }
        }
        return $data;
    }

    #民警未处理事务(未读)
    public static function unfinshedAllListPolice($params)
    {
        $offset = ($params['page'] - 1) * $params['limit'];
        $data = Report::leftJoin('admin_info', 'admin_info.admin_id', '=', 'report.to_admin_id')
            ->select('report.report_id', 'admin_info.company_name', 'report.status', 'admin_info.admin_url', 'report.risk_level', 'report.created_at', 'report.updated_at', 'report.is_read', 'report.deal_time')
            ->orwhere(function ($query) use ($params) {
                $query->where('report.admin_id', '=', $params['admin_id'])
                    ->where('report.status', '!=', 4);
            })
            ->Sear($params)
            ->skip($offset)
            ->orderBy('report.created_at', 'desc')
            ->take($params['limit'])
            ->get();
        foreach ($data as $v) {
            switch ($v['status']) {
                case 0;
                    $v['status_name'] = '整改发送';
                    break;
                case  1;
                    $v['status_name'] = '整改中';
                    break;
                case  2;
                    $v['status_name'] = '整改回执';
                    break;
                case  3;
                    $v['status_name'] = '再次整改发送';
                    break;
                case  4;
                    $v['status_name'] = '审核通过';
                    break;
                case  5;
                    $v['status_name'] = '已超时';
                    break;
                case  6;
                    $v['status_name'] = '再次整改回执';
                    break;
            }
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
            switch ($v['is_read']) {
                case 0;
                    $v['is_read_name'] = '未读';
                case 1;
                    $v['is_read_name'] = '已读';
            }
        }
        return $data;
    }

    #民警已经处理事务
    public static function finshedAllListPolice($params)
    {
        $offset = ($params['page'] - 1) * $params['limit'];
        $data = Report::leftJoin('admin_info', 'admin_info.admin_id', '=', 'report.to_admin_id')
            ->select('report.report_id', 'admin_info.company_name', 'report.status', 'admin_info.admin_url', 'report.risk_level', 'report.created_at', 'report.updated_at', 'report.is_read', 'report.deal_time')
            ->orwhere(function ($query) use ($params) {
                $query->where('report.admin_id', '=', $params['admin_id'])
                    ->where('report.status', '=', 4);
            })
            ->Sear($params)
            ->skip($offset)
            ->orderBy('report.created_at', 'desc')
            ->take($params['limit'])
            ->get();
        foreach ($data as $v) {
            switch ($v['status']) {
                case 0;
                    $v['status_name'] = '整改发送';
                    break;
                case  1;
                    $v['status_name'] = '整改中';
                    break;
                case  2;
                    $v['status_name'] = '整改回执';
                    break;
                case  3;
                    $v['status_name'] = '再次整改发送';
                    break;
                case  4;
                    $v['status_name'] = '审核通过';
                    break;
                case  5;
                    $v['status_name'] = '已超时';
                    break;
                case  6;
                    $v['status_name'] = '再次整改回执';
                    break;
            }
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
            switch ($v['is_read']) {
                case 0;
                    $v['is_read_name'] = '未读';
                case 1;
                    $v['is_read_name'] = '已读';
            }
        }
        return $data;
    }
    #根据admin_id查询所属业主的sys_id
    public static function sysList($params){
        $data = Report::select('sys_id')->where('to_admin_id','=',$params['admin_id'])->get()->toArray();
        if($data){
            foreach ($data as $k => $v){
                if(!empty($v['sys_id'])){
                    $sys_id[] = $v['sys_id'];
                }
            }
            $a = implode(',',$sys_id);
            $b = explode(',',$a);
            $c = array_unique($b);
            return ['sys_id'=>$c];
        }else{
            return null;
        }

    }
}