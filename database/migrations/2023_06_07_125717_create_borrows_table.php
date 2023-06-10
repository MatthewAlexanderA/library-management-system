<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('isbn')->constrained('books')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->date('borrow_date')->nullable();
            $table->date('return_date')->nullable();
            $table->enum('status', ['returned', 'borrowed', 'requested', 'rejected']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('borrows');
    }
};
