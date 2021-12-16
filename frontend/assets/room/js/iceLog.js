
'use strict';

const TYPE_CANDIDATE_ICE = "icecandidate";
const LOCALSTORE_IS_TESTED = "isTested";
let pc;
let stream;
let candidates;
const allServersKey = 'servers';
const stunGoogle = "stun:stun.l.google.com:19302"

$(document).ready(() => {
    const isTestedLS = localStorage.getItem(LOCALSTORE_IS_TESTED)
    const isTested = isTestedLS === null
    if(isTested){
        localStorage.setItem(LOCALSTORE_IS_TESTED, 1)
        doTest()
    }
})
const isStream = true
const doTest = async () => {
    if (isStream) {
        stream = await navigator.mediaDevices.getUserMedia({ audio: true, video: true });
    }

    const iceTransportPolicy = "all"
    const iceCandidatePoolSize = "0"
    const iceServers = [];
    iceServers.push({
        urls: [stunGoogle]
    });

    const config = { iceServers, iceTransportPolicy, iceCandidatePoolSize };
    const offerOptions = { offerToReceiveAudio: 1, offerToReceiveVideo: 1 };

    console.log(`Creating new PeerConnection with config=${JSON.stringify(config)}`);
    pc = new RTCPeerConnection(config);
    pc.onicecandidate = iceCallback;
    pc.onicegatheringstatechange = gatheringStateChange;
    pc.onicecandidateerror = iceCandidateError;
    if (stream) {
        stream.getTracks().forEach(track => pc.addTrack(track, stream));
    }
    pc.createOffer(
        offerOptions
    ).then(
        gotDescription,
        noDescription
    );
}

const gotDescription = (desc) => {
    candidates = [];
    pc.setLocalDescription(desc);
}

const noDescription = (error) => {
    console.log('Error creating offer: ', error);
    resetTest()
}

const buildObject = (evt) => {
    const { currentTarget, candidate } = evt
    const { localDescription } = currentTarget
    return {
        ice: {
            ...evt,
            // candidate2: evt.candidate?.toJSON(),
            candidate: {
                component: candidate.component,
                type: candidate.type,
                foundation: candidate.foundation,
                protocol: candidate.protocol,
                address: candidate.address,
                port: candidate.port,
                priority: candidate.priority,
                sdpMid: candidate.sdpMid,
                sdpMLineIndex: candidate.sdpMLineIndex,
                usernameFragment: candidate.usernameFragment,
            },
            type: evt.type,
            bubbles: evt.bubbles,
            cancelBubble: evt.cancelBubble,
            cancelable: evt.cancelable,
            composed: evt.composed,
            defaultPrevented: evt.defaultPrevented,
            eventPhase: evt.eventPhase,
            path: evt.path,
            returnValue: evt.returnValue,
            timeStamp: evt.timeStamp,
        },
        sdp: {
            type: localDescription.type,
            description: localDescription.sdp,
          },

    }
}

const sendRequest = (allData) => {
    const data = buildObject(allData)
    console.log('data to send', allData, data)
    $.post({
        url: '/ice/event',
        data,
        success: (data) => {
            console.log(data)
        },
        error: (err) => {
            return;
        },
    });
}

const iceCallback = (event) => {
    const { candidate } = event
    if (candidate) {
        // console.log('event',event, buildObject(event))
        sendRequest(event)
        candidates.push(candidate);
    } else if (!('onicegatheringstatechange' in RTCPeerConnection.prototype)) {
        resetTest()
    }

}
const resetTest = () => {
    pc.close();
    pc = null;
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }
}

const gatheringStateChange = () => {
    console.log('gatheringStateChange', pc?.iceGatheringState)
    if (pc.iceGatheringState !== 'complete') {
        return;
    }
    resetTest()
}

const iceCandidateError = (event) => {
    console.log('iceCandidateError', event)
}

// check if we have getUserMedia permissions.
// navigator.mediaDevices
//   .enumerateDevices()
//   .then(function (devices) {
//     devices.forEach(function (device) {
//       if (device.label !== '') {
//         document.getElementById('getUserMediaPermissions').style.display = 'block';
//       }
//     });
//   });
