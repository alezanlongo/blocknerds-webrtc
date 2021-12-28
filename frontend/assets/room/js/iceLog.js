
'use strict';

const TYPE_CANDIDATE_ICE = "icecandidate";
let pc;
let stream;
let candidates;
const allServersKey = 'servers';
const stunGoogle = "stun:stun.l.google.com:19302"
const isStream = true
let LOCALSTORE_IS_TESTED;
let iceEvents = [];

$(document).ready(() => {
    LOCALSTORE_IS_TESTED = `isTested_${dataRoom.uuid}_${userProfileId}`;
    const isTestedLS = localStorage.getItem(LOCALSTORE_IS_TESTED)
    const isTested = isTestedLS !== "1"
    if (isTested) {
        doTest()
    }
})
const testEnded = (state = true) => {
    localStorage.setItem(LOCALSTORE_IS_TESTED, state ? 1 : 0)
}
const doTest = async () => {
    if (isStream) {
        stream = await navigator.mediaDevices.getUserMedia({ audio: true, video: true });
    }

    const iceTransportPolicy = "all"
    const iceCandidatePoolSize = "0"
    const iceServers = [];
    iceServers.push({ urls: [stunGoogle] });
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

const sendRequest = (events) => {
    const dataLogs = events.map(evt => buildObject(evt))
    $.post({
        url: '/ice/event',
        data: {
            userProfileId,
            uuid: dataRoom.uuid,
            logs: dataLogs
        },
        success: (data) => {
            console.log(data)
            testEnded()
        },
        error: (err) => {
            testEnded(false)
            console.log(err)
            return;
        },
    });
}

const iceCallback = (event) => {
    const { candidate } = event
    // console.log('icecb', event)
    if (candidate) {
        iceEvents.push(event)
        candidates.push(candidate);
    } else if (!('onicegatheringstatechange' in RTCPeerConnection.prototype)) {
        resetTest()
    } else {
        sendRequest(iceEvents)
    }

}

const formatPriority = (priority) => {
    return [
        priority >> 24,
        (priority >> 8) & 0xFFFF,
        priority & 0xFF
    ].join(' | ');
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