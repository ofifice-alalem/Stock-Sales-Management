<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTOs\Invoice\CreateInvoiceDTO;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use App\Services\Invoice\InvoiceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function __construct(
        private readonly InvoiceService $invoiceService
    ) {}

    public function index(): View
    {
        $invoices = $this->invoiceService->getAllInvoices();
        return view('admin.invoices.index', compact('invoices'));
    }

    public function create(): View
    {
        $marketers = User::whereHas('role', fn($q) => $q->where('name', 'marketer'))->get();
        $stores = Store::all();
        $products = \App\Models\Product::all();
        return view('admin.invoices.create', compact('marketers', 'stores', 'products'));
    }

    public function show(int $id): View
    {
        $invoice = $this->invoiceService->getInvoiceById($id);
        return view('admin.invoices.show', compact('invoice'));
    }

    public function edit(int $id): View
    {
        $invoice = $this->invoiceService->getInvoiceById($id);
        $marketers = User::whereHas('role', fn($q) => $q->where('name', 'marketer'))->get();
        $stores = Store::all();
        $products = \App\Models\Product::all();
        return view('admin.invoices.edit', compact('invoice', 'marketers', 'stores', 'products'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'invoice_number' => 'required|string|max:50|unique:invoices,invoice_number,' . $id,
            'marketer_id' => 'required|exists:users,id',
            'store_id' => 'required|exists:stores,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        $invoiceDTO = new CreateInvoiceDTO(
            invoiceNumber: $request->input('invoice_number'),
            marketerId: (int)$request->input('marketer_id'),
            storeId: (int)$request->input('store_id'),
            totalAmount: null
        );

        $this->invoiceService->updateInvoiceWithItems($id, $invoiceDTO, $request->input('items'));

        return redirect()->route('admin.invoices.index')
            ->with('success', 'تم تحديث الفاتورة بنجاح');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'invoice_number' => 'required|string|max:50|unique:invoices',
            'marketer_id' => 'required|exists:users,id',
            'store_id' => 'required|exists:stores,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        $invoiceDTO = new CreateInvoiceDTO(
            invoiceNumber: $request->input('invoice_number'),
            marketerId: (int)$request->input('marketer_id'),
            storeId: (int)$request->input('store_id'),
            totalAmount: null
        );

        $this->invoiceService->createInvoiceWithItems($invoiceDTO, $request->input('items'));

        return redirect()->route('admin.invoices.index')
            ->with('success', 'تم إضافة الفاتورة بنجاح');
    }

    public function destroy(int $invoiceId): RedirectResponse
    {
        $this->invoiceService->deleteInvoice($invoiceId);

        return redirect()->route('admin.invoices.index')
            ->with('success', 'تم حذف الفاتورة بنجاح');
    }
}