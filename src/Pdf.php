<?php
namespace PDFMerger;

use setasign\Fpdi\Fpdi;


class Pdf
{

    protected $_pdf = null;

    public function __construct ()
    {
        $this->_pdf = new Fpdi();
    }

    /**
     * Add file to this pdf
     *
     * @param string $filename Filename of the source file
     * @param mixed $pages Range of files (if not set, all pages where imported)
     */
    public function add($filename, $pages = null)
    {
        if (file_exists($filename))
        {
            $pageCount = $this->_pdf->setSourceFile($filename);
            for ($i = 1; $i <= $pageCount; $i++) {
                $this->_addPage($i);
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
        $this->_pdf->Output($type, $filename);
    }


    private function _addPage($pageNumber)
    {
        $pageId = $this->_pdf->importPage($pageNumber);
        $this->_pdf->addPage();
        $this->_pdf->useImportedPage($pageId);
    }

}