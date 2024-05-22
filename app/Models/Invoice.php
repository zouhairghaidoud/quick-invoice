<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'logo',
        'seller_company',
        'seller_address',
        'seller_zip',
        'seller_city',
        'seller_state',
        'seller_country',
        'buyer_company',
        'buyer_address',
        'buyer_zip',
        'buyer_city',
        'buyer_state',
        'buyer_country',
        'invoice_no',
        'invoice_date',
        'due_date',
        'notes',
        'terms',
        'sub_total',
        'has_discount',
        'discount_type',
        'discount_value',
        'has_tax',
        'tax_type',
        'tax_value',
        'has_shipping',
        'shipping_amount',
        'total_amount',
        'currency',
        'language',
    ];

    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
