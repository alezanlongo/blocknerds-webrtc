<?php

use frontend\assets\AppAsset;
use frontend\assets\echoTest\EchoTestAsset;
use frontend\assets\Janus\JanusAsset;
use yii\web\View;

JanusAsset::register($this);
EchoTestAsset::register($this);

$this->title = 'Echo Test';


$this->registerJsVar('myToken', $token, View::POS_END);

?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1>Plugin Demo: Echo Test
					<button class="btn btn-default" autocomplete="off" id="start">Start</button>
				</h1>
			</div>
			<div class="container" id="details">
				<div class="row">
					<div class="col-md-12">
						<h3>Demo details</h3>
						<p>This Echo Test demo just blindly sends you back whatever you
						send to it. You're basically attached to yourself, and so your audio
						and video you send to Janus are echoed back to you. The same
						is done for RTCP packets as well, with the information properly updated.</p>
						<p>The demo also provides a few controls to manipulate the media
						before you send them. You can mute audio and video, for instance,
						which will tell the server to drop the frames and not echo them
						back to you. You can also try and cap the bitrate: such control
						will tell the server to manipulate the RTCP REMB packets passing
						through, in order to simulate a bandwidth limitation. In case
						you're interested in testing simulcasting, add the <code>?simulcast=true</code>
						query string to the url of this page and reload it: buttons will appear
						to allow you to try and switch between lower and higher quality
						versions of the video you're capturing: notice that you may have
						to increase the bandwidth indicator to have the higher quality
						versions appear, as the browser will not encode them otherwise.</p>
						<p>Finally, this demo also includes Data Channels: whatever you
						write in the text box under your local video, will be sent via
						Data Channels to the plugins, modified by adding a fixed prefix,
						and sent back to you in the text area below the remote video.</p>
						<div class="alert alert-info">This demo, as all the others, for the
						sake of simplicity accesses the default devices you have available on
						your machine. If you're interested in a demo that shows you how you
						can select specific devices with <code>janus.js</code>, open the
						<a class="alert-link" href="devicetest.html">Devices</a> demo instead.</div>
						<p>Press the <code>Start</code> button above to launch the demo.</p>
					</div>
				</div>
			</div>
			<div class="container hide" id="videos">
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Local Stream
									<div class="btn-group btn-group-xs pull-right hide">
										<button class="btn btn-danger" autocomplete="off" id="toggleaudio">Disable audio</button>
										<button class="btn btn-danger" autocomplete="off" id="togglevideo">Disable video</button>
										<div class="btn-group btn-group-xs">
											<button id="bitrateset" autocomplete="off" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
												Bandwidth<span class="caret"></span>
											</button>
											<ul id="bitrate" class="dropdown-menu" role="menu">
												<li><a href="#" id="0">No limit</a></li>
												<li><a href="#" id="128">Cap to 128kbit</a></li>
												<li><a href="#" id="256">Cap to 256kbit</a></li>
												<li><a href="#" id="512">Cap to 512kbit</a></li>
												<li><a href="#" id="1024">Cap to 1mbit</a></li>
												<li><a href="#" id="1500">Cap to 1.5mbit</a></li>
												<li><a href="#" id="2000">Cap to 2mbit</a></li>
											</ul>
										</div>
									</div>
								</h3>
							</div>
							<div class="panel-body" id="videoleft"></div>
						</div>
						<div class="input-group margin-bottom-sm">
							<span class="input-group-addon"><i class="fa fa-cloud-upload fa-fw"></i></span>
							<input class="form-control" type="text" placeholder="Write a DataChannel message" autocomplete="off" id="datasend" onkeypress="return checkEnter(event);" disabled />
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Remote Stream <span class="label label-primary hide" id="curres"></span> <span class="label label-info hide" id="curbitrate"></span></h3>
							</div>
							<div class="panel-body" id="videoright"></div>
						</div>
						<div class="input-group margin-bottom-sm">
							<span class="input-group-addon"><i class="fa fa-cloud-download fa-fw"></i></span>
							<input class="form-control" type="text" id="datarecv" disabled />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


</div>
