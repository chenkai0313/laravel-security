<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScInmailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inmail', function(Blueprint $table)
		{
			$table->increments('inmail_id');
            $table->string('inmail_title')->default('')->comment('主题');
            $table->text('inmail_content')->comment('站内信内容');
			$table->integer('sender_id')->comment('发件人id(创建人)');
			$table->integer('receiver_id')->comment('收件人ID');
			$table->timestamp('status_at')->nullable()->comment('(读取时间 当状态从未读到已读)');
			$table->tinyInteger('status')->default(0)->comment('发送状态（是否已经读取 0未读 1已读 ）');
			$table->timestamps();
            $table->softDeletes();
            $table->engine = 'MyISAM';
			$table->comment = '站内信';
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('inmail');
	}

}
