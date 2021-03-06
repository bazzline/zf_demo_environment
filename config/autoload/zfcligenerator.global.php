<?php
/**
 * Put this file in your config/autoload directory by removing the suffix ".dist"
 * You only have to adapt the $settings array to your needs
 *
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2015-07-09
 */

return array(
    'zf_cli_generator' => array(
        'application' => array(
            'path'  => __DIR__ . '/../../public',
            'name'  => 'index.php'
        ),
        'autoload' => array(
            'path'  => __DIR__ . '/../../vendor',
            'name'  => 'autoload.php'
        ),
        'cli' => array(
            'prefix'    => 'zf: ', 'zf: ',
            'target'    => array(
                'path'      => __DIR__ . '/../..',
                'name'      => 'zf_cli'
            )
        ),
        'configuration' => array(
            'target'    => array(
                'path'  => __DIR__ . '/..',
                'name'  => 'zf_cli_configuration.php'
            )
        )
    )
);
