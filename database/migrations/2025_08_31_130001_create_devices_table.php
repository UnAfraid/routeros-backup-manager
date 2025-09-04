<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->integer('port')->default(22);
            $table->morphs('credential');
            $table->string('backup_cron_schedule')->default('0 0 * * *');
            $table->boolean('binary_backup_enabled')->default(true);
            $table->boolean('script_backup_enabled')->default(true);
            $table->foreignIdFor(User::class, 'created_by_user_id');
            $table->foreignIdFor(User::class, 'updated_by_user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
