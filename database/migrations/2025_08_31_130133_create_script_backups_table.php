<?php

use App\Models\Device;
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
        Schema::create('script_backups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('content');
            $table->string('hash');
            $table->integer('size');
            $table->string('version');
            $table->foreignIdFor(Device::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('script_backups');
    }
};
