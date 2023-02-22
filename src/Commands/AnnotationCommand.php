<?php

namespace D\Commands;

class AnnotationCommand
{
    public function actionIndex()
    {
        $dir = '/home/d/projects/php/test.environment/test/vendor/rudra/container';
        $this->scandir($dir);
    }

    protected function scandir($dir) 
    {
        $directory = array_diff(scandir($dir), array('..', '.'));

        foreach($directory as $item) {
            if (str_contains($item, ".php")) {
                if (ctype_upper($item[0])) {

                    $fileContent = file_get_contents($dir . '/' . $item);
                    $className   = str_replace(".php", "", $item);

                    if (preg_match('/namespace[\\s]+([A-Za-z0-9\\\\]+?);/sm', $fileContent, $match)) {

                        $fullClassName = $match[1] . "\\" . $className;

                        if (class_exists($fullClassName) or interface_exists($fullClassName) or trait_exists($fullClassName)) {
                            print_r($fullClassName . PHP_EOL);
                            // var_dump((new \ReflectionClass("$fullClassName"))->getMethods());
                        }
                    }
                }
            } else {
                $subDir = $dir . '/' . $item;

                if (is_dir($subDir)) {   
                    $this->scandir($subDir);
                }
            }
        }
    }
}
