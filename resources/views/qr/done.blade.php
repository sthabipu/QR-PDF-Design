@extends('layouts.app')

@section('steps')
  <x-stepper :active="3"/>
@endsection

@section('content')
  <div class="bg-white rounded-xl shadow p-10 text-center">
    <div class="mx-auto w-16 h-16 rounded-full bg-green-100 flex items-center justify-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9 text-green-600" viewBox="0 0 24 24" fill="currentColor"><path d="M9 12l2 2 4-4M7 20h10a2 2 0 002-2V8"/></svg>
    </div>
    <h2 class="text-xl font-semibold mt-4">Your 40-up PDF is ready</h2>
    <p class="text-gray-600 mt-1">Click below to download.</p>
    <a href="{{ $downloadUrl }}" class="inline-block mt-6 px-6 py-2 bg-blue-600 text-white rounded-lg">Download PDF</a>
  </div>
@endsection
