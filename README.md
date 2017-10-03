# pdfmerger
PDFMerger for PHP

Simple PHP class for merging multiple PDF to one single PDF

Usage

```php
use PDFMerger\Pdf;

$pdf = new Pdf();
$pdf->add('files/1.pdf');
$pdf->add('files/2.pdf');
$pdf->output('merged.pdf');
    
```