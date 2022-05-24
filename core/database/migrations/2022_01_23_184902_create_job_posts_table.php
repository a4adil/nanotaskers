<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobPostsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'job_posts', function ( Blueprint $table ) {
            $table->id();
            $table->integer( 'user_id' )->nullable();
            $table->integer( 'category_id' )->nullable();
            $table->integer( 'subcategory_id' )->nullable();
            $table->tinyInteger( 'job_proof' )->nullable();
            $table->string( 'file_name' )->nullable();
            $table->integer( 'workers' )->nullable();
            $table->decimal( 'rate' )->nullable();
            $table->decimal( 'total' )->nullable();
            $table->string( 'title' )->nullable();
            $table->text( 'description' )->nullable();
            $table->string( 'attachment' )->nullable();
            $table->tinyInteger( 'status' )->default( 1 );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'job_posts' );
    }
}
