<?php

namespace Modules\Backend\HTTP\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Entrust;

class jwtAdmin
{
    public function handle($request, Closure $next)
    {
        $this->registerJWTConfig();
        #获取当前路由器信息
        $request_info = request()->route()->getAction();
        $arr = explode('@',$request_info['controller']);
        #若非登录页面，则验证JWT与RBAC
        if($arr['1']!='adminLogin'){
            if($arr['1']=='login'){
            }else{


            #验证登录   JWT
            try {
                $payload = JWTAuth::parseToken()->getPayload();
                $from = $payload->get('from');
                if (!$from=='admin' || !$user = JWTAuth::parseToken()->authenticate()) {
                    return ['code' => 10094,'msg' => '找不到该管理员'];
                }
            } catch (Exception $e) {
                if ($e instanceof  TokenInvalidException)
                    return ['code'=>10091,'msg'=>'token信息不合法'];
                else if ($e instanceof TokenExpiredException) {
                    return ['code'=>10092,'msg'=>'登录信息过期'];
                }else{
                    return ['code'=>10093,'msg'=>'登录验证失败'];
                }
            }
            #验证权限   RBAC
            if(!Entrust::user()->is_super){//判断是否超级管理员
                $free = [
                    'model'=>$arr['1']
                ];
                if( $this->freeRoutes($free) ){
                }else{
                    if(!Entrust::can($arr['1'])){
                        return ['code'=>10015,'msg'=>'无权操作'];
                    }
                }
            }
            }
        }
        return $next($request);
    }


    protected function registerJWTConfig()
    {
        \Config::set('jwt.user' , 'Modules\Backend\Models\Admin');
        \Config::set('auth.providers.users.table', 'admins');
        \Config::set('auth.providers.users.model', \Modules\Backend\Models\Admin::class);
        \Config::set('jwt.identifier' , 'admin_id');
        \Config::set('cache.default','array');//RBAC
    }

    // 过滤免权限接口
    protected function freeRoutes($params){
        $free = [
            'permissionLeft',      //菜单
            'unfinishReportCount', //待办事务计数
            'inmailUnreadCount',   //当前存在未读信息个数
            'inmailSearchUser',    //模糊查找用户
            'inmailEditStatus',    //修改站内信状态（未读->已读 支持批量修改）
            'adminListAll',
            'reportTimeRefresh', //检查report 状态是否超时
            'receiptRead',       //receipt-read 修改回执已读
            'login',
            'roleListAll',
            'adminChangePassword', //修改密码
            'downloadRecord',      //下载文件
        ];
        if(in_array($params['model'],$free)){
            return true;
        }else{
            return false;
        }
    }
}
