@extends('layout')

@section('content')

    <div class="container-scroller">

        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Chart-js </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Charts</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Chart-js</li>
                </ol>
              </nav>
            </div>
            <div class="row">

              <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Bar chart</h4>
                    <canvas id="barChart" style="height:230px"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Pie chart</h4>
                    <canvas id="pieChart" style="height:250px"></canvas>
                  </div>
                </div>
              </div>
            </div>

            </div>
            <button class="btn btn-danger" style="position: absolute; top: 70%; left: 50%; transform: translate(-50%, -50%); margin-top: 70px;">
<!-- Example link to trigger PDF generation -->
<a href="{{ route('generate.pdf') }}" target="_blank">Generate PDF Report</a>
            </button>
          </div>
          <!-- content-wrapper ends -->

        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../assets/assets_admin/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../../assets/assets_admin/vendors/chart.js/Chart.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../../assets/assets_admin/js/off-canvas.js"></script>
    <script src="../../assets/assets_admin/js/hoverable-collapse.js"></script>
    <script src="../../assets/assets_admin/js/misc.js"></script>
    <script src="../../assets/assets_admin/js/settings.js"></script>
    <script src="../../assets/assets_admin/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="../../assets/assets_admin/js/chart.js"></script>
    <!-- End custom js for this page -->

   <script>
    function generatePDF() {
    // Example chart data or configurations
    const data1 = ['data1', 30, 200, 100, 400, 150, 250];
    const data2 = ['data2', 130, 100, 140, 200, 150, 50];

    // Convert chart data to an HTML table
    const chartDataAsTable = convertToHTMLTable([data1, data2]); // Pass your chart data arrays here

    // Logic to handle PDF generation
    fetch("{{ route('generate.pdf') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            chartDataAsTable: chartDataAsTable,
            // Add more data if needed for server-side PDF generation
        }),
    })
    .then(response => response.blob())
    .then(blob => {
        // Create a temporary link element to download the PDF
        const url = window.URL.createObjectURL(new Blob([blob]));
        const a = document.createElement('a');
        a.href = url;
        a.download = 'report.pdf';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


   </script>



@endsection
