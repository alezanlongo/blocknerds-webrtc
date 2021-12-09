<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Advanced Project Template</h1>
    <br>
</p>

Yii 2 Advanced Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
developing complex Web applications with multiple tiers.

The template includes three tiers: front end, back end, and console, each of which
is a separate Yii application.

The template is designed to work in a team development environment. It supports
deploying the application in different environments.

Documentation is at [docs/guide/README.md](docs/guide/README.md).

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![build](https://github.com/yiisoft/yii2-app-advanced/workflows/build/badge.svg)](https://github.com/yiisoft/yii2-app-advanced/actions?query=workflow%3Abuild)

DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```

# Janus WebRTC Server: Admin/Monitor
Meetecho functional example of how you can build an UI on top of the existing Admin/Monitor interface. 

https://janus.conf.meetecho.com/admin.html

This page will only work as it is if you enabled the API (which is disabled by default) and you're using the default values.
```
Admin API backend: http://localhost:7088/admin
Admin API secret: janusoverlord
```

# Janus event handlers
Follows this guide to enable event handlers and save them into the DB.

1. Inside *janus.eventhandler.sampleevh.jcfg* set the bellow params as follows:
```
enabled = true 
backend = "https://instance-url/janus/event"
```

2. Copy *janus.eventhandler.sampleevh.jcfg* in Janus instance inside the next folder:
```
/opt/janus/etc/janus/
```

3. If your backend is secure, copy the crt file in Janus instance inside the next folder:
```
/usr/share/ca-certificates
```

4. Log into the Janus instance and run the following command:
```
dpkg-reconfigure ca-certificates
```

This will ask you a couple of questions
```
Trust new certificates from certificate authorities? 
```
Select 1 (yes) to the above question.

Next question...
```
This package installs common CA (Certificate Authority) certificates in /usr/share/ca-certificates. . Please select the certificate authorities you trust so
that their certificates are installed into /etc/ssl/certs. They will be compiled into a single /etc/ssl/certs/ca-certificates.crt file.
```
In my case the right answer was 1, but depending the name of your certificate it can differ.

5. The final step is enable the backend to start saving into the DB the http post request sent by the Janus instance. Inside the file *common/config/params.php* (or *common/config/params-local.php*) set the param *janus.eventHandler to true*.

That's it, for more information about event handlers please visit https://www.meetecho.com/blog/event-handlers-a-practical-example/

# Janus room recorder
Follows this guide to enable video room recording.

To enable the video room recording open the file *common/config/params.php* (or *common/config/params-local.php*) and set the following params as follows:
```
'janus.record' => true,
'janus.rec_dir' => '/opt/janus/share/janus/recordings',
'janus.audiocodec' => 'opus',
'janus.videocodec' => 'h264',
```

Please notice that you can change the folder where the files are store and the codec for video & audio.

For more information about video room recording please visit https://janus.conf.meetecho.com/docs/videoroom.html

The following script is an example of how to join audio and video files (.mjr) from a recorded session.
```
#!/bin/bash

# converter.sh

# Contains the prefix of the recording session of janus e.g
session_prefix="$1"
s=${session_prefix##*/}
output_file="${s%.*}"

# Create directory inside user home 
mkdir -p $HOME/recordings

echo "Converting mjr files to individual tracks ..."
janus-pp-rec $session_prefix-video.mjr $HOME/recordings/$output_file.mp4
janus-pp-rec $session_prefix-audio.mjr $HOME/recordings/$output_file.opus

echo "Done !"
```

Create the script inside the janus instance and please remember give the file the right permissions
```
RUN chmod +x converter.sh
```

Then run the script as follow
```
./converter.sh /opt/janus/share/janus/recordings/videoroom-2c52686a-35a3-45d0-b5f0-e32b384c6f5a-user-2c21a838-b13d-4a6d-8286-534bc68d3490-1633634862638573
```

Filename prefix explanation
```
/[path-to-janus-recording-files]/videoroom-[room-uuid]-user-[user-uuid]-[timestamp]
```

The joined files are now in the following path
```
$HOME/recordings
```

If you are using docker, you can use the following command in your localhost in order to move files from container to your local machine

Copying raw files to localhost
```
docker cp [CONTAINER-ID]:/opt/janus/share/janus/recordings/ ~/Downloads/
```

Copying joined files to localhost
```
docker cp [CONTAINER-ID]:/root/recordings ~/Downloads/
```

More information about how to join audio & video file can be found in the following link https://ourcodeworld.com/articles/read/1198/how-to-join-the-audio-and-video-mjr-from-a-recorded-session-of-janus-gateway-in-ubuntu-18-04