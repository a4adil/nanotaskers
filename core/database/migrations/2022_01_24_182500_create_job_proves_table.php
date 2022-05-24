<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobProvesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'job_proves', function ( Blueprint $table ) {
            $table->id();
            $table->integer( 'job_id' )->nullable();
            $table->text( 'detail' )->nullable();
            $table->string( 'attachment' )->nullable();
            $table->tinyInteger( 'status' )->default( 0 );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'job_proves' );
    }
}
