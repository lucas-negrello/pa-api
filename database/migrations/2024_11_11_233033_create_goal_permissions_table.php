<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('goal_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('goal_id')->constrained('goals')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('permission_type', 50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('goal_permissions');
    }
};
