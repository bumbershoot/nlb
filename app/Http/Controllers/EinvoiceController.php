<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Services\EinvoiceService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class EinvoiceController extends Controller
{
    protected $einvoiceService;

    public function __construct(EinvoiceService $einvoiceService)
    {
        $this->einvoiceService = $einvoiceService;
    }

    /**
     * Display invoices with e-invoice status
     */
    public function index()
    {
        $invoices = Invoice::with(['booking', 'payment'])
            ->where('status', 'paid')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('einvoice.index', compact('invoices'));
    }

    /**
     * Submit invoice to e-invoice system
     */
    public function submit(Request $request, Invoice $invoice): JsonResponse
    {
        try {
            // Validate invoice can be submitted
            if (!$invoice->canSubmitEinvoice()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invoice cannot be submitted to e-invoice system'
                ], 400);
            }

            // Submit to e-invoice system
            $result = $this->einvoiceService->submitInvoice($invoice);

            return response()->json([
                'success' => true,
                'message' => 'Invoice submitted to e-invoice system successfully',
                'data' => $result
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit invoice: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check e-invoice status
     */
    public function checkStatus(Invoice $invoice): JsonResponse
    {
        try {
            if (!$invoice->hasEinvoice()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No e-invoice found for this invoice'
                ], 400);
            }

            $result = $this->einvoiceService->checkInvoiceStatus($invoice);

            return response()->json([
                'success' => true,
                'message' => 'E-invoice status updated',
                'data' => $result
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to check status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate e-invoice PDF
     */
    public function generatePDF(Invoice $invoice): JsonResponse
    {
        try {
            if (!$invoice->hasEinvoice()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No e-invoice found for this invoice'
                ], 400);
            }

            $pdfPath = $this->einvoiceService->generateEinvoicePDF($invoice);

            return response()->json([
                'success' => true,
                'message' => 'E-invoice PDF generated successfully',
                'pdf_url' => $invoice->einvoice_pdf_url
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download e-invoice PDF
     */
    public function downloadPDF(Invoice $invoice)
    {
        try {
            if (!$invoice->einvoice_pdf_path) {
                abort(404, 'E-invoice PDF not found');
            }

            $filePath = storage_path('app/public/' . $invoice->einvoice_pdf_path);
            
            if (!file_exists($filePath)) {
                abort(404, 'E-invoice PDF file not found');
            }

            return response()->download($filePath, 'einvoice_' . $invoice->einvoice_number . '.pdf');

        } catch (Exception $e) {
            abort(500, 'Failed to download PDF: ' . $e->getMessage());
        }
    }

    /**
     * Bulk submit invoices to e-invoice system
     */
    public function bulkSubmit(Request $request): JsonResponse
    {
        try {
            $invoiceIds = $request->input('invoice_ids', []);
            
            if (empty($invoiceIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No invoices selected'
                ], 400);
            }

            $invoices = Invoice::whereIn('id', $invoiceIds)
                ->where('status', 'paid')
                ->get();

            $results = [];
            $successCount = 0;
            $errorCount = 0;

            foreach ($invoices as $invoice) {
                try {
                    if ($invoice->canSubmitEinvoice()) {
                        $this->einvoiceService->submitInvoice($invoice);
                        $results[] = [
                            'invoice_id' => $invoice->id,
                            'invoice_number' => $invoice->invoice_number,
                            'status' => 'success'
                        ];
                        $successCount++;
                    } else {
                        $results[] = [
                            'invoice_id' => $invoice->id,
                            'invoice_number' => $invoice->invoice_number,
                            'status' => 'skipped',
                            'reason' => 'Cannot submit to e-invoice system'
                        ];
                    }
                } catch (Exception $e) {
                    $results[] = [
                        'invoice_id' => $invoice->id,
                        'invoice_number' => $invoice->invoice_number,
                        'status' => 'error',
                        'error' => $e->getMessage()
                    ];
                    $errorCount++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Bulk submission completed. Success: {$successCount}, Errors: {$errorCount}",
                'results' => $results,
                'summary' => [
                    'total' => count($invoices),
                    'success' => $successCount,
                    'errors' => $errorCount,
                    'skipped' => count($invoices) - $successCount - $errorCount
                ]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bulk submission failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get e-invoice statistics
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = [
                'total_invoices' => Invoice::where('status', 'paid')->count(),
                'einvoice_pending' => Invoice::where('status', 'paid')
                    ->whereIn('einvoice_status', ['pending', null])
                    ->count(),
                'einvoice_submitted' => Invoice::where('status', 'paid')
                    ->where('einvoice_status', 'submitted')
                    ->count(),
                'einvoice_approved' => Invoice::where('status', 'paid')
                    ->where('einvoice_status', 'approved')
                    ->count(),
                'einvoice_rejected' => Invoice::where('status', 'paid')
                    ->where('einvoice_status', 'rejected')
                    ->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get statistics: ' . $e->getMessage()
            ], 500);
        }
    }
}