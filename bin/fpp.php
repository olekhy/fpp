<?php

declare(strict_types=1);

namespace Fpp;

require __DIR__ . '/../vendor/autoload.php';

if (! isset($argv[1], $argv[2])) {
    echo "Missing input directory or file argument and output file argument";
    echo PHP_EOL;
    echo "Usage: " . basename($argv[0]) . " ./directory/to/scan output_file.php";
    exit(1);
} 

if (! is_readable($argv[1])) {
    echo "Directory '" . $argv[1] . "' to scan is not readable";
    exit(1);
}

$path = $argv[1];
$output = $argv[2];

$fsIterator = new FilesystemIterator($path, FilesystemIterator::CURRENT_AS_FILEINFO);
/* @var \SplFileInfo[] $scanner*/
$scanner = new Scanner($fsIterator);
$parser = new Parser();
$collection = new DefinitionCollection();

foreach ($scanner as $file) {
    $fileContent = file_get_contents($file->getRealPath());
    $definition = $parser->parse($fileContent);
    $collection = $collection->merge($definition);
}

$dumper = new Dumper();
$php = $dumper->dump($collection);

file_put_contents($output, $php);
