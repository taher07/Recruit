<?php
return array(
    // Bootstrap the configuration file with AWS specific features
    'includes' => array('_aws'),
    'services' => array(
        // All AWS clients extend from 'default_settings'. Here we are
        // overriding 'default_settings' with our default credentials and
        // providing a default region setting.
        'default_settings' => array(
            'params' => array(
                'credentials' => array(
                    'key'    => 'AKIA2MKQM7COBN2PUUVL',
                    'secret' => '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',
                ),
                'region' => 'ap-south-1'
            )
        )
    )
);