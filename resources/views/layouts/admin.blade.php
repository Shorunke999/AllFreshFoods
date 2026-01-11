@extends('layouts.app')

@section('content')
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white">
        <nav class="mt-5 px-2">
            <a href="{{ route('admin.dashboard') }}"
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-gray-900' : 'hover:bg-gray-700' }}">
                Dashboard
            </a>

            <a href="{{ route('admin.categories.index') }}"
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md mt-1 {{ request()->routeIs('admin.categories.*') ? 'bg-gray-900' : 'hover:bg-gray-700' }}">
                Categories
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md mt-1 {{ request()->routeIs('admin.products.*') ? 'bg-gray-900' : 'hover:bg-gray-700' }}">
                Products
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md mt-1 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-900' : 'hover:bg-gray-700' }}">
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

        @yield('admin-content')
    </div>
</div>
@endsection
