<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spaces', function (Blueprint $table) {
                $table->increments('id');
                $table->string('unique_id');
                $table->integer('provider_id');
                $table->string('name');
                $table->text('tagline');
                $table->string('space_type')->default('');
                $table->text('description');
                $table->string('picture')->default(env('APP_URL')."/space-placeholder.jpg");
                $table->text('full_address')->nullable();
                $table->text('instructions')->nullable();
                $table->float('per_hour')->default(0.00);
                $table->tinyInteger('is_admin_verified')->default(0);
                $table->tinyInteger('admin_status')->default(0);
                $table->tinyInteger('status')->default(0);
                $table->string('uploaded_by')->default(PROVIDER);
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
        Schema::dropIfExists('spaces');
    }
}
