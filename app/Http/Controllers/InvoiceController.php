<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index(Request $request): Response
    {
        $sortColumn = $request->input('sortColumn', 'created_at');
        $sortType = $request->input('sortType', 'desc');
        $search = $request->input('search', null);
        $perPage = $request->input('perPage', 10);

        $noFilter = $request->input('noFilter', null);

        $invoices = Invoice::query()
            ->when($search, function ($query) use ($search) {
                $query->where('invoice_no', 'LIKE', "%$search%");
            })
            ->when($noFilter, fn ($query) => $query->where('invoice_no', 'LIKE', "%$noFilter%"))
            ->orderBy($sortColumn, $sortType)
            ->paginate($perPage)
            ->withQueryString();

        return Inertia::render('Index', [
            'invoices' => $invoices,
        ]);
    }

    public function create()
    {
        $invoice = Invoice::query()
            ->where('user_id', Auth::id())
            ->where('total_amount', 0)
            ->first();

        if (!$invoice) {
            $invoice = Invoice::query()
                ->create([
                    'user_id' => Auth::id(),
                ]);

            InvoiceItem::query()
                ->create([
                    'invoice_id' => $invoice->id,
                    'item_name' => 'Item name 1',
                    'quantity' => 1,
                    'price' => 10,
                    'sub_total' => 10,
                ]);
        }

        return to_route('invoices.show', $invoice->id);
    }

    public function show(Invoice $invoice): Response
    {
        $items = $invoice->invoiceItems->toArray();

        return Inertia::render('Form', [
            'invoice' => $invoice,
            'items' => $items,
        ]);
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'logo' => 'required',
            'seller_company' => 'required',
            'seller_address' => 'required',
            'seller_zip' => 'required',
            'seller_city' => 'required',
            'seller_state' => 'required',
            'seller_country' => 'required',
            'buyer_company' => 'required',
            'buyer_address' => 'required',
            'buyer_zip' => 'required',
            'buyer_city' => 'required',
            'buyer_state' => 'required',
            'buyer_country' => 'required',
            'invoice_no' => 'required|unique:invoices,invoice_no,' . $invoice->id . '|max:255',
            'invoice_date' => 'required',
            'due_date' => 'required',
            'notes' => 'required',
            'terms' => 'required',
            'sub_total' => 'required',
            'has_discount' => 'required',
            'discount_type' => 'required',
            'discount_value' => 'required',
            'has_tax' => 'required',
            'tax_type' => 'required',
            'tax_value' => 'required',
            'has_shipping' => 'required',
            'shipping_amount' => 'required',
            'total_amount' => 'required',
            'currency' => 'required',
            'language' => 'required',
        ]);

        $invoice->update([
            'logo' => $request->logo,

            'seller_company' => $request->seller_company,
            'seller_address' => $request->seller_address,
            'seller_zip' => $request->seller_zip,
            'seller_city' => $request->seller_city,
            'seller_state' => $request->seller_state,
            'seller_country' => $request->seller_country,

            'buyer_company' => $request->buyer_company,
            'buyer_address' => $request->buyer_address,
            'buyer_zip' => $request->buyer_zip,
            'buyer_city' => $request->buyer_city,
            'buyer_state' => $request->buyer_state,
            'buyer_country' => $request->buyer_country,

            'invoice_no' => $request->invoice_no,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,

            'notes' => $request->notes,
            'terms' => $request->terms,

            'has_discount' => $request->has_discount,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,

            'has_tax' => $request->has_tax,
            'tax_type' => $request->tax_type,
            'tax_value' => $request->tax_value,

            'has_shipping' => $request->has_shipping,
            'shipping_amount' => $request->shipping_amount,

            'currency' => $request->currency,
            'language' => $request->language,
        ]);

        $logo = $request->file('logo');
        if ($logo) {
            $path = $logo->store('uploads', 'public');

            $invoice->update([
                'logo' => $path
            ]);
        }

        InvoiceItem::query()->where('invoice_id', $invoice->id)->delete();

        $subTotal = 0;

        foreach ($request->items as $item) {
            $quantity = $item['quantity'];
            $price = $item['price'];
            $subTotal += $quantity * $price;

            $invoiceItem = InvoiceItem::query()
                ->create([
                    'invoice_id' => $invoice->id,
                    'item_name' => $item['item_name'],
                    'description' => $item['description'],
                    'quantity' => $quantity,
                    'price' => $price,
                    'sub_total' => $quantity * $price,
                ]);
        }

        $invoice->update([
            'sub_total' => $subTotal,
            'total_amount' => $subTotal,
        ]);

        return to_route('invoices.show', $invoice->id)->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return back()->with('success', 'Invoice deleted successfully.');
    }
}
