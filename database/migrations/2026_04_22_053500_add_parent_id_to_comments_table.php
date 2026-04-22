<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // Добавляем поле без автоматического constrained()
            $table->unsignedBigInteger('parent_id')->nullable()->after('comment');

            // Явно указываем внешний ключ на таблицу comments
            $table->foreign('parent_id')
                  ->references('id')->on('comments')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }
};
