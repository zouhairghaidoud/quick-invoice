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
            'invoice_no' => Str::lower($request->invoice_no),
        ]);

        return back()->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return back()->with('success', 'Invoice deleted successfully.');
    }
}
