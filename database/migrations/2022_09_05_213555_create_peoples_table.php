<?php

use App\Models\Family;
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
        Schema::create('people', function (Blueprint $table) {
            //personal
            $table->id();
            $table->string('full_name', 100)->nullable()->default('');
            $table->dateTime('date_of_birth')->nullable();
            $table->string('birth_name', 100)->nullable()->default('');
            $table->string('place_of_birth', 100)->nullable()->default('');
            $table->string('mobile_number', 100)->nullable()->default('');
            $table->string('postal_code', 100)->nullable()->default('');
            $table->string('postal_city', 100)->nullable()->default('');
            $table->string('postal_street', 100)->nullable()->default('');
            $table->string('tax_identification_number', 100)->nullable(FALSE)->unique();
            $table->string('email', 100)->nullable()->default('');
            $table->string('status', 100)->nullable()->default('Támogatott');
            $table->string('account_number', 100)->nullable();
            $table->string('company_name', 100)->nullable()->default('');
            $table->string('mother_birth_name', 100)->nullable()->default('');
            $table->string('dead_name', 100)->nullable()->default('');
            $table->foreignIdFor(Family::class, 'family_id');
            $table->dateTime('dead_date')->nullable();
            $table->string('damaged')->nullable()->default("nem");
            $table->string('dead_mother_certificate', 100)->nullable()->default('');


            //company

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
        Schema::dropIfExists('people');
    }
};
