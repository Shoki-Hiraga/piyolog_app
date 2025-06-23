<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();

            // 🔄 baby_name → baby_name_id（外部キー）
            $table->foreignId('baby_name_id')->constrained('baby_names')->onDelete('cascade');

            $table->date('date');                        // 日付
            $table->time('time');                        // 時刻
            $table->string('activity');                  // 活動名（ミルクなど）
            $table->string('amount')->nullable();        // 量（例: 60ml）
            $table->integer('sleep_minutes')->nullable();// 起きるの睡眠時間（分）
            $table->text('textlog')->nullable();         // 補足やコメントなど
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
