<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScNoticesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notices', function(Blueprint $table)
		{
			$table->integer('notice_id', true);
            $table->string('notice_title')->default('')->comment('标题');
            $table->text('notice_content')->comment('内容');
			$table->integer('admin_id')->nullable()->default(0)->comment('操作者ID');
            $table->timestamps();
            $table->softDeletes();
            $table->comment = '公告表';
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('notices');
	}

}
