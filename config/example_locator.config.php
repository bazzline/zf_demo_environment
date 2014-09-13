<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-09-13 
 */

return array(
    'assembler' => '\Net\Bazzline\Component\Locator\Configuration\Assembler\FromArrayAssembler',
    //'bootstrap_file' => __DIR__ . '/boostrap.php',
    'class_name' => 'ExampleLocator',
    //add class name here, depending on entries in use section, full qualified or not
    'file_exists_strategy' => '\Net\Bazzline\Component\Locator\FileExistsStrategy\SuffixWithCurrentTimestampStrategy',
    //file path where files will be generated
    'file_path' => __DIR__ . '/../module/Application/src/Application/Service',
    //format: array(['alias' => <string>], 'name' => <string>, ['is_factory' => <boolean>], ['is_shared' => <boolean>], ['method_body_builder'] => <string>)
    'instances' => array(
        array(
            'alias'         => 'UniqueInvokableInstance',
            'class_name'    => '\Application\Model\UniqueInvokableInstance',
            'is_shared'     => false
        )
    ),
    //prefix for the instance fetching
    'method_prefix' => 'get',
    'namespace' => 'Application\Service'
);