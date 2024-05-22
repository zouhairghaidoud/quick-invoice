<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
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
            ->whereDoesntHave('invoiceItems')
            ->first();

        if (!$invoice) {
            $invoice = Invoice::query()
                ->create([
                    'user_id' => Auth::id(),
                ]);
        }

        return to_route('invoices.show', $invoice->id);
    }

    public function show(Invoice $invoice): Response
    {
        return Inertia::render('Form');
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'invoice_no' => 'required|unique:invoices,invoice_no,' . $invoice->id . '|max:255',
        ]);

        $invoice->update([
            'invoice_no' => Str::lower($request->invoice_no),
        ]);

        return to_route('invoices.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return back()->with('success', 'Invoice deleted successfully.');
    }
}
