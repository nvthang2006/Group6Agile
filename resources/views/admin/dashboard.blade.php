@extends('layouts.admin')

@section('title', 'Dashboard - Tour Manager')

@section('page_heading', 'Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Tổng quan</li>
@endsection

@section('page_css')
    <link href="{{ asset('cork/src/plugins/src/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('cork/src/assets/css/light/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('cork/src/assets/css/dark/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .stat-card {
            border-radius: 10px;
            padding: 20px;
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        .stat-card .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .stat-card .stat-icon svg {
            width: 24px;
            height: 24px;
        }
        .stat-card h3 {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
        }
        .stat-card p {
            font-size: 13px;
            margin: 0;
            color: #888;
        }
        .booking-item {
            padding: 12px;
            border-radius: 8px;
            transition: background 0.2s;
        }
        .booking-item:hover {
            background-color: #f1f5f9;
        }
        .booking-date-badge {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            line-height: 1.2;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    {{-- Statistics Cards --}}
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p>Khách hàng</p>
                    <h3>{{ $totalUsers }}</h3>
                </div>
                <div class="stat-icon" style="background-color: #e0f2fe; color: #0284c7;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p>Sản phẩm Tour</p>
                    <h3>{{ $totalTours }}</h3>
                </div>
                <div class="stat-icon" style="background-color: #dcfce7; color: #16a34a;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p>Đơn Đặt Tour</p>
                    <h3>{{ $totalBookings }}</h3>
                </div>
                <div class="stat-icon" style="background-color: #fef9c3; color: #ca8a04;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p>Doanh thu tháng (VNĐ)</p>
                    <h3 style="font-size: 22px;">{{ number_format($thisMonthRevenue, 0, ',', '.') }}</h3>
                </div>
                <div class="stat-icon" style="background-color: #f3e8ff; color: #9333ea;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Revenue Chart --}}
    <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8" style="padding: 20px;">
            <h5 class="mb-4">Biểu đồ doanh thu 6 tháng gần nhất</h5>
            <div id="revenueChart" style="min-height: 320px;"></div>
        </div>
    </div>

    {{-- Recent Bookings --}}
    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8" style="padding: 20px;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Đơn hàng gần đây</h5>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-primary btn-sm">Xem tất cả</a>
            </div>
            
            @forelse($recentBookings as $booking)
            <div class="booking-item d-flex align-items-start gap-3 mb-2">
                <div class="booking-date-badge" style="background-color: #e0f2fe; color: #0284c7; flex-shrink: 0;">
                    {{ date('d/m', strtotime($booking->created_at)) }}
                </div>
                <div class="flex-grow-1 min-width-0" style="overflow: hidden;">
                    <p class="mb-0 fw-semibold text-truncate" style="font-size: 14px;">{{ $booking->user->name }}</p>
                    <p class="mb-0 text-muted text-truncate" style="font-size: 12px;">{{ $booking->product->name }}</p>
                    <p class="mb-0 fw-bold" style="font-size: 12px;">{{ number_format($booking->total_price, 0, ',', '.') }} đ</p>
                </div>
                <div style="flex-shrink: 0;">
                    @if($booking->status == 'confirmed')
                        <span class="badge badge-light-success">Confirmed</span>
                    @elseif($booking->status == 'cancelled')
                        <span class="badge badge-light-danger">Cancelled</span>
                    @else
                        <span class="badge badge-light-warning">Pending</span>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-4">
                <p class="text-muted mb-0">Chưa có đơn đặt tour nào gần đây.</p>
            </div>
            @endforelse
        </div>
    </div>
@endsection

@section('page_js')
    <script src="{{ asset('cork/src/plugins/src/apex/apexcharts.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data from Controller
            var labels = {!! json_encode($labels) !!};
            var data = {!! json_encode($revenueData) !!};

            var options = {
                chart: {
                    type: 'area',
                    height: 320,
                    toolbar: { show: false },
                    fontFamily: 'Nunito, sans-serif',
                },
                series: [{
                    name: 'Doanh thu (VNĐ)',
                    data: data
                }],
                xaxis: {
                    categories: labels,
                    labels: {
                        style: { colors: '#888', fontSize: '12px' }
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function(val) {
                            if (val >= 1000000) return (val / 1000000).toFixed(1) + 'M';
                            if (val >= 1000) return (val / 1000).toFixed(0) + 'K';
                            return val;
                        },
                        style: { colors: '#888', fontSize: '12px' }
                    }
                },
                colors: ['#4361ee'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.28,
                        opacityTo: 0.05,
                        stops: [0, 100]
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                dataLabels: { enabled: false },
                grid: {
                    borderColor: '#e0e6ed',
                    strokeDashArray: 5,
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(val);
                        }
                    }
                },
                markers: {
                    size: 4,
                    colors: ['#4361ee'],
                    strokeColors: '#fff',
                    strokeWidth: 2,
                    hover: { size: 6 }
                }
            };

            var chart = new ApexCharts(document.querySelector('#revenueChart'), options);
            chart.render();
        });
    </script>
@endsection
