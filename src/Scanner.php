<?php

declare(strict_types=1);

namespace Fpp;

use FilterIterator;

class Scanner extends FilterIterator
{
    public function __construct(FilesystemIterator $iterator)
    { 
        parent::__construct($iterator);                  
    }    
    
    public function accept()
    {
        $file = $this->getInnerIterator()->current();
        
        return $file->isFile() && $file->getExtension() === 'fpp' ? true : false;
    }
}
