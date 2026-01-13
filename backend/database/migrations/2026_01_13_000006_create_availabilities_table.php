<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained('merchants')->onDelete('cascade');
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->tinyInteger('weekday')->nullable(); // 0 (Sun) - 6 (Sat)
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->date('date')->nullable(); // specific date for exceptions
            $table->boolean('recurring')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('availabilities');
    }
};
