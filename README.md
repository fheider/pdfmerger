#PDFMerger for PHP
Simple PHP class for merging multiple PDF to one single PDF

### Installation

Use composer to install PDFMerger. Change your minium stability to "RC", because a dependent package (FPDI) is only available as RC currently.

```
composer install fheider/pdfmerger
```

```json
{
  "require": {
      "fheider/pdfmerger": "^1.0"
  },
  "minimum-stability": "RC"
}
```

### Getting started

Create an empty PDF

```php
use PDFMerger\Pdf;
$pdf = new Pdf();
```

Add multiple PDFs. It is possible to extract single pages or page ranges.

```php
$pdf->add('files/1.pdf');           // -- merge all pages
$pdf->add('files/2.pdf', [2]);      // -- merge only page 2
$pdf->add('files/3.pdf', [2-5]);    // -- merge page 2 to 5
```

Output the merged PDF.

```php
$pdf->output('merged.pdf');         // -- send pdf to inline browser
$pdf->download('merged.pdf');       // -- force download
$pdf->save('merged.pdf');           // -- save merged pdf to new file
```
