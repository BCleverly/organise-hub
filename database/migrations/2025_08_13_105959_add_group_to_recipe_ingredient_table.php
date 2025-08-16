<?php

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
        Schema::table('recipe_ingredient', function (Blueprint $table) {
            $table->string('group')->nullable()->after('notes'); // e.g., 'sauce', 'marinade', 'main dish', 'garnish'
            $table->integer('group_order')->default(0)->after('group'); // Order within the group
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recipe_ingredient', function (Blueprint $table) {
            $table->dropColumn(['group', 'group_order']);
        });
    }
};
