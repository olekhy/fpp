<?php

declare(strict_types=1);

namespace Fpp;

use FilterIterator;

class Scanner extends FilterIterator
{
    public function __construct(string $path, Iterator $fileOrDirIterator)
    {
        $this->strategy = $strategy;
        
        if (is_readable($path)) {
            parent::__construct($fileOrDirIterator);        
        } else {
            throw new \RuntimeException('Path: "' . $path . '" is not readable');     
        }     
    }    
    
    public function accept()
    {
        $file = $this->getInnerIterator()->current();
        
        return $file->isFile() && $file->getExtension() === 'fpp' ? true : false;
    }
}
