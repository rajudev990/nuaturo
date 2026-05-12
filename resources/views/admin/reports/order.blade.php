@extends('admin.layouts.app')
@section('title', 'Sales Report')

@section('content')
<style>
@media print {
    .no-print { display: none !important; }
    body { background: #fff !important; }
    .card { box-shadow: none !important; border: 1px solid #ddd !important; }
}
</style>

<div class="container-fluid py-4 px-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <div>
            <h4 class="fw-bold mb-0 text-dark">Sales Report</h4>
            <p class="text-muted small mb-0">Completed orders — filtered view</p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-print me-1"></i> Print
            </button>
            <button id="export-excel-button" class="btn btn-sm btn-outline-success">
                <i class="fas fa-file-excel me-1"></i> Export Excel
            </button>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="card border-0 shadow-sm rounded-3 mb-4 no-print">
        <div class="card-body p-4">
            <form method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small">Order / Invoice</label>
                        <input type="text" name="keyword" value="{{ request('keyword') }}"
                            class="form-control form-control-sm" placeholder="Search invoice..." />
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small">Product</label>
                        <select name="product_id" class="form-select form-select-sm">
                            <option value="">All Products</option>
                            @foreach($products as $p)
                            <option value="{{ $p->id }}" {{ request('product_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <!--<div class="col-md-2">-->
                    <!--    <label class="form-label fw-semibold small">Customer</label>-->
                    <!--    <select name="user_id" class="form-select form-select-sm">-->
                    <!--        <option value="">All Customers</option>-->
                    <!--        @foreach($users as $u)-->
                    <!--        <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>-->
                    <!--            {{ $u->name }}-->
                    <!--        </option>-->
                    <!--        @endforeach-->
                    <!--    </select>-->
                    <!--</div>-->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small">Start Date</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="form-control form-control-sm" />
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small">End Date</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                            class="form-control form-control-sm" />
                    </div>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <button class="btn btn-sm btn-primary px-4">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.order_report') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-times me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body p-3">
                    <p class="text-muted small mb-1">Total Items Sold</p>
                    <h4 class="fw-bold mb-0 text-dark">{{ number_format($total_item) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body p-3">
                    <p class="text-muted small mb-1">Total Revenue</p>
                    <h4 class="fw-bold mb-0 text-success">৳ {{ number_format($total_sales, 2) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body p-3">
                    <p class="text-muted small mb-1">Total Purchase Cost</p>
                    <h4 class="fw-bold mb-0 text-danger">৳ {{ number_format($total_purchase, 2) }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-body p-3">
                    <p class="text-muted small mb-1">Net Profit</p>
                    <h4 class="fw-bold mb-0" style="color:#1B3A6B;">৳ {{ number_format($total_sales - $total_purchase, 2) }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Daily Summary --}}
    @if($dailySummary->count() > 0)
    <div class="card border-0 shadow-sm rounded-3 mb-4 no-print">
        <div class="card-header bg-white border-bottom py-3 d-flex align-items-center gap-2">
            <i class="fas fa-calendar-alt text-primary"></i>
            <span class="fw-bold small">Daily Breakdown</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-hover mb-0 align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th class="text-start ps-3">Date</th>
                            <th>Orders</th>
                            <th>Qty Sold</th>
                            <th>Revenue</th>
                            <th>Cost</th>
                            <th>Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dailySummary as $day)
                        <tr>
                            <td class="text-start ps-3 fw-semibold">
                                {{ \Carbon\Carbon::parse($day['date'])->format('d M Y') }}
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ $day['orders'] }}</span></td>
                            <td>{{ number_format($day['qty']) }}</td>
                            <td class="text-success fw-semibold">৳ {{ number_format($day['revenue'], 2) }}</td>
                            <td class="text-danger">৳ {{ number_format($day['purchase'], 2) }}</td>
                            <td class="fw-bold" style="color:#1B3A6B;">
                                ৳ {{ number_format($day['revenue'] - $day['purchase'], 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- Order Items Table --}}
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-list-ul text-primary"></i>
                <span class="fw-bold small">Order Details</span>
            </div>
            <div class="no-print">
                {{ $orders->onEachSide(1)->links('vendor.pagination.custom-tailwind') }}
            </div>
        </div>
        <div id="content-to-export" class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th class="text-start ps-3">Date</th>
                            <th>Invoice</th>
                            <th class="text-start">Customer</th>
                            <th class="text-start">Product</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Purchase</th>
                            <th>Total Sale</th>
                            <th>Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        @php
                            $unitSale     = $order->price ?? 0;
                            $unitPurchase = $order->product->purchase_price ?? 0;
                            $rowSale      = $unitSale     * $order->quantity;
                            $rowPurchase  = $unitPurchase * $order->quantity;
                            $rowProfit    = $rowSale - $rowPurchase;
                        @endphp
                        <tr>
                            <td class="text-start ps-3 text-muted small">
                                {{ optional($order->order?->created_at)->format('d M Y') ?? '—' }}
                            </td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->order_id) }}"
                                    class="text-decoration-none fw-semibold small" style="color:#1B3A6B;">
                                    #{{ $order->order->order_id ?? '—' }}
                                </a>
                            </td>
                            <td class="text-start">
                                <p class="mb-0 fw-semibold small">{{ $order->order->user->name ?? '—' }}</p>
                                <p class="mb-0 text-muted" style="font-size:11px;">{{ $order->order->user->phone ?? '' }}</p>
                            </td>
                            <td class="text-start">
                                <span class="small fw-semibold">{{ $order->product->name ?? '—' }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $order->quantity }}</span>
                            </td>
                            <td class="small">৳ {{ number_format($unitSale, 2) }}</td>
                            <td class="small text-danger">৳ {{ number_format($unitPurchase, 2) }}</td>
                            <td class="fw-semibold text-success">৳ {{ number_format($rowSale, 2) }}</td>
                            <td class="fw-bold" style="color:#1B3A6B;">৳ {{ number_format($rowProfit, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="py-5 text-muted">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                No records found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="4" class="text-end fw-bold pe-3">Page Total</td>
                            <td class="fw-bold">
                                {{ $orders->sum('quantity') }}
                            </td>
                            <td></td>
                            <td class="text-danger fw-bold">
                                ৳ {{ number_format($orders->sum(fn($i) => ($i->product->purchase_price ?? 0) * $i->quantity), 2) }}
                            </td>
                            <td class="text-success fw-bold">
                                ৳ {{ number_format($orders->sum(fn($i) => ($i->price ?? 0) * $i->quantity), 2) }}
                            </td>
                            <td class="fw-bold" style="color:#1B3A6B;">
                                ৳ {{ number_format(
                                    $orders->sum(fn($i) => ($i->price ?? 0) * $i->quantity) -
                                    $orders->sum(fn($i) => ($i->product->purchase_price ?? 0) * $i->quantity), 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-end fw-bold pe-3">Grand Total (All Pages)</td>
                            <td class="text-danger fw-bold">৳ {{ number_format($total_purchase, 2) }}</td>
                            <td class="text-success fw-bold">৳ {{ number_format($total_sales, 2) }}</td>
                            <td class="fw-bold" style="color:#1B3A6B;">৳ {{ number_format($total_sales - $total_purchase, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination bottom --}}
    <div class="d-flex justify-content-center mt-3 no-print">
        {{ $orders->appends(request()->query())->links('vendor.pagination.custom-tailwind') }}
    </div>

</div>
@endsection

@section('script')
<script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<script>
$(document).ready(function () {
    $('#export-excel-button').on('click', function () {
        $('#content-to-export table').table2excel({
            exclude: '.no-export',
            name: 'Sales Report',
            filename: 'sales_report_{{ now()->format("Y_m_d") }}'
        });
    });
});
</script>
@endsection