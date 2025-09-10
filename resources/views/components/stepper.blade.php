@props(['active' => 1])
@php
  $steps = [
    1 => 'Upload PDF',
    2 => 'Process',
    3 => 'Download',
  ];
@endphp
<ol class="flex items-center gap-4 text-sm">
  @foreach($steps as $i => $label)
    <li class="flex items-center gap-2">
      <span class="w-7 h-7 flex items-center justify-center rounded-full
        {{ $i <= $active ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600' }}">
        {{ $i }}
      </span>
      <span class="{{ $i <= $active ? 'font-medium' : 'text-gray-500' }}">{{ $label }}</span>
    </li>
    @if($i < 3)
      <span class="w-8 h-[2px] {{ $i < $active ? 'bg-blue-600' : 'bg-gray-200' }}"></span>
    @endif
  @endforeach
</ol>
