<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (! Schema::hasColumn('tickets', 'reference_no')) {
                $table->string('reference_no', 50)->nullable()->unique()->after('id');
            }
            if (! Schema::hasColumn('tickets', 'access_token')) {
                $table->string('access_token', 100)->nullable()->after('reference_no');
            }
            if (! Schema::hasColumn('tickets', 'customer_name')) {
                $table->string('customer_name', 255)->nullable()->after('access_token');
            }
            if (! Schema::hasColumn('tickets', 'email')) {
                $table->string('email', 255)->nullable()->after('customer_name');
            }
            if (! Schema::hasColumn('tickets', 'phone')) {
                $table->string('phone', 50)->nullable()->after('email');
            }
            if (! Schema::hasColumn('tickets', 'problem_description')) {
                $table->text('problem_description')->nullable()->after('phone');
            }
            if (! Schema::hasColumn('tickets', 'status')) {
                $table->string('status', 50)->default('Open')->after('problem_description');
            }
            if (! Schema::hasColumn('tickets', 'viewed')) {
                $table->boolean('viewed')->default(false)->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (Schema::hasColumn('tickets', 'viewed')) {
                $table->dropColumn('viewed');
            }
            if (Schema::hasColumn('tickets', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('tickets', 'problem_description')) {
                $table->dropColumn('problem_description');
            }
            if (Schema::hasColumn('tickets', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('tickets', 'email')) {
                $table->dropColumn('email');
            }
            if (Schema::hasColumn('tickets', 'customer_name')) {
                $table->dropColumn('customer_name');
            }
            if (Schema::hasColumn('tickets', 'access_token')) {
                $table->dropColumn('access_token');
            }
            if (Schema::hasColumn('tickets', 'reference_no')) {
                $table->dropColumn('reference_no');
            }
        });
    }
};
