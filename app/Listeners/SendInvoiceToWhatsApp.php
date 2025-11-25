<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\InvoiceCreated;
use App\Services\Invoice\InvoicePdfService;
use App\Services\WhatsApp\WhatsAppService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

final class SendInvoiceToWhatsApp
{
    public function __construct(
        private readonly InvoicePdfService $pdfService,
        private readonly WhatsAppService $whatsAppService
    ) {}

    public function handle(InvoiceCreated $event): void
    {
        $invoice = $event->invoice->load(['items.product', 'store', 'marketer']);
        
        $arabic = new \ArPHP\I18N\Arabic();
        
        $processedItems = $invoice->items->map(function($item) use ($arabic) {
            return (object) [
                'product_name' => $arabic->utf8Glyphs($item->product->name),
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total' => $item->price * $item->quantity,
            ];
        });
        
        $data = [
            'invoiceNumber' => $invoice->invoice_number,
            'date' => $invoice->created_at->format('Y-m-d H:i'),
            'storeName' => $arabic->utf8Glyphs($invoice->store->name),
            'marketerName' => $arabic->utf8Glyphs($invoice->marketer->name),
            'items' => $processedItems,
            'totalAmount' => $invoice->total_amount ?? 0,
            'title' => $arabic->utf8Glyphs('فاتورة مبيعات'),
            'storeLabel' => $arabic->utf8Glyphs('المحل:'),
            'marketerLabel' => $arabic->utf8Glyphs('المسوق:'),
            'dateLabel' => $arabic->utf8Glyphs('التاريخ:'),
            'productLabel' => $arabic->utf8Glyphs('المنتج'),
            'quantityLabel' => $arabic->utf8Glyphs('الكمية'),
            'priceLabel' => $arabic->utf8Glyphs('السعر'),
            'totalLabel' => $arabic->utf8Glyphs('الإجمالي'),
            'grandTotalLabel' => $arabic->utf8Glyphs('الإجمالي الكلي:'),
            'currency' => $arabic->utf8Glyphs('دينار'),
        ];
        
        $pdf = Pdf::loadView('marketer.invoices.pdf', $data)
            ->setPaper('a4')
            ->setOption('defaultFont', 'DejaVu Sans');
        
        $filename = "invoice-{$invoice->invoice_number}.pdf";
        $path = storage_path("app/temp/{$filename}");
        
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }
        
        $pdf->save($path);
        
        $this->whatsAppService->sendDocument(
            config('whatsapp.test_phone'),
            $path,
            "فاتورة رقم: {$invoice->invoice_number}"
        );
        
        if (file_exists($path)) {
            unlink($path);
        }
        
        $invoice->update(['sent_to_whatsapp' => true]);
    }
}
