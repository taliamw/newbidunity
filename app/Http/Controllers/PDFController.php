<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function generatePDF()
    {
      // Create a new Dompdf instance
      $pdf = new Dompdf();

      // HTML content for the PDF view
      $pdfView = view('admin.pdf_view')->render();

      // Load HTML content into Dompdf
      $pdf->loadHtml($pdfView);

      // Set options for Dompdf (if needed)
      $options = new Options();
      // ...

      // (Optional) Set additional options for Dompdf
      $pdf->setOptions($options);

      // Render the PDF
      $pdf->render();

      // Stream or download the PDF
      return $pdf->stream('chart_report.pdf');

    }
    public function exportTableToPDF()
    {
        // Retrieve data from the database (modify this based on your model and table)
        $users = User::all(); // Example: Retrieve all users

        // Create a new Dompdf instance
        $pdf = new Dompdf();

        // HTML content for the PDF view (replace 'table_view' with your actual table view)
        $pdfView = view('table_view', compact('users'))->render();

        // Load HTML content into Dompdf
        $pdf->loadHtml($pdfView);

        // Set options for Dompdf (if needed)
        $options = new Options();
        // ...

        // (Optional) Set additional options for Dompdf
        $pdf->setOptions($options);

        // Render the PDF
        $pdf->render();

        // Stream or download the PDF
        return $pdf->stream('table_report.pdf');
    }

}
