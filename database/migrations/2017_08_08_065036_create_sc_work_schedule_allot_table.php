<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScWorkScheduleAllotTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('work_schedule_allot', function(Blueprint $table)
        {
            $table->integer('allot_id', true)->unsigned()->comment('排班分配id');
            $table->integer('admin_id')->default('0')->comment('关联用户id|admin_id');
            $table->integer('schedule_id')->nullable()->comment('排班id');
            $table->date('schedule_date')->nullable()->comment('排班时间（某天）');
            $table->timestamp('time_begin')->nullable()->comment('上班时间');
            $table->timestamp('time_end')->nullable()->comment('下班时间');
            $table->string('remark')->default(null)->comment('备注');
            $table->timestamps();
            $table->softDeletes();
            $table->comment = '排班关联表';
        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('work_schedule_allot');
	}

}
