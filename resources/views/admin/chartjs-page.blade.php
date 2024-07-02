@extends('layout')

@section('content')
<br><br><br>
<div class="container mt-5">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title">Bar chart</h3>
            </div>
            <div class="row">
                <div class="col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Admin vs Users</h4>
                            <canvas id="adminUserChart" style="height:230px"></canvas>
                        </div><br><br><br>
                        <a href="{{ route('export.table.pdf') }}" class="btn btn-primary">Download PDF</a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/assets_admin/vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('assets/assets_admin/vendors/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('assets/assets_admin/js/off-canvas.js') }}"></script>
<script src="{{ asset('assets/assets_admin/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('assets/assets_admin/js/misc.js') }}"></script>
<script src="{{ asset('assets/assets_admin/js/settings.js') }}"></script>
<script src="{{ asset('assets/assets_admin/js/todolist.js') }}"></script>
<script src="{{ asset('assets/assets_admin/js/chart.js') }}"></script>

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
