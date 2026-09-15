<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('department_id')->nullable()->after('organization_id')->constrained('departments')->onDelete('set null');
            $table->string('position')->nullable()->after('department_id');
            $table->date('date_joined')->nullable()->after('position');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('date_joined');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropColumn(['department_id', 'position', 'date_joined', 'status']);
        });
    }
};
