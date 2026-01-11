@extends('layouts.app')

@section('content')
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-indigo-800 text-white">
        <nav class="mt-5 px-2">
            <a href="{{ route('vendor.dashboard') }}"
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('vendor.dashboard') ? 'bg-indigo-900' : 'hover:bg-indigo-700' }}">
                Dashboard
            </a>

            <a href="{{ route('vendor.products.index') }}"
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md mt-1 {{ request()->routeIs('vendor.products.*') ? 'bg-indigo-900' : 'hover:bg-indigo-700' }}">
                My Products
            </a>

            <a href="{{ route('vendor.orders.index') }}"
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md mt-1 {{ request()->routeIs('vendor.orders.*') ? 'bg-indigo-900' : 'hover:bg-indigo-700' }}">
                Orders
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 bg-gray-100">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mx-4 mt-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mx-4 mt-4">
                {{ session('error') }}
            </div>
        @endif

        @yield('vendor-content')
    </div>
</div>
@endsection
