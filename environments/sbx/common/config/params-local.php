<?php

return [

    //client-side configuration vars
    'janus.protocol'            => 'http',
    'janus.host'                => 'janus',
    'janus.port'                => '80',
    'janus.path'                => '/janus',
    'janus.secret'              => 'janusrocks',
    'janus.adminPath'           => '/admin',
    'janus.adminSecret'         => 'janusoverlord',
    'janus.adminKey'            => 'supersecret',
    'janus.tokenAuthSecret'     => 'fcknlorenzo',

    'janus.storedAuth'          => true,
    'janus.record'              => false,

    //    'janus.stunHost'            => '',

    //    'janus.rtp.audio.host'      => '192.168.1.1',
    //    'janus.rtp.audio.port.rtp'  => '60000',
    //    'janus.rtp.audio.port.rtcp' => '60001',
    //
    //    'janus.rtp.video.host'      => '192.168.1.1',
    //    'janus.rtp.video.port.rtp'  => '60012',
    //    'janus.rtp.video.port.rtcp' => '60013',

    'mqtt.protocol'             => 'ws',
    'mqtt.host'                 => 'localhost',
    'mqtt.port'                 => '80',
    'mqtt.path'                 => '/mqtt',
];
