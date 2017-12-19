<?php
/**
 * 公文回执表
 * Author: caohan
 * Date: 2017/10/30
 */
namespace Modules\Backend\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{

    use SoftDeletes;

    protected $table      = 'receipt';

    protected $primaryKey = 'receipt_id';

    protected $fillable = ['report_id','report_info','admin_id','report_admin_id','file_name',
        'file_path','receipt_nick','is_read'];


    public static function receiptAdd($params) {
        $add = Receipt::create($params);
        return $add;
    }

    public static function receiptEdit($receipt_id,$params) {
        $edit = Receipt::where('receipt_id',$receipt_id )->update($params);
        return $edit;
    }

    /**
     * @param $params['report_id']
     * @return array
     */
    public static function receiptList($params) {
        $receipt = Receipt::where($params)
            ->orderBy('receipt_id', 'asc')
            ->get()->toArray();
        return $receipt;
    }


    public static function receiptDetail($params) {
        $receipt = Receipt::where($params)->first();
        return $receipt;
    }

    public static function receiptDel($params) {
        $del =  Receipt::destroy($params);
        return $del;
    }


    public static function receiptUserCount($params) {
        $count = Receipt::where($params)->count();
        return $count;
    }

}