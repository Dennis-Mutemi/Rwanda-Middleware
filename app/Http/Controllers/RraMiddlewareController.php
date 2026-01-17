<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RraMiddlewareController extends Controller
{
    private string $vsdcBaseUrl;

    public function __construct()
    {
        $this->vsdcBaseUrl = config('services.vsdc.base_url');

        if (empty($this->vsdcBaseUrl)) {
            throw new \RuntimeException('VSDC base URL is not configured');
        }
    }

    public function init(Request $request)
    {
        $request->validate([
            'tin' => 'required|string',
            'bhfId' => 'required|string',
            'dvcSrlNo' => 'required|string',
        ]);

        try {
            $response = Http::timeout(30)
                ->acceptJson()
                ->post(
                    $this->vsdcBaseUrl . '/initializer/selectInitInfo',
                    $request->all()
                );

            return response()->json(
                $response->json(),
                $response->status()
            );

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'VSDC init failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function saveItems(Request $request)
    {
        try {
            $response = Http::timeout(30)
                ->acceptJson()
                ->post(
                    $this->vsdcBaseUrl . '/items/saveItems',
                    $request->all()
                );

            return response()->json(
                $response->json(),
                $response->status()
            );

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Save items failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function saveSales(Request $request)
    {
        try {
            $response = Http::timeout(60)
                ->acceptJson()
                ->post(
                    $this->vsdcBaseUrl . '/trnsSales/saveSales',
                    $request->all()
                );

            return response()->json(
                $response->json(),
                $response->status()
            );

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Save sales failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function signInvoice(Request $request)
    {
        try {
            // Step 1: Save sales
            $salesResponse = Http::timeout(30)
                ->acceptJson()
                ->post(
                    $this->vsdcBaseUrl . '/trnsSales/saveSales',
                    $request->input('sales', [])
                );

            if ($salesResponse->failed()) {
                return response()->json([
                    'message' => 'Sales failed',
                    'vsdc_response' => $salesResponse->json()
                ], 500);
            }

            // Step 2: Sign invoice
            $invoiceResponse = Http::timeout(30)
                ->acceptJson()
                ->post(
                    $this->vsdcBaseUrl . '/salesInvoice/sign',
                    $request->input('invoice', [])
                );

            return response()->json([
                'receiptNo' => $invoiceResponse->json('rcptNo'),
                'signature' => $invoiceResponse->json('invcSign'),
                'qrCode' => $invoiceResponse->json('qrCode'),
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Invoice signing failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function selectCodes(Request $request)
    {
        try {
            $response = Http::timeout(30)
                ->acceptJson()
                ->post(
                    $this->vsdcBaseUrl . '/code/selectCodes',
                    $request->all()
                );

            return response()->json(
                $response->json(),
                $response->status()
            );

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Select codes failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function selectItemsClass(Request $request)
    {
        try {
            $response = Http::timeout(60)
                ->acceptJson()
                ->post(
                    $this->vsdcBaseUrl . '/itemClass/selectItemsClass',
                    $request->all()
                );

            return response()->json(
                $response->json(),
                $response->status()
            );

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Select items class failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function selectCustomer(Request $request)
    {
        try {
            $response = Http::timeout(30)
                ->acceptJson()
                ->post(
                    $this->vsdcBaseUrl . '/customers/selectCustomer',
                    $request->all()
                );

            return response()->json(
                $response->json(),
                $response->status()
            );

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Select customer failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function selectBranches(Request $request)
    {
        try {
            $response = Http::timeout(30)
                ->acceptJson()
                ->post(
                    $this->vsdcBaseUrl . '/branches/selectBranches',
                    $request->all()
                );

            return response()->json(
                $response->json(),
                $response->status()
            );

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Select branches failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function selectNotices(Request $request)
    {
        try {
            $response = Http::timeout(30)
                ->acceptJson()
                ->post(
                    $this->vsdcBaseUrl . '/notices/selectNotices',
                    $request->all()
                );

            return response()->json(
                $response->json(),
                $response->status()
            );

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Select notices failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function saveStockMaster(Request $request)
    {
        try {
            $response = Http::timeout(30)
                ->acceptJson()
                ->post(
                    $this->vsdcBaseUrl . '/stockMaster/saveStockMaster',
                    $request->all()
                );

            return response()->json(
                $response->json(),
                $response->status()
            );

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Save stock master failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function selectItems(Request $request)
    {
        try {
            $response = Http::timeout(60)
                ->acceptJson()
                ->post(
                    $this->vsdcBaseUrl . '/items/selectItems',
                    $request->all()
                );

            return response()->json(
                $response->json(),
                $response->status()
            );

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Select items failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
