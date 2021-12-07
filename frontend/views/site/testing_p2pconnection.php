<?php

use yii\web\View;

$this->registerJsFile(
    '/js/main.js',
    [
        'depends' => [
            "yii\web\JqueryAsset",
        ],
        'position' => View::POS_END
    ]
);
?>

<div id="container">

    <h1><a href="//webrtc.github.io/samples/" title="WebRTC samples homepage">WebRTC samples</a>
        <span>Trickle ICE</span>
    </h1>

    <section>

        <p>This page tests the trickle ICE functionality in a WebRTC implementation. It creates a PeerConnection with
            the specified ICEServers, and then starts candidate gathering for a session with a single audio stream. As
            candidates are gathered, they are displayed in the text box below, along with an indication when candidate
            gathering is complete.</p>

        <p>Note that if no getUserMedia permissions for this origin are persisted only candidates from a single
            interface will be gathered in Chrome. See <a href="https://tools.ietf.org/html/draft-ietf-rtcweb-ip-handling-01">the RTCWEB IP address handling
                recommendations draft</a> for details.<span id="getUserMediaPermissions">You have given permission, candidate from multiple interface will be gathered.</span>
        </p>

        <p>Individual STUN and TURN servers can be added using the Add server / Remove server controls below; in
            addition, the type of candidates released to the application can be controlled via the IceTransports
            constraint.</p>

        <p>If you test a STUN server, it works if you can gather a candidate with type "srflx".
            If you test a TURN server, it works if you can gather a candidate with type "relay".</p>
        <p>If you test just a single TURN/UDP server, this page even allows you to detect when you are using the wrong
            credential to authenticate.</p>

    </section>

    <section id="iceServers">

        <h2>ICE servers</h2>

        <select id="servers" size="4">
        </select>

        <div>
            <label for="url">STUN or TURN URI:</label>
            <input id="url">
        </div>

        <div>
            <label for="username">TURN username:</label>
            <input id="username">
        </div>

        <div>
            <label for="password">TURN password:</label>
            <input id="password">
        </div>

        <div>
            <button id="add">Add Server</button>
            <button id="remove">Remove Server</button>
            <button id="reset">Reset to defaults</button>
        </div>

    </section>

    <section id="iceOptions">

        <h2>ICE options</h2>

        <div id="iceTransports">
            <label for="transports"><span>IceTransports value:</span></label>
            <input type="radio" name="transports" value="all" id="all" checked>
            <span>all</span>
            <input type="radio" name="transports" value="relay" id="relay">
            <span>relay</span>
        </div>
        <div>
            <label>ICE Candidate Pool:</label>
            <span id="poolValue">0</span>
            <span class="gray">0</span>
            <input id="iceCandidatePool" type="range" min="0" max="10" value="0">
            <span class="gray">10</span>
        </div>

    </section>

    <section>
        <div>
            <input type="checkbox" name="getUserMedia" id="getUserMedia">
            <label for="getUserMedia"><span>Acquire microphone/camera permissions</span></label>
        </div>

    </section>

    <section>

        <table id="candidates">
            <thead id="candidatesHead">
                <tr>
                    <th>Time</th>
                    <th>Component</th>
                    <th>Type</th>
                    <th>Foundation</th>
                    <th>Protocol</th>
                    <th>Address</th>
                    <th>Port</th>
                    <th>Priority</th>
                    <th>Mid</th>
                    <th>MLine Index</th>
                    <th>Username Fragment</th>
                </tr>
            </thead>
            <tbody id="candidatesBody"></tbody>
        </table>
        <button id="gather">Gather candidates</button>
        <!-- <div id="error-note">Note: errors from onicecandidateerror above are not neccessarily fatal. For example an IPv6 DNS lookup may fail but relay candidates can still be gathered via IPv4.</div> -->
        <div id="error-note"></div>
        <div id="error"></div>
    </section>


    <a href="https://github.com/webrtc/samples/tree/gh-pages/src/content/peerconnection/trickle-ice" title="View source for this page on GitHub" id="viewSource">View source on GitHub</a>
</div>