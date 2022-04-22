<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (env('APP_ENV') == 'testing') {
            Schema::create('visits', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('store_id');
                $table->unsignedBigInteger('customer_id');
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();

                $table->foreign('customer_id', 'visit_customer_FK')->references('id')->on('customers')->onDelete('cascade')->onUpdate('cascade');
                $table->foreign('store_id', 'visit_store_FK')->references('id')->on('stores')->onDelete('cascade')->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (env('APP_ENV') == 'testing') {
            Schema::dropIfExists('visits');
        }
    }
}
