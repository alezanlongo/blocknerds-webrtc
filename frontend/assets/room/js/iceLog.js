
'use strict';

const TYPE_CANDIDATE_ICE = "icecandidate";
const TYPE_CANDIDATE_ERROR = "icecandidate";
let pc;
let stream;
let candidates;
const allServersKey = 'servers';
const stunGoogle = "stun:stun.l.google.com:19302"

$(document).ready(() => {
    doTest()
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
    console.log('event data', evt)
    const { currentTarget } = evt
    const { localDescription } = currentTarget
    // console.log('current', currentTarget)
    return {
        ice: {
            ...evt,
            candidate: evt.candidate?.toJSON(),
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
            localDescription: {
                type: localDescription.type,
                sdp: localDescription.sdp,
            },
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
    sendRequest(event)
    const { candidate } = event
    if (candidate) {
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

const iceCandidateError = (e) => {
    console.log('iceCandidateError', e)
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
