<?php

namespace App\Services;

use App\Models\Invoice;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class EinvoiceService
{
    protected $apiUrl;
    protected $apiKey;
    protected $companyId;
    protected $mode;

    public function __construct()
    {
        $this->apiUrl = config('services.einvoice.api_url');
        $this->apiKey = config('services.einvoice.api_key');
        $this->companyId = config('services.einvoice.company_id');
        $this->mode = config('services.einvoice.mode', 'sandbox');
    }

    /**
     * Submit invoice to e-invoice system
     */
    public function submitInvoice(Invoice $invoice)
    {
        try {
            // Validate configuration
            $this->validateConfiguration();

            // Prepare invoice data for e-invoice API
            $invoiceData = $this->prepareInvoiceData($invoice);

            // Submit to e-invoice API
            $response = $this->callEinvoiceAPI('submit', $invoiceData);

            // Update invoice with e-invoice details
            $this->updateInvoiceWithEinvoiceData($invoice, $response);

            return $response;

        } catch (Exception $e) {
            Log::error('E-invoice submission failed', [
                'invoice_id' => $invoice->id,
                'error' => $e->getMessage()
            ]);

            // Update invoice with error status
            $invoice->update([
                'einvoice_status' => 'rejected',
                'einvoice_rejection_reason' => $e->getMessage(),
                'einvoice_response' => ['error' => $e->getMessage()]
            ]);

            throw $e;
        }
    }

    /**
     * Check e-invoice status
     */
    public function checkInvoiceStatus(Invoice $invoice)
    {
        try {
            if (!$invoice->einvoice_reference) {
                throw new Exception('No e-invoice reference found');
            }

            $response = $this->callEinvoiceAPI('status', [
                'reference' => $invoice->einvoice_reference
            ]);

            // Update invoice status
            $this->updateInvoiceStatus($invoice, $response);

            return $response;

        } catch (Exception $e) {
            Log::error('E-invoice status check failed', [
                'invoice_id' => $invoice->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Generate e-invoice PDF
     */
    public function generateEinvoicePDF(Invoice $invoice)
    {
        try {
            if (!$invoice->einvoice_reference) {
                throw new Exception('No e-invoice reference found');
            }

            $response = $this->callEinvoiceAPI('pdf', [
                'reference' => $invoice->einvoice_reference
            ]);

            // Save PDF file
            $pdfPath = $this->saveEinvoicePDF($invoice, $response['pdf_content']);

            // Update invoice with PDF path
            $invoice->update([
                'einvoice_pdf_path' => $pdfPath
            ]);

            return $pdfPath;

        } catch (Exception $e) {
            Log::error('E-invoice PDF generation failed', [
                'invoice_id' => $invoice->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Prepare invoice data for e-invoice API
     */
    protected function prepareInvoiceData(Invoice $invoice)
    {
        return [
            'invoice_number' => $invoice->invoice_number,
            'issue_date' => $invoice->issue_date->format('Y-m-d'),
            'due_date' => $invoice->due_date->format('Y-m-d'),
            'customer_name' => $invoice->customer_name,
            'customer_email' => $invoice->customer_email,
            'customer_phone' => $invoice->customer_phone,
            'customer_address' => $invoice->customer_address,
            'subtotal' => $invoice->subtotal,
            'tax_amount' => $invoice->tax_amount,
            'discount_amount' => $invoice->discount_amount,
            'total_amount' => $invoice->total_amount,
            'currency' => $invoice->currency,
            'line_items' => $invoice->line_items,
            'company_id' => $this->companyId,
        ];
    }

    /**
     * Call e-invoice API
     */
    protected function callEinvoiceAPI($endpoint, $data)
    {
        $url = $this->apiUrl . '/' . $endpoint;

        $response = Http::timeout(30)
            ->retry(3, 1000)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])
            ->post($url, $data);

        if (!$response->successful()) {
            throw new Exception('E-invoice API Error: ' . $response->status() . ' - ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Update invoice with e-invoice data
     */
    protected function updateInvoiceWithEinvoiceData(Invoice $invoice, $response)
    {
        $invoice->update([
            'einvoice_number' => $response['einvoice_number'] ?? null,
            'einvoice_reference' => $response['reference'] ?? null,
            'einvoice_status' => $response['status'] ?? 'submitted',
            'einvoice_submitted_at' => now(),
            'einvoice_response' => $response,
            'einvoice_qr_code' => $response['qr_code'] ?? null,
        ]);
    }

    /**
     * Update invoice status from API response
     */
    protected function updateInvoiceStatus(Invoice $invoice, $response)
    {
        $updateData = [
            'einvoice_status' => $response['status'] ?? $invoice->einvoice_status,
            'einvoice_response' => $response,
        ];

        if (isset($response['status']) && $response['status'] === 'approved') {
            $updateData['einvoice_approved_at'] = now();
        }

        if (isset($response['status']) && $response['status'] === 'rejected') {
            $updateData['einvoice_rejection_reason'] = $response['rejection_reason'] ?? 'Unknown reason';
        }

        $invoice->update($updateData);
    }

    /**
     * Save e-invoice PDF
     */
    protected function saveEinvoicePDF(Invoice $invoice, $pdfContent)
    {
        $filename = 'einvoice_' . $invoice->einvoice_number . '.pdf';
        $path = 'invoices/einvoice/' . $filename;
        
        // Create directory if it doesn't exist
        $fullPath = storage_path('app/public/' . $path);
        $directory = dirname($fullPath);
        
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Save PDF content
        file_put_contents($fullPath, base64_decode($pdfContent));

        return $path;
    }

    /**
     * Validate e-invoice configuration
     */
    protected function validateConfiguration()
    {
        if (empty($this->apiUrl)) {
            throw new Exception('E-invoice API URL not configured');
        }

        if (empty($this->apiKey)) {
            throw new Exception('E-invoice API Key not configured');
        }

        if (empty($this->companyId)) {
            throw new Exception('E-invoice Company ID not configured');
        }
    }

    /**
     * Get e-invoice status color
     */
    public function getEinvoiceStatusColor($status)
    {
        return match($status) {
            'pending' => 'secondary',
            'submitted' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            default => 'secondary'
        };
    }
}
