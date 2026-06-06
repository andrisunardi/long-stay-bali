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
            $table->string('title', 200)->unique();
            $table->string('title_id', 200)->unique();
            $table->string('title_zh', 200)->unique();
            $table->string('title_fr', 200)->unique();
            $table->text('body');
            $table->text('body_id');
            $table->text('body_zh');
            $table->text('body_fr');
            $table->string('google_file_id', 100)->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('is_show')->unsigned()->default(true);
            $table->boolean('is_active')->unsigned()->default(true);
            $table->string('slug', 100)->unique();
            $table->unsignedInteger('counter')->default(0);
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
