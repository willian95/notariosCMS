<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectSecondaryImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_secondary_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("project_id");
            $table->foreign("project_id")->references("id")->on("projects");
            $table->string("image");
            $table->string("type");
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
        Schema::dropIfExists('project_secondary_images');
    }
}
