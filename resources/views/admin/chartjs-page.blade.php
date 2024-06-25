@extends('layout')

@section('content')
<br><br><br>
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
                    <h4 class="card-title">Admin vs Users</h4>
                    <canvas id="adminUserChart" style="height:230px"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <button class="btn btn-danger" style="position: absolute; top: 70%; left: 50%; transform: translate(-50%, -50%); margin-top: 70px;">
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
        document.addEventListener('DOMContentLoaded', function () {
            fetch('/api/users-admins-count')
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('adminUserChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Admins', 'Users'],
                            datasets: [{
                                label: 'Count',
                                data: [data.admins, data.users],
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        });
    </script>

@endsection
