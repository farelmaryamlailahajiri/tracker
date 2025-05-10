@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
  <!-- Card Sales -->
  <div class="bg-white p-4 rounded shadow">
    <div class="flex items-center justify-between mb-2">
      <span class="text-sm text-gray-500">Sales</span>
      <span class="text-xs text-gray-400">May 2022</span>
    </div>
    <div class="text-2xl font-semibold text-gray-800">$230,220</div>
    <div class="text-sm text-green-500 mt-1">+55% last month</div>
  </div>

  <!-- Card Customers -->
  <div class="bg-white p-4 rounded shadow">
    <div class="flex items-center justify-between mb-2">
      <span class="text-sm text-gray-500">Customers</span>
      <span class="text-xs text-gray-400">May 2022</span>
    </div>
    <div class="text-2xl font-semibold text-gray-800">$3,200</div>
    <div class="text-sm text-blue-500 mt-1">+12% last month</div>
  </div>

  <!-- Card Avg Revenue -->
  <div class="bg-white p-4 rounded shadow">
    <div class="flex items-center justify-between mb-2">
      <span class="text-sm text-gray-500">Avg Revenue</span>
      <span class="text-xs text-gray-400">May 2022</span>
    </div>
    <div class="text-2xl font-semibold text-gray-800">$2,300</div>
    <div class="text-sm text-red-500 mt-1">+210% last month</div>
  </div>
</div>

<!-- Chart Placeholder -->
<div class="bg-white p-6 rounded shadow">
  <h2 class="text-lg font-semibold mb-4">Revenue</h2>
  <div class="h-64 bg-gray-100 flex items-center justify-center text-gray-400">
    Chart Placeholder (gunakan Chart.js / Laravel chart library jika ingin dinamis)
  </div>
</div>
@endsection