<?php

use App\Models\BinaryBackup;
use App\Models\Device;
use App\Models\ScriptBackup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('backups', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Device::class);
            $table->boolean('success');
            $table->boolean('connection_error')->default(false);
            $table->string('error_message')->nullable();
            $table->timestamp('started_at');
            $table->timestamp('finished_at')->nullable();
            $table->foreignIdFor(BinaryBackup::class)->nullable();
            $table->foreignIdFor(ScriptBackup::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backups');
    }
};
