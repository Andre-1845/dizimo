<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {

            $table->index(['church_id', 'category_id', 'donation_date']);
            $table->index('member_id');
            $table->index('is_confirmed');
            $table->index(['member_id', 'donation_date']);
        });

        Schema::table('members', function (Blueprint $table) {

            $table->index('church_id');
            $table->index('active');
            $table->index('created_at');
            $table->index('inactivated_at');
        });

        Schema::table('categories', function (Blueprint $table) {

            $table->unique('name');
        });
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {

            $table->dropIndex(['church_id', 'category_id', 'donation_date']);
            $table->dropIndex(['member_id']);
            $table->dropIndex(['is_confirmed']);
            $table->dropIndex(['member_id', 'donation_date']);
        });

        Schema::table('members', function (Blueprint $table) {

            $table->dropIndex(['church_id']);
            $table->dropIndex(['active']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['inactivated_at']);
        });

        Schema::table('categories', function (Blueprint $table) {

            $table->dropUnique(['name']);
        });
    }
};
