<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
                $table->increments('id');
                $table->string('unique_id');
                $table->string('username');
                $table->string('first_name');
                $table->string('last_name');
                $table->string('name');
                $table->string('email')->unique();
                $table->string('token');
                $table->string('provider_type')->default(0);
                $table->string('password');
                $table->text('description')->nullable();
                $table->string('mobile')->default("");
                $table->string('picture')->default(env('APP_URL')."/placeholder.jpg");
                $table->string('token_expiry');
                $table->string('device_token')->default('');
                $table->enum('device_type', ['web','android','ios'])->default('web');
                $table->enum('register_type', ['web','android','ios'])->default('web');
                $table->enum('login_by', ['manual','facebook','google','twitter', 'linkedin'])->default('manual');
                $table->enum('gender', ['male','female','others'])->default('male');
                $table->double('latitude',15,8)->default(0.00);
                $table->double('longitude',15,8)->default(0.00);
                $table->text('full_address')->nullable();
                $table->string('timezone')->default('America/Los_Angeles');
                $table->integer('is_verified')->default(0);
                $table->string('verification_code')->default('');
                $table->string('verification_code_expiry')->default('');
                $table->tinyInteger('status')->default(0);
                $table->timestamp('email_verified_at')->nullable();
                $table->rememberToken();
                $table->timestamps();
            
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('providers');
    }
}
