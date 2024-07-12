@extends('admin.layout')
<br>
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Analytics Dashboard</h3>
    </div>
    <div class="row">
        <!-- Bids Per Day Chart -->
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Bids Per Day</h4>
                    <canvas id="bidsPerDayChart" style="height:230px; width: 100%;"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Bidding Users Chart -->
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Top Bidding Users</h4>
                    <canvas id="topBiddingUsersChart" style="height:230px; width: 100%;"></canvas>
                </div>
            </div>
        </div>

        <!-- Revenue Over Time Chart -->
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Revenue Over Time</h4>
                    <canvas id="revenueOverTimeChart" style="height:230px; width: 100%;"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Top Bidded Products Chart -->
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Top Bidded Products</h4>
                    <canvas id="topBiddedProductsChart" style="height:230px; width: 100%;"></canvas>
                </div>
            </div>
        </div>
        <!-- Admin vs Users Chart -->
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Admin vs Users</h4>
                    <canvas id="adminUserChart" style="height:230px; width: 100%;"></canvas>
                    <a href="{{ route('export.table.pdf') }}" class="btn btn-primary mt-3">Download PDF</a>
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

<!-- Add this script in the <script> tag above -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Fetch and display Admin vs Users Chart
        fetch('/api/users-admins-count')
            .then(response => response.json())
            .then(data => {
                const ctxAdminUser = document.getElementById('adminUserChart').getContext('2d');
                new Chart(ctxAdminUser, {
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

        // Fetch and display Bids Per Day Chart
        fetch('/api/bids-per-day')
            .then(response => response.json())
            .then(data => {
                const ctxBidsPerDay = document.getElementById('bidsPerDayChart').getContext('2d');
                new Chart(ctxBidsPerDay, {
                    type: 'line',
                    data: {
                        labels: data.dates,
                        datasets: [{
                            label: 'Bids Per Day',
                            data: data.counts,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            fill: false
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                beginAtZero: true
                            },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching data:', error));

        // Fetch and display Revenue Over Time Chart
        fetch('/api/revenue-over-time')
    .then(response => response.json())
    .then(data => {
        // Convert totals from strings to floats or integers
        const totals = data.totals.map(total => parseFloat(total));

        const ctxRevenueOverTime = document.getElementById('revenueOverTimeChart').getContext('2d');
        new Chart(ctxRevenueOverTime, {
            type: 'line',
            data: {
                labels: data.dates,
                datasets: [{
                    label: 'Revenue Over Time',
                    data: totals,  // Use the converted totals array
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    })
    .catch(error => console.error('Error fetching data:', error));

        // Fetch and display Top Bidding Users Chart
        fetch('/api/top-bidding-users')
            .then(response => response.json())
            .then(data => {
                const ctxTopBiddingUsers = document.getElementById('topBiddingUsersChart').getContext('2d');
                new Chart(ctxTopBiddingUsers, {
                    type: 'bar',
                    data: {
                        labels: data.names,
                        datasets: [{
                            label: 'Top Bidding Users',
                            data: data.counts,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
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

        // Fetch and display Top Bidded Products Chart
        fetch('/api/top-bidded-products')
            .then(response => response.json())
            .then(data => {
                const ctxTopBiddedProducts = document.getElementById('topBiddedProductsChart').getContext('2d');
                new Chart(ctxTopBiddedProducts, {
                    type: 'bar',
                    data: {
                        labels: data.names,
                        datasets: [{
                            label: 'Top Bidded Products',
                            data: data.counts,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
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
