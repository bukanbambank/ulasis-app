<?php

namespace App\Http\Controllers;

use App\Exports\FeedbackExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function export(Request $request)
    {
        $request->validate([
            'range' => 'required', // 7, 30, 365, all
            'format' => 'required|in:xlsx,csv',
        ]);

        $tenantId = tenancy()->tenant ? tenancy()->tenant->id : auth()->user()->tenant_id;
        $range = $request->input('range');
        $format = $request->input('format');

        $fileName = 'feedback_' . now()->format('Ymd_His') . '.' . $format;

        $exportFormat = $format === 'csv'
            ? \Maatwebsite\Excel\Excel::CSV
            : \Maatwebsite\Excel\Excel::XLSX;

        if (ob_get_length()) {
            ob_end_clean();
        }

        try {
            return Excel::download(new FeedbackExport($tenantId, $range), $fileName, $exportFormat);
        } catch (\Throwable $e) {
            return response("Export Error: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine(), 500);
        }
    }
}
