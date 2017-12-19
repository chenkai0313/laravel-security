<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportExamineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_examine', function(Blueprint $table) {
            $table->increments('examine_id');
            $table->integer('report_id')->default(0)->comment('公文ID');
            $table->string('report_name')->default(null)->comment('公文名称');
            $table->integer('examine_admin_id')->default(0)->comment('审核人ID（民警ID）');
            $table->string('examine_add_admin_id')->default(null)->comment('添加的人（运维）');
            $table->string('examine_info')->default('')->comment('审核留言');
            $table->integer('is_examine')->default(0)->comment('是否审核通过  0未通过 1通过 2拒绝');
            $table->timestamps();
            $table->softDeletes();
            $table->comment = '报告发布前的审核表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('report_examine');
    }
}
