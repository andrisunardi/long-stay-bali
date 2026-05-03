<?php

use App\Models\GuideCategory;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guides', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(GuideCategory::class)->constrained()->cascadeOnDelete();
            $table->string('title', 100)->unique();
            $table->string('title_id', 100)->unique();
            $table->string('title_zh', 100)->unique();
            $table->text('body');
            $table->text('body_id');
            $table->text('body_zh');
            $table->string('google_file_id', 100);
            $table->string('image_url');
            $table->boolean('is_show')->unsigned()->default(true);
            $table->boolean('is_active')->unsigned()->default(true);
            $table->string('slug', 100)->unique();
            $table->foreignIdFor(User::class, 'created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignIdFor(User::class, 'updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignIdFor(User::class, 'deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guides');
    }
};
