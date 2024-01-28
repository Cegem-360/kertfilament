<?php

use App\Models\Camp;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Camp::class);
            $table->string('project_name', 100)->nullable(false)->default('');
            $table->string('thematics', 100)->nullable()->default('');
            $table->dateTime('project_start')->nullable(false);
            $table->dateTime('project_end')->nullable(false);
            $table->integer('travel_expenses')->unsigned()->nullable()->default(0);
            $table->string('accommodation', 100)->nullable()->default('');
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
        Schema::dropIfExists('projects');
    }
};
