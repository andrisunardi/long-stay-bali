<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('values', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50)->unique();
            $table->string('title_id', 50)->unique();
            $table->string('title_zh', 50)->unique();
            $table->string('title_fr', 50)->unique();
            $table->string('short_description', 100);
            $table->string('short_description_id', 100);
            $table->string('short_description_zh', 100);
            $table->string('short_description_fr', 100);
            $table->string('description', 1000);
            $table->string('description_id', 1000);
            $table->string('description_zh', 1000);
            $table->string('description_fr', 1000);
            $table->string('icon', 50);
            $table->boolean('is_active')->unsigned()->default(true);
            $table->foreignIdFor(User::class, 'created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignIdFor(User::class, 'updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignIdFor(User::class, 'deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('values');
    }
};
