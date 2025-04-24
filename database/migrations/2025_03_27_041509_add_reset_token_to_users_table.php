<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResetTokenToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'reset_token')) {
                $table->string('reset_token')->nullable();
            }
            if (!Schema::hasColumn('users', 'reset_token_expires_at')) {
                $table->timestamp('reset_token_expires_at')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'reset_token')) {
                $table->dropColumn('reset_token');
            }
            if (Schema::hasColumn('users', 'reset_token_expires_at')) {
                $table->dropColumn('reset_token_expires_at');
            }
        });
    }
}