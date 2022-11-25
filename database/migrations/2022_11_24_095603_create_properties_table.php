<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('entity_id');
            $table->foreignIdFor(\App\Models\Engine::class);
            $table->string('title');
            $table->text('address');
            $table->text('image_address');
            $table->text('description');
            $table->text('type');
            $table->json('metadata');
            $table->smallInteger('status')->default(1);
            $table->float('price');
            $table->timestamps();
            $table->unique(['entity_id', 'engine_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
};
