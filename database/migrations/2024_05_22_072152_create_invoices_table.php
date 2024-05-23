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
            $table->string('logo')->nullable();
            $table->string('seller_company')->nullable();
            $table->string('seller_address')->nullable();
            $table->string('seller_zip')->nullable();
            $table->string('seller_city')->nullable();
            $table->string('seller_state')->nullable();
            $table->string('seller_country')->nullable();
            $table->string('buyer_company')->nullable();
            $table->string('buyer_address')->nullable();
            $table->string('buyer_zip')->nullable();
            $table->string('buyer_city')->nullable();
            $table->string('buyer_state')->nullable();
            $table->string('buyer_country')->nullable();
            $table->string('invoice_no')->nullable();
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->longText('notes')->nullable();
            $table->longText('terms')->nullable();
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
