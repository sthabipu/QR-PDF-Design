# QR Code PDF Converter (40‑up)

Convert a **PDF with one QR per page** into an **A4 sheet with up to 40 QRs (5×8)** — perfect for label sheets.

This is a tiny **Laravel** app with a clean 3‑step dashboard:

1) **Upload PDF** → 2) **Process** → 3) **Download PDF**

---

## ✨ Features

- **40‑up layout** by default (5 columns × 8 rows)
- **Precise label geometry** controls (millimeters): columns/rows, label size, gaps, margins
- **Vector‑safe**: imports each source page with FPDI to keep QRs crisp
- **Windows/Laragon‑friendly** upload handling
- No database required (uses **file sessions**)
- Output stored under `storage/app/public/qrsheets` (public via `storage` symlink)

---

## 🧰 Tech Stack

- **Laravel 11**
- **setasign/fpdi-fpdf** for PDF import & placement
- **TailwindCSS (CDN)** for the simple dashboard UI

---

## ✅ Requirements

- PHP **8.2+**
- Composer
- Web server (Laravel's built‑in server is fine)
- (Optional) GD/Imagick if you later add cropping/regeneration features

---

## 📦 Installation

```bash
# 1) Create the project
composer create-project laravel/laravel qr-pdf-40up
cd qr-pdf-40up

# 2) Add the PDF library
composer require setasign/fpdi-fpdf:^2.0

# 3) Expose storage/public for downloads
php artisan storage:link
```

### Minimal `.env` setup

Use file sessions to avoid DB driver issues:

```env
SESSION_DRIVER=file
```

> You can switch to DB sessions later if you enable SQLite/MySQL and run migrations.

---

## ▶️ Run

```bash
php artisan serve
```
Open `http://127.0.0.1:8000`, upload your **1‑QR‑per‑page** PDF, click **Process**, then **Download** the generated 40‑up PDF.

---

## 🗂 Project Structure (relevant files)

```
app/
  Http/Controllers/Qr40UpController.php   # Upload → Process → Download flow
  Services/Pdf40UpService.php             # Core: tiles pages into a 5×8 grid
resources/
  views/
    layouts/app.blade.php                 # Basic layout + sidebar instructions
    components/stepper.blade.php          # 3-step progress header
    qr/index.blade.php                    # Step 1: Upload + advanced options
    qr/done.blade.php                     # Step 3: Download page
routes/
  web.php                                 # GET / and POST /process
```

---

## 🔧 How It Works

- Each page from your source PDF (one QR per page) is **imported as a template** with FPDI.
- The service **scales** that page to your **label size** and **places** it into a cell in an A4 grid.
- When a sheet fills (e.g., 40 cells), a **new A4 page** is added; processing continues until all pages are placed.

**Default A4 layout (mm):**

| Setting        | Default |
|----------------|---------|
| Columns × Rows | 5 × 8   |
| Label Width    | 30.0 mm |
| Label Height   | 30.0 mm |
| Gap X          | 4.0 mm  |
| Gap Y          | 4.0 mm  |
| Margin Left    | 22.0 mm |
| Margin Top     | 22.0 mm |

You can override all of these via the **“Advanced layout (millimeters)”** panel in the upload form.

---

## 🖨 Printing Tips

- In print settings, choose **Actual size / 100% scale** (avoid “Fit to page”).
- Do a **test print** on plain paper; hold it behind your label sheet against light to check alignment.
- Fine‑tune by adjusting: `margin_left`, `margin_top`, `gap_x`, `gap_y`, `label_w`, `label_h`.

---

## 🚑 Troubleshooting

### 1) `could not find driver (Connection: sqlite ...)`
Laravel tried DB sessions. Use file sessions (no DB required):

```env
SESSION_DRIVER=file
php artisan config:clear
```

### 2) `fopen(...storage/app/uploads/xxx.pdf): Failed to open stream`
The upload didn't land in storage before processing. This project includes a **Windows‑safe** file move:

- Ensures `storage/app/uploads` exists
- Moves the uploaded file with a UUID filename
- Uses the absolute path when calling FPDI

Checklist:
- The upload form has `enctype="multipart/form-data"`
- `php.ini`: `file_uploads=On`; `upload_max_filesize` & `post_max_size` exceed your PDF size
- You ran `php artisan storage:link` once

### 3) Output not downloadable
Ensure the generated file goes to `storage/app/public/qrsheets` and that the public `storage/` symlink exists.

---

## 🧪 Large PDFs / Performance

A few hundred pages is fine to process synchronously. For very large inputs, convert the controller to dispatch a **queued job** and show a progress page (can be added later).

---

## 🧩 Optional Enhancements

- **Crop only the QR** (remove barcode/text): add an Imagick step to rasterize + crop each source page, then place PNGs into the grid.
- **Regenerate QRs from raw data** instead of importing pages: use `simplesoftwareio/simple-qrcode` + `barryvdh/laravel-dompdf` and a CSS grid.

---

## 🔒 Storage Notes

- Uploads saved under `storage/app/uploads`
- Generated PDFs saved under `storage/app/public/qrsheets`
- Public access via the `public/storage` symlink created by `php artisan storage:link`
- Consider a scheduled cleanup for stale files in production

---

## 🔗 Key Code References

**Routing (`routes/web.php`)**
```php
Route::get('/', [\App\Http\Controllers\Qr40UpController::class, 'index'])->name('qr.index');
Route::post('/process', [\App\Http\Controllers\Qr40UpController::class, 'process'])->name('qr.process');
```

**Service call**
```php
$svc->make($absoluteInputPdfPath, $absoluteOutputPdfPath, [
  // optional overrides: 'cols','rows','label_w','label_h','gap_x','gap_y','margin_left','margin_top'
]);
```

---

## 🤝 Contributing

PRs and issues are welcome — especially label presets and cropping modes. Please include measured values and a sample PDF when possible.

---

## 📝 License

MIT — do whatever you like; attribution appreciated.
