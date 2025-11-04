<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grade_scales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');
            $table->string('grade')->comment('Letter grade like A, B, C');
            $table->integer('min_score')->comment('Minimum marks for this grade');
            $table->integer('max_score')->comment('Maximum marks for this grade');
            $table->decimal('grade_point', 4, 2)->comment('Numeric value of grade like 4.0, 3.0');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grade_scales');
    }
};
