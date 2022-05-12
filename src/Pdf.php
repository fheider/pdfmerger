<?php

namespace PDFMerger;

use setasign\Fpdi\Fpdi;


class Pdf
{

    /**
     * Fpdi pdf instance
     *
     * @var null|Fpdi
     */
    protected $_pdf = null;

    /**
     * Pdf constructor
     *
     */
    public function __construct()
    {
        $this->_pdf = new Fpdi();
    }

    /**
     * Add file to this pdf
     *
     * @param string $filename Filename of the source file
     * @param mixed $pages Range of files (if not set, all pages where imported)
     */
    public function add($filename, $pages = [], $orientation = '', $size = '', $rotation = 0)
    {
        if (file_exists($filename)) {
            $pageCount = $this->_pdf->setSourceFile($filename);
            for ($i = 1; $i <= $pageCount; $i++) {
                if ($this->_isPageInRange($i, $pages)) {
                    $this->_addPage($i, $orientation = '', $size = '', $rotation = 0);
                }
            }
        }
        return $this;
    }

    /**
     * Output merged pdf
     *
     * @param string $type
     */
    public function output($filename, $type = 'I')
    {
        return $this->_pdf->Output($type, $filename);
    }

    /**
     * Force download merged pdf as file
     *
     * @param $filename
     * @return string
     */
    public function download($filename)
    {
        return $this->output($filename, 'D');
    }

    /**
     * Save merged pdf
     *
     * @param $filename
     * @return string
     */
    public function save($filename)
    {
        return $this->output($filename, 'F');
    }

    /**
     * Add single page
     *
     * @param $pageNumber
     * @throws \setasign\Fpdi\PdfReader\PdfReaderException
     */
    private function _addPage($pageNumber, $orientation = '', $size = '', $rotation = 0)
    {
        $pageId = $this->_pdf->importPage($pageNumber);
        $this->_pdf->addPage($orientation = '', $size = '', $rotation = 0);
        $this->_pdf->useImportedPage($pageId);
    }


    /**
     * Check if a specific page should be merged.
     * If pages are empty, all pages will be merged
     *
     * @return bool
     */
    private function _isPageInRange($pageNumber, $pages = [])
    {
        if (empty($pages)) {
            return true;
        }

        foreach ($pages as $range) {
            if (in_array($pageNumber, $this->_getRange($range))) {
                return true;
            }
        }

        return false;
    }


    /**
     * Get range by given value
     *
     * @param mixed $value
     * @return array
     */
    private function _getRange($value = null)
    {
        $value = preg_replace('/[^0-9\-.]/is', '', $value);

        if ($value == '') {
            return false;
        }

        $value = explode('-', $value);
        if (count($value) == 1) {
            return $value;
        }

        return range($value[0] > $value[1] ? $value[1] : $value[0], $value[0] > $value[1] ? $value[0] : $value[1]);
    }
}
