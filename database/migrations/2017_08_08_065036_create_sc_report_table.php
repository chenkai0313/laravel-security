<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScReportTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('report', function(Blueprint $table) {
            $table->increments('report_id');
            $table->string('report_type')->default(null)->comment('公文类型');
            $table->string('report_name')->default(null)->comment('公文名称');
            $table->integer('admin_id')->default(0)->comment('发送人');
            $table->string('report_title')->default(null)->comment('报告标题');
            $table->string('deal_opinion')->default('')->comment('处理意见');
            $table->integer('to_admin_id')->default(0)->comment('接收人');
            $table->tinyInteger('status')->default(0)->comment('状态 暂定0整改发送，1整改中，2整改回执，3再次整改发送，4审核通过  5已超时  6再次整改回执');
            $table->string('company_name')->default('')->comment('业主名称');
            $table->string('file_name')->default('')->comment('回执附件名');
            $table->string('file_path')->default('')->comment('回执附件路径');
            $table->tinyInteger('is_read')->default(0)->comment('已读未读 0未读  1已读');
            $table->tinyInteger('risk_level')->default(0)->comment('风险等级 1 绝对安全  2 比较安全  3 相对危险   4 绝对危险');
            $table->integer('scan_times')->default(0)->comment('扫描次数');
            $table->integer('is_examine')->default(0)->comment('是否审核通过  0未通过 1通过 2拒绝');
            $table->integer('examine_admin_id')->default(0)->comment('审核员ID （民警ID）');
            $table->timestamp('deal_time')->comment('建议处理时间 （截止时间）');
            $table->timestamps();
            $table->softDeletes();
            $table->comment = '报告基础表';
        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('report');
	}

}
