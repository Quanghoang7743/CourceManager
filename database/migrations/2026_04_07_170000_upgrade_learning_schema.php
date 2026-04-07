<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (! Schema::hasColumn('courses', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('name');
            }

            if (! Schema::hasColumn('courses', 'price')) {
                $table->decimal('price', 12, 2)->default(0)->after('slug');
            }

            if (! Schema::hasColumn('courses', 'description')) {
                $table->text('description')->nullable()->after('price');
            }

            if (! Schema::hasColumn('courses', 'image_path')) {
                $table->string('image_path')->nullable()->after('description');
            }

            if (! Schema::hasColumn('courses', 'status')) {
                $table->enum('status', ['draft', 'published'])->default('draft')->after('image_path');
            }

            if (! Schema::hasColumn('courses', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('students', function (Blueprint $table) {
            if (! Schema::hasColumn('students', 'email')) {
                $table->string('email')->nullable()->unique()->after('name');
            }
        });

        if (! Schema::hasTable('lessons')) {
            Schema::create('lessons', function (Blueprint $table) {
                $table->id();
                $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
                $table->string('title');
                $table->longText('content');
                $table->string('video_url')->nullable();
                $table->unsignedInteger('order')->default(1);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('lessons')) {
            Schema::drop('lessons');
        }

        Schema::table('students', function (Blueprint $table) {
            if (Schema::hasColumn('students', 'email')) {
                $table->dropUnique('students_email_unique');
                $table->dropColumn('email');
            }
        });

        Schema::table('courses', function (Blueprint $table) {
            if (Schema::hasColumn('courses', 'slug')) {
                $table->dropUnique('courses_slug_unique');
                $table->dropColumn('slug');
            }

            if (Schema::hasColumn('courses', 'price')) {
                $table->dropColumn('price');
            }

            if (Schema::hasColumn('courses', 'description')) {
                $table->dropColumn('description');
            }

            if (Schema::hasColumn('courses', 'image_path')) {
                $table->dropColumn('image_path');
            }

            if (Schema::hasColumn('courses', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('courses', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
