@extends('layouts.app')

@section('steps')
  <x-stepper :active="1"/>
@endsection

@section('content')
  <div class="bg-white rounded-xl shadow p-6">
    <form method="POST" action="{{ route('qr.process') }}" enctype="multipart/form-data" class="space-y-6">
      @csrf

      <div class="border-2 border-dashed rounded-xl p-10 text-center">
        <input type="file" name="pdf" accept="application/pdf" class="hidden" id="pdfInput" required>
        <label for="pdfInput" class="cursor-pointer inline-flex items-center gap-3 px-5 py-2 rounded-lg bg-blue-600 text-white">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 16v-8m0 0l-3 3m3-3l3 3M4 16a8 8 0 1116 0"/></svg>
          Browse Files
        </label>
        <p class="mt-2 text-sm text-gray-500">Supports PDF files up to 50MB</p>
        @error('pdf') <p class="text-red-600 mt-2">{{ $message }}</p> @enderror
      </div>

      {{-- Optional: expose layout knobs (pre-filled with sensible defaults) --}}
      <details class="text-sm">
        <summary class="cursor-pointer select-none">Advanced layout (mm)</summary>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-3">
          <div><label class="block mb-1">Cols</label><input name="cols" type="number" min="1" max="10" value="5" class="w-full border rounded px-2 py-1"></div>
          <div><label class="block mb-1">Rows</label><input name="rows" type="number" min="1" max="20" value="8" class="w-full border rounded px-2 py-1"></div>
          <div><label class="block mb-1">Label W</label><input name="label_w" type="number" step="0.1" value="30" class="w-full border rounded px-2 py-1"></div>
          <div><label class="block mb-1">Label H</label><input name="label_h" type="number" step="0.1" value="30" class="w-full border rounded px-2 py-1"></div>
          <div><label class="block mb-1">Gap X</label><input name="gap_x" type="number" step="0.1" value="4" class="w-full border rounded px-2 py-1"></div>
          <div><label class="block mb-1">Gap Y</label><input name="gap_y" type="number" step="0.1" value="4" class="w-full border rounded px-2 py-1"></div>
          <div><label class="block mb-1">Margin Left</label><input name="margin_left" type="number" step="0.1" value="22" class="w-full border rounded px-2 py-1"></div>
          <div><label class="block mb-1">Margin Top</label><input name="margin_top" type="number" step="0.1" value="22" class="w-full border rounded px-2 py-1"></div>
        </div>
      </details>

      <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg">Process</button>
    </form>
  </div>
@endsection
