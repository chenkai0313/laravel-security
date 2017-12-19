<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScWorkScheduleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('work_schedule', function(Blueprint $table)
		{
			$table->integer('schedule_id', true)->unsigned()->comment('排班id');
            $table->date('schedule_date')->nullable()->comment('排班时间（某天）');
            $table->timestamp('schedule_time_begin')->nullable()->comment('当天排班-开始时间');
            $table->timestamp('schedule_time_end')->nullable()->comment('当天排班-结束时间');
            $table->timestamps();
            $table->comment = '排班表';
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('work_schedule');
	}

}
