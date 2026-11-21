<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            if (!Schema::hasColumn('testimonials', 'client_name')) {
                $table->string('client_name')->nullable()->after('id');
            }
            if (!Schema::hasColumn('testimonials', 'project_type')) {
                $table->string('project_type')->nullable()->after('client_name');
            }
            if (!Schema::hasColumn('testimonials', 'screenshot_path')) {
                $table->string('screenshot_path')->nullable()->after('project_type');
            }
            if (!Schema::hasColumn('testimonials', 'caption')) {
                $table->text('caption')->nullable()->after('screenshot_path');
            }
            if (!Schema::hasColumn('testimonials', 'platform')) {
                $table->string('platform')->default('whatsapp')->after('caption');
            }
            if (!Schema::hasColumn('testimonials', 'is_featured')) {
                $table->boolean('is_featured')->default(true)->after('platform');
            }
        });
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $columns = ['client_name', 'project_type', 'screenshot_path', 'caption', 'platform', 'is_featured'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('testimonials', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
