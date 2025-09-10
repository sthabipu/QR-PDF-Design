<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>QR Code PDF Converter</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
  <div class="max-w-5xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-6">
      QR Code PDF Converter
      <span class="block text-sm font-normal text-gray-500">
        Convert single QR codes to 40 QR codes per page
      </span>
    </h1>
    <div class="mb-6">
      @yield('steps')
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="md:col-span-2">
        @yield('content')
      </div>
      <aside class="bg-white rounded-xl shadow p-5 h-fit">
        <h3 class="font-semibold mb-3">Instructions</h3>
        <ol class="space-y-3 text-sm list-decimal list-inside">
          <li>Upload a PDF with <strong>one QR code per page</strong>.</li>
          <li>Processing arranges QRs into <strong>40 per page (5×8)</strong>.</li>
          <li>Download the resulting PDF.</li>
        </ol>
        <div class="mt-5 border-t pt-4">
          <h4 class="font-medium mb-1">Best Results</h4>
          <ul class="text-sm space-y-1">
            <li>High-resolution QRs</li>
            <li>Clean pages (no extra marks)</li>
            <li>Consistent QR sizes</li>
          </ul>
        </div>
      </aside>
    </div>
  </div>
</body>
</html>
