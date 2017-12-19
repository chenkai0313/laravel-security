<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScAdminsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (!Schema::hasTable('admins')) {
            Schema::create('admins', function(Blueprint $table)
            {
                $table->increments('admin_id')->unique('admin_id');
                $table->string('admin_name', 12)->nullable()->default('')->comment('账号');
                $table->string('admin_nick', 12)->nullable()->default('')->comment('昵称');
                $table->boolean('admin_sex')->nullable()->default(1)->comment('性别（0保密，1男，2.女）');
                $table->string('admin_password', 60)->comment('密码');
                $table->date('admin_birthday')->nullable()->comment('生日');
                $table->string('admin_mobile',20)->default('')->comment('手机');
                $table->string('remember_token', 100)->nullable()->default('');
                $table->boolean('is_super')->nullable()->default(0)->comment('是否超级管理员（0否，1是）');
                $table->string('province',9)->default('')->comment('省');
                $table->string('city',9)->default('')->comment('市');
                $table->string('district',9)->default('')->comment('区');
                $table->string('address', 64)->nullable()->default('')->comment('详细地址');
                $table->string('login_ip', 64)->nullable()->default('')->comment('最后登录ip');
                $table->timestamp('login_at')->nullable()->comment('最后登录时间');
                $table->tinyInteger('is_first')->default(0)->comment('第一次使用密码是否修改 0未修改 1已修改');
                $table->string('remark', 64)->nullable()->default('')->comment('备注');
                $table->timestamps();
                $table->softDeletes();
                $table->comment = '管理员表';
            });
        }

        if (!Schema::hasTable('admin_info')) {
            Schema::create('admin_info', function(Blueprint $table)
            {
                $table->increments('info_id')->unique('info_id');
                $table->integer('admin_id')->default('0');
                $table->integer('scan_times_count')->default('0')->comment('扫描次数');
                $table->string('admin_url')->nullable()->default('')->comment('网址');
                $table->string('company_name')->nullable()->default('')->comment('单位名称');
                $table->string('position',100)->nullable()->default('')->comment('职位');
                $table->string('department',100)->nullable()->default('')->comment('部门');
                $table->timestamps();
                $table->softDeletes();
                $table->comment = '管理员信息关联表';
            });
        }
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('admins');
		Schema::dropIfExists('admin_info');
	}

}
