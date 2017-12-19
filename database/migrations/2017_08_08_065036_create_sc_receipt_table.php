<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScReceiptTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('receipt', function(Blueprint $table)
		{
			$table->increments('receipt_id')->comment('回执 prikey');
			$table->integer('report_id')->default(0)->comment('报告id');
			$table->string('report_info')->nullable()->comment('暂定 回执的信息或者留言');
            $table->integer('admin_id')->default(0)->comment('回执发送人');
            $table->integer('report_admin_id')->default(0)->comment('该公文所属人的ID(即to_admin_id)');
			$table->string('file_name')->default('')->comment('回执附件名');
			$table->string('file_path')->default('')->comment('回执附件路径');
			$table->string('receipt_nick')->default('')->comment('发回执的人的nick');
            $table->tinyInteger('is_read')->default(0)->comment('已读未读 0未读');
            $table->timestamps();
            $table->softDeletes();
            $table->comment = '回执流水表';
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('receipt');
	}

}
