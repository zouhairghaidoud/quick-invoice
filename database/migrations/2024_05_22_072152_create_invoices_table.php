<?php

use App\Models\User;
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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id');
            $table->string('logo');
            $table->string('seller_company');
            $table->string('seller_address');
            $table->string('seller_zip');
            $table->string('seller_city');
            $table->string('seller_state');
            $table->string('seller_country');
            $table->string('buyer_company');
            $table->string('buyer_address');
            $table->string('buyer_zip');
            $table->string('buyer_city');
            $table->string('buyer_state');
            $table->string('buyer_country');
            $table->string('invoice_no');
            $table->dateTime('invoice_date');
            $table->dateTime('due_date');
            $table->longText('notes');
            $table->longText('terms');
            $table->decimal('sub_total')->default(0);
            $table->boolean('has_discount')->default(0);
            $table->enum('discount_type', ['percentage', 'amount']);
            $table->decimal('discount_value')->default(0);
            $table->boolean('has_tax')->default(0);
            $table->enum('tax_type', ['percentage', 'amount']);
            $table->decimal('tax_value')->default(0);
            $table->boolean('has_shipping')->default(0);
            $table->decimal('shipping_amount')->default(0);
            $table->decimal('total_amount')->default(0);
            $table->string('currency')->default('USD');
            $table->string('language')->default('en');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
