<?php

use App\Models\Person;
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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('foundation_name', 100)->nullable(FALSE)->default('Különleges Ellátásban Részesülők Támogatásáért Alapítvány');
            $table->string('foundation_headquarters', 100)->nullable(FALSE)->default('3100 Salgótarján, Úttörők útja 15.');
            $table->string('foundation_tax_identification_number', 100)->nullable(FALSE)->default('18649954-1-12');
            $table->dateTime('donation_date',)->nullable(FALSE);
            $table->foreignId('person_id')->references('id')->on('people')->onDelete('cascade'); //account number
            $table->integer('donation_amount')->unsigned()->nullable()->default(0);
            $table->enum('donation_type',['Tabor','Penz','Lelkigondozas'])->nullable()->default('Penz');
            $table->foreignId('family_id')->nullable()->default(null)->references('id')->on('families')->onDelete('cascade'); //account number
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
        Schema::dropIfExists('donations');
    }
};
