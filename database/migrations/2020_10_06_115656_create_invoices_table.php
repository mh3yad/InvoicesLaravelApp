<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_number');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->string('product_id');
            $table->string('section_id');
            $table->string('discount');
            $table->string('amount_collection');
            $table->string('amount_commission');
            $table->string('total');
            $table->string('rate_vat');
            $table->decimal('value_vat',8,2);
            $table->integer('status_id')->default(1);
            $table->text('note')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('user')->default(auth()->user());
            $table->softDeletes();
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
        Schema::dropIfExists('invoices');
    }
}
