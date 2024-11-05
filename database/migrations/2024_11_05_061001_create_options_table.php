<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// use App\Models\Option;
// Option::create(['name' => 'Opsi 1']);
// Option::create(['name' => 'Opsi 2']);
// Option::create(['name' => 'Opsi 3']);



return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->id();             // kolom primary key
            $table->string('name');    // kolom 'name'
            $table->string('opini');    // kolom 'opini'
            $table->integer('vote_count')->default(0);  // kolom 'vote_count'
            $table->timestamps();      // kolom created_at dan updated_at
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('options');
    }
};
