<?php

namespace D\Commands;

class AnnotationCommand
{
    public function actionIndex()
    {
        $inputPath = '/home/d/projects/php/test.environment/test/vendor/rudra/cli';
        $outputPath = '/home/d/projects/php/test.environment/test/docs.md';
        $this->scandir($inputPath, $outputPath);
    }

    protected function scandir($inputPath, $outputPath) 
    {
        $directory = array_diff(scandir($inputPath), array('..', '.'));

        foreach($directory as $item) {
            if (str_contains($item, ".php")) {
                if (ctype_upper($item[0])) {

                    $fileContent = file_get_contents($inputPath . '/' . $item);
                    $className   = str_replace(".php", "", $item);

                    if (preg_match('/namespace[\\s]+([A-Za-z0-9\\\\]+?);/sm', $fileContent, $match)) {

                        $fullClassName = $match[1] . "\\" . $className;

                        if (class_exists($fullClassName) or interface_exists($fullClassName) or trait_exists($fullClassName)) {
                            print_r($fullClassName . PHP_EOL);


                            file_put_contents($outputPath, $fullClassName . PHP_EOL, FILE_APPEND);
                            // var_dump((new \ReflectionClass("$fullClassName"))->getMethods());
                        }
                    }
                }
            } else {
                $subDir = $inputPath . '/' . $item;

                if (is_dir($subDir)) {   
                    $this->scandir($subDir, $outputPath);
                }
            }
        }
    }
}
