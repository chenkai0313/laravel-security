<?php
/**
 * 管理员模块
 * Author: 葛宏华
 * Date: 2017/7/25
 */
namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Gregwar\Captcha\CaptchaBuilder;
use Session;
use Cache;

class AdminController extends Controller
{
    /**
     * 管理员列表
     */
    public  function adminList(Request $request)
    {
        $params = $request->all();
        $result = \AdminService::adminList($params);
        return $result;
    }
    /**
     * 民警列表
     */
    public  function policeList(Request $request)
    {
        $params = $request->all();
        $result = \AdminService::policeList($params);
        return $result;
    }
    /**
     * 民警列表
     */
    public  function policeLists(Request $request)
    {
        $params = $request->all();
        $result = \AdminService::policeList($params);
        return $result;
    }
    /**
     * 管理员列表-所有用户
     */
    public  function adminListAll(Request $request)
    {
        $params = $request->all();
        $result = \AdminService::adminListAll($params);
        return $result;
    }
    /**
     * 管理员添加
     */
    public function adminAdd(Request $request)
    {
        $params = $request->all();
        $result = \AdminService::adminAdd($params);
        return $result;
    }
    /**
     * 管理员编辑
     */
    public function adminEdit(Request $request)
    {
        $params = $request->all();
        $result = \AdminService::adminEdit($params);
        return $result;
    }
    /**
     * 管理员删除
     */
    public function adminDelete(Request $request)
    {
        $params = $request->all();
        $result = \AdminService::adminDelete($params);
        return $result;
    }
    /**                                                                                                 Í
     * 管理员详细
     */
    public function adminDetail(Request $request)
    {
        $params = $request->all();
        $result = \AdminService::adminDetail($params['admin_id']);
        return $result;
    }
    /**
     * 管理员登录
     */
    public function adminLogin(Request $request)
    {
        $params = $request->all();
        \Log::info('adminLogin');
        \Log::info($request->session()->all());
        $params['record_ip']=$request->getClientIp();
        $result = \AdminService::adminLogin($params);
        return $result;
    }

    /**
     * 用户修改password
     */
    public function adminChangePassword(Request $request) {
        $params = $request->input();
        $params['admin_id'] = get_admin_id();
        $result = \AdminService::adminChangePassword($params);
        return $result;
    }

    /**
     * 验证码生成
     * @params  [type] $tmp [description]
     */
    public function qrcode($tmp){
        //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder;
        //可以设置图片宽高及字体
        $builder->build($width = 100, $height = 40, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();
        //把内容存入session
        $key = $tmp;
        $key = (string)$key;

        //$request->session()->flash($key,$phrase);
        session([$key=>$phrase]);
        \Log::info($tmp);
        \Log::info(session($key));
        \Log::info($key);
        $value111 = Session::all();
        \Log::info($value111);
        //return $phrase;
        //生成图片
        /*header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $builder->output();*/
        //ob_clean(); //清除缓存
        $return = base64_decode(response($builder->output())->header('Content-type','image/jpeg')); //把验证码数据以jpeg图片的格式输出

        return ['code'=>1, 'data'=>base64_decode($return)];
    }

    public function check_code(Request $request) {
        //return $request->session()->all();
        $params = $request->input();
        $key = $params['verification_code'];
        $key = (string)$key;
        if( session($key) != $params['code']) {
            return array("code"=>2,"msg"=>"验证码错误");
        }
        else{
            return ['code'=>1,'msg'=>'sucess'];
        }
    }

    public function login(Request $request){
        $params = $request->all();
        $result = \AdminService::login($params);
        return $result;
    }
    public function webAdd(Request $request){
        $params = $request->all();
        $result = \AdminService::webAdd($params);
        return $result;
    }
    public function webEdit(Request $request){
        $params = $request->all();
        $result = \AdminService::webEdit($params);
        return $result;
    }
    public function webList(Request $request){
        $params = $request->all();
        $result = \AdminService::webList($params);
        return $result;
    }
    public function webDelete(Request $request){
        $params = $request->all();
        $result = \AdminService::webDelete($params);
        return $result;
    }

}
