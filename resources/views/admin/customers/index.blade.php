@extends('admin.layouts.app')
@section('title', 'Customers')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap');
:root{ --p1:#5b21b6;--p2:#7c3aed;--p3:#ede9fe;--p4:#4c1d95;--ink:#0f0e17;--muted:#6b6b8a;--border:#e4e1f5;--surf:#f4f2ff;--green:#059669;--red:#dc2626; }
*{ font-family:'Sora',sans-serif; }
.mono{ font-family:'JetBrains Mono',monospace; }
.pg{ background:var(--surf);min-height:100vh;padding:28px 16px; }
.oc{ background:#fff;border:1px solid var(--border);border-radius:20px;overflow:hidden;box-shadow:0 4px 32px rgba(91,33,182,.07); }

/* header */
.oh{ background:linear-gradient(120deg,#2d1b69,#5b21b6 55%,#7c3aed);padding:22px 28px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;position:relative;overflow:hidden; }
.oh::after{ content:'';position:absolute;right:-40px;top:-40px;width:180px;height:180px;border-radius:50%;background:rgba(255,255,255,.05); }
.oh-title{ color:#fff;font-size:18px;font-weight:700;margin:0;display:flex;align-items:center;gap:10px; }
.oh-icon{ width:36px;height:36px;border-radius:10px;background:rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;font-size:15px;color:#fff; }
.btn-new{ background:#fff;color:var(--p1);border:none;border-radius:10px;padding:9px 18px;font-weight:700;font-size:13px;text-decoration:none;display:flex;align-items:center;gap:6px;box-shadow:0 2px 10px rgba(0,0,0,.12);transition:all .15s;position:relative;z-index:1; }
.btn-new:hover{ transform:translateY(-1px);color:var(--p1); }

/* search */
.search-bar{ padding:16px 24px;border-bottom:1px solid var(--border);background:#faf8ff; }
.search-form{ display:flex;gap:10px;align-items:center; }
.search-input{ flex:1;border:1.5px solid var(--border);border-radius:10px;padding:9px 14px;font-size:13px;outline:none;transition:border .15s;font-family:'Sora',sans-serif; }
.search-input:focus{ border-color:var(--p2);box-shadow:0 0 0 3px rgba(124,58,237,.1); }
.btn-search{ background:linear-gradient(135deg,var(--p2),var(--p1));color:#fff;border:none;border-radius:10px;padding:9px 18px;font-size:13px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:6px; }
.btn-reset{ background:#fff;border:1.5px solid var(--border);border-radius:10px;padding:9px 14px;font-size:13px;color:var(--muted);text-decoration:none;display:flex;align-items:center;gap:6px; }
.btn-reset:hover{ border-color:var(--p2);color:var(--p2); }

/* stats */
.stats{ display:flex;border-bottom:1px solid var(--border);background:#faf8ff;flex-wrap:wrap; }
.stat{ flex:1;min-width:100px;padding:14px 20px;border-right:1px solid var(--border); }
.stat:last-child{ border-right:none; }
.stat-n{ font-size:22px;font-weight:700;font-family:'JetBrains Mono',monospace;color:var(--p1); }
.stat-l{ font-size:10.5px;color:var(--muted);font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-top:2px; }

/* table */
.tw{ overflow-x:auto; }
table.ct{ width:100%;border-collapse:separate;border-spacing:0; }
table.ct thead th{ background:#f3f0fc;color:var(--p4);font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;padding:13px 16px;border-bottom:2px solid var(--border);white-space:nowrap; }
table.ct tbody tr{ transition:background .12s; }
table.ct tbody tr:hover{ background:#faf7ff; }
table.ct tbody td{ padding:14px 16px;vertical-align:middle;border-bottom:1px solid #f0edf9; }

/* avatar */
.avatar{ width:42px;height:42px;border-radius:12px;object-fit:cover;border:2px solid var(--border); }
.avatar-placeholder{ width:42px;height:42px;border-radius:12px;background:linear-gradient(135deg,var(--p2),var(--p4));display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:700;color:#fff;flex-shrink:0; }

.c-name{ font-size:13.5px;font-weight:700;color:var(--ink); }
.c-sub{ font-size:12px;color:var(--muted);margin-top:3px; }

/* action btns */
.ag{ display:flex;gap:6px;justify-content:center; }
.abtn{ width:32px;height:32px;border-radius:8px;border:none;display:inline-flex;align-items:center;justify-content:center;font-size:12px;text-decoration:none;transition:all .15s;cursor:pointer; }
.abtn.view{ background:#ede9fe;color:var(--p2); }
.abtn.edit{ background:#dcfce7;color:#15803d; }
.abtn.del { background:#fee2e2;color:var(--red); }
.abtn.view:hover{ background:var(--p2);color:#fff;transform:translateY(-2px); }
.abtn.edit:hover{ background:#15803d;color:#fff;transform:translateY(-2px); }
.abtn.del:hover { background:var(--red);color:#fff;transform:translateY(-2px); }

/* empty */
.empty{ text-align:center;padding:60px 20px; }
.empty-ico{ width:72px;height:72px;border-radius:20px;background:var(--p3);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-size:28px;color:#a78bfa; }

/* alert */
.alert-s{ background:#dcfce7;border:1px solid #86efac;color:#15803d;border-radius:10px;padding:12px 18px;margin:16px 24px;font-size:13px;font-weight:600;display:flex;align-items:center;gap:8px; }
.alert-e{ background:#fee2e2;border:1px solid #fca5a5;color:var(--red);border-radius:10px;padding:12px 18px;margin:16px 24px;font-size:13px;font-weight:600;display:flex;align-items:center;gap:8px; }

.pagination .page-link{ color:var(--p2);border-color:var(--border);border-radius:8px;margin:0 2px;font-size:13px; }
.pagination .page-item.active .page-link{ background:linear-gradient(135deg,var(--p2),var(--p4));border-color:var(--p2);color:#fff; }
</style>

<div class="pg">
<div class="oc">

    <div class="oh">
        <h5 class="oh-title">
            <span class="oh-icon"><i class="fa fa-users"></i></span>
            Customers
        </h5>
        <a href="{{ route('admin.customers.create') }}" class="btn-new">
            <i class="fa fa-plus"></i> Add Customer
        </a>
    </div>

    @if(session('success'))
    <div class="alert-s"><i class="fa fa-check-circle"></i>{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert-e"><i class="fa fa-times-circle"></i>{{ session('error') }}</div>
    @endif

    {{-- SEARCH --}}
    <div class="search-bar">
        <form action="{{ route('admin.customers.index') }}" method="GET" class="search-form">
            <input type="text" name="search" class="search-input"
                placeholder="Search by name, email or phone..."
                value="{{ request('search') }}">
            <button type="submit" class="btn-search"><i class="fa fa-search"></i> Search</button>
            @if(request('search'))
            <a href="{{ route('admin.customers.index') }}" class="btn-reset"><i class="fa fa-times"></i></a>
            @endif
        </form>
    </div>

    {{-- STATS --}}
    <div class="stats">
        <div class="stat">
            <div class="stat-n">{{ $customers->total() }}</div>
            <div class="stat-l">Total Customers</div>
        </div>
        <div class="stat">
            <div class="stat-n" style="color:#059669;">{{ $customers->where('status',1)->count() }}</div>
            <div class="stat-l">Active</div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="tw">
    <table class="ct">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Address</th>
                <th style="text-align:center;">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($customers as $customer)
        <tr>
            <td style="color:var(--muted);font-size:12px;font-weight:600;">{{ $loop->iteration }}</td>

            <td>
                <div style="display:flex;align-items:center;gap:12px;">
                    @if($customer->image)
                        <img src="{{ Storage::url($customer->image) }}" class="avatar" alt="{{ $customer->name }}">
                    @else
                        <div class="avatar-placeholder">{{ strtoupper(substr($customer->name,0,1)) }}</div>
                    @endif
                    <div>
                        <div class="c-name">{{ $customer->name }}</div>
                        <div class="c-sub">ID #{{ $customer->id }}</div>
                    </div>
                </div>
            </td>

            <td>
                <span class="mono" style="font-size:13px;">{{ $customer->phone ?? '—' }}</span>
            </td>

            <td style="font-size:13px;color:var(--muted);">{{ $customer->email ?? '—' }}</td>

            <td style="font-size:12.5px;color:var(--muted);max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                {{ $customer->address ?? '—' }}
            </td>

            <td style="text-align:center;">
                <div class="ag">
                    <a href="{{ route('admin.customers.show', $customer->id) }}" class="abtn view" title="View"><i class="fa fa-eye"></i></a>
                    <a href="{{ route('admin.customers.edit', $customer->id) }}" class="abtn edit" title="Edit"><i class="fa fa-pen"></i></a>
                    <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST"
                        onsubmit="return confirm('Delete this customer?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="abtn del" title="Delete"><i class="fa fa-trash"></i></button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6">
                <div class="empty">
                    <div class="empty-ico"><i class="fa fa-users"></i></div>
                    <p style="color:var(--muted);font-size:14px;margin:0;">No customers found.</p>
                </div>
            </td>
        </tr>
        @endforelse
        </tbody>
    </table>
    </div>

    @if($customers->hasPages())
    <div style="display:flex;justify-content:center;padding:20px;border-top:1px solid var(--border);background:#faf8ff;">
        {{ $customers->withQueryString()->links() }}
    </div>
    @endif

</div>
</div>
@endsection