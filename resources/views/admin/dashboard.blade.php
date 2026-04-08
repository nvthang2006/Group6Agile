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
        /* Custom Premium Dashboard Styles */
        :root {
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.5);
            --shadow-sm: 0 4px 15px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 10px 30px rgba(0, 0, 0, 0.1);
            --shadow-hover: 0 15px 40px rgba(0, 0, 0, 0.15);
        }
        
        .layout-px-spacing {
            background-color: #f8fafc;
        }

        .welcome-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            padding: 30px;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(118, 75, 162, 0.2);
            margin-bottom: 30px;
        }

        .welcome-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
        }

        .welcome-card h2 {
            color: white;
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .welcome-card p {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 0;
            max-width: 600px;
        }

        .stat-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid rgba(0, 0, 0, 0.02);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: transparent;
            transition: background 0.4s ease;
        }

        .stat-card.card-users::before { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
        .stat-card.card-tours::before { background: linear-gradient(90deg, #10b981, #34d399); }
        .stat-card.card-bookings::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
        .stat-card.card-revenue::before { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover);
        }

        .stat-card .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover .stat-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .stat-card.card-users .stat-icon { background: rgba(59, 130, 246, 0.1); color: #3b82f6; box-shadow: 0 0 20px rgba(59, 130, 246, 0.1); }
        .stat-card.card-tours .stat-icon { background: rgba(16, 185, 129, 0.1); color: #10b981; box-shadow: 0 0 20px rgba(16, 185, 129, 0.1); }
        .stat-card.card-bookings .stat-icon { background: rgba(245, 158, 11, 0.1); color: #f59e0b; box-shadow: 0 0 20px rgba(245, 158, 11, 0.1); }
        .stat-card.card-revenue .stat-icon { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; box-shadow: 0 0 20px rgba(139, 92, 246, 0.1); }

        .stat-card .stat-icon svg {
            width: 28px;
            height: 28px;
        }

        .stat-card h3 {
            font-size: 32px;
            font-weight: 800;
            margin: 0;
            color: #1e293b;
            letter-spacing: -0.5px;
        }

        .stat-card p {
            font-size: 14px;
            margin: 0 0 8px 0;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .widget-content-area {
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(0,0,0,0.02);
            transition: all 0.3s ease;
        }
        
        .widget-content-area:hover {
            box-shadow: var(--shadow-md);
        }

        .widget-title {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 24px;
            position: relative;
            padding-left: 14px;
        }
        
        .widget-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 18px;
            background: #4361ee;
            border-radius: 4px;
        }

        .booking-item {
            padding: 16px;
            border-radius: 12px;
            background: #ffffff;
            border: 1px solid #f1f5f9;
            transition: all 0.3s ease;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
        }

        .booking-item:hover {
            background-color: #f8fafc;
            transform: translateX(5px);
            border-color: #e2e8f0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        .booking-date-badge {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 800;
            line-height: 1.2;
            text-align: center;
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            color: #0284c7;
            box-shadow: 0 4px 10px rgba(2, 132, 199, 0.1);
        }

        .booking-info h6 {
            font-size: 15px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .booking-info p {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 0;
        }

        .booking-price {
            font-weight: 800;
            font-size: 14px;
            color: #1e293b;
            background: #f1f5f9;
            padding: 6px 12px;
            border-radius: 20px;
        }

        .badge-status {
            padding: 6px 12px;
            font-size: 11px;
            border-radius: 20px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        
        .badge-status.confirmed { background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); }
        .badge-status.cancelled { background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); }
        .badge-status.pending { background: rgba(245, 158, 11, 0.1); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.2); }

    </style>
@endsection

@section('content')

    <div class="col-12 layout-spacing">
        <div class="welcome-card">
            <h2>Chào mừng trở lại, {{ Auth::user()->name ?? 'Admin' }}! 👋</h2>
            <p>Đây là tổng quan về hoạt động hệ thống Tour Manager của bạn hôm nay. Chúc bạn một ngày làm việc hiệu quả!</p>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area stat-card card-users">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p>Khách hàng</p>
                    <h3>{{ number_format($totalUsers) }}</h3>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area stat-card card-tours">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p>Sản phẩm Tour</p>
                    <h3>{{ number_format($totalTours) }}</h3>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area stat-card card-bookings">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p>Đơn Đặt Tour</p>
                    <h3>{{ number_format($totalBookings) }}</h3>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area stat-card card-revenue">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p>Doanh thu tháng</p>
                    <h3 style="font-size: 26px;">{{ number_format($thisMonthRevenue, 0, ',', '.') }}<span style="font-size: 16px; font-weight: normal; color: #64748b;">đ</span></h3>
                </div>
                <div class="stat-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Revenue Chart --}}
    <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8" style="padding: 24px;">
            <h5 class="widget-title">Biểu đồ doanh thu 6 tháng gần nhất</h5>
            <div id="revenueChart" style="min-height: 340px; margin-top: 20px;"></div>
        </div>
    </div>

    {{-- Recent Bookings --}}
    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 layout-spacing">
        <div class="widget-content widget-content-area br-8" style="padding: 24px;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="widget-title mb-0">Đơn hàng gần đây</h5>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-primary" style="border-radius: 8px; font-weight: 600; box-shadow: 0 4px 10px rgba(67, 97, 238, 0.2);">Xem tất cả</a>
            </div>
            
            <div class="recent-bookings-list">
                @forelse($recentBookings as $booking)
                <div class="booking-item">
                    <div class="booking-date-badge me-3 flex-shrink-0">
                        {{ date('d/m', strtotime($booking->created_at)) }}
                    </div>
                    <div class="booking-info flex-grow-1 min-width-0">
                        <h6 class="text-truncate">{{ $booking->user->name }}</h6>
                        <p class="text-truncate">{{ $booking->product->name }}</p>
                    </div>
                    <div class="d-flex flex-column align-items-end ms-2 flex-shrink-0">
                        <span class="booking-price mb-2">{{ number_format($booking->total_price, 0, ',', '.') }} đ</span>
                        @if($booking->status == 'confirmed')
                            <span class="badge-status confirmed">Confirmed</span>
                        @elseif($booking->status == 'cancelled')
                            <span class="badge-status cancelled">Cancelled</span>
                        @else
                            <span class="badge-status pending">Pending</span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <div style="background: #f1f5f9; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg>
                    </div>
                    <p class="text-muted fw-bold mb-0">Chưa có đơn đặt tour nào.</p>
                </div>
                @endforelse
            </div>
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
                    height: 350,
                    toolbar: { show: false },
                    fontFamily: 'Nunito, sans-serif',
                    dropShadow: {
                        enabled: true,
                        top: 10,
                        left: 0,
                        blur: 5,
                        color: '#4361ee',
                        opacity: 0.1
                    }
                },
                series: [{
                    name: 'Doanh thu',
                    data: data
                }],
                xaxis: {
                    categories: labels,
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: {
                        style: { colors: '#64748b', fontSize: '13px', fontWeight: 600 },
                        offsetY: 5
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function(val) {
                            if (val >= 1000000) return (val / 1000000).toFixed(1) + 'M';
                            if (val >= 1000) return (val / 1000).toFixed(0) + 'K';
                            return val;
                        },
                        style: { colors: '#64748b', fontSize: '13px', fontWeight: 600 }
                    }
                },
                colors: ['#4361ee'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.05,
                        stops: [0, 100]
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                dataLabels: { enabled: false },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                    xaxis: { lines: { show: true } },
                    yaxis: { lines: { show: true } },
                    padding: { top: 0, right: 0, bottom: 0, left: 10 }
                },
                tooltip: {
                    theme: 'dark',
                    y: {
                        formatter: function(val) {
                            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(val);
                        }
                    },
                    marker: { show: false }
                },
                markers: {
                    size: 5,
                    colors: ['#fff'],
                    strokeColors: '#4361ee',
                    strokeWidth: 3,
                    hover: { size: 8 }
                }
            };

            var chart = new ApexCharts(document.querySelector('#revenueChart'), options);
            chart.render();
        });
    </script>
@endsection
