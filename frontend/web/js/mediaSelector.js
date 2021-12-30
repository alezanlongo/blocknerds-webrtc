const mediaSelector = {
    getAudioDevices: function (selectDOM) {
        if (typeof selectDOM === "object" && typeof selectDOM[0] !== "undefined" && selectDOM[0].tagName === "SELECT") {
            selectDOM = selectDOM[0]
        }
        if (selectDOM.tagName !== "SELECT") {
            return
        }
        let fn = function (m) {
            if (typeof m["audio"] !== "undefined" && typeof m["audio"] == "object") {
                m["audio"].forEach(el => {
                    let op = document.createElement('option');
                    op.value = el.deviceId;
                    op.text = el.label;
                    selectDOM.add(op)
                })
            }
        }
        this._getDevices(this._filter).then(fn)
    },
    getAllDevices: function (selectAudioDOM, selectVideoDOM, callback = null) {
        if (typeof selectAudioDOM === "object" && typeof selectAudioDOM[0] !== "undefined" && selectAudioDOM[0].tagName === "SELECT") {
            selectAudioDOM = selectAudioDOM[0]
        }
        if (selectAudioDOM.tagName !== "SELECT") {
            return
        }
        if (typeof selectVideoDOM === "object" && typeof selectVideoDOM[0] !== "undefined" && selectVideoDOM[0].tagName === "SELECT") {
            selectVideoDOM = selectVideoDOM[0]
        }
        if (selectVideoDOM.tagName !== "SELECT") {
            return
        }
        let fn = function (m) {
            if (typeof m["video"] !== "undefined" && typeof m["video"] == "object") {
                m["video"].forEach(el => {
                    let op = document.createElement('option');
                    op.value = el.deviceId;
                    op.text = el.label;
                    selectVideoDOM.add(op)
                })
            }
            if (typeof m["audio"] !== "undefined" && typeof m["audio"] == "object") {
                m["audio"].forEach(el => {
                    let op = document.createElement('option');
                    op.value = el.deviceId;
                    op.text = el.label;
                    selectAudioDOM.add(op)
                })
            }
            if (typeof callback == 'function') {
                callback(m)
            }
        }
        this._getDevices(this._filter).then(fn)
    },
    getVideoDevices: function (selectDOM) {
        if (typeof selectDOM === "object" && typeof selectDOM[0] !== "undefined" && selectDOM[0].tagName === "SELECT") {
            selectDOM = selectDOM[0]
        }
        if (selectDOM.tagName !== "SELECT") {
            return
        }
        let fn = function (m) {
            if (typeof m["video"] !== "undefined" && typeof m["video"] == "object") {
                m["video"].forEach(el => {
                    let op = document.createElement('option');
                    op.value = el.deviceId;
                    op.text = el.label;
                    selectDOM.add(op)
                })
            }
        }
        this._getDevices(this._filter)
    },

    setMediaDevice: function (videoElm, audioId, videoId) {
        const constraints =
        {
            audio: false,
            video: true
        };

        if (typeof audioId == 'boolean') {
            constraints.audio = audioId
        } else {
            constraints.audio = { deviceId: { exact: audioId } }
        }

        if (typeof videoId == 'boolean') {
            constraints.video = videoId
        } else {
            constraints.video = { deviceId: { exact: videoId } }
        }
        mediaSelector.stopAllStream();
        navigator.mediaDevices.getUserMedia(constraints).then(stream => {
            videoElm.srcObject = stream;
            mediaSelector._stream = stream;
            videoElm.play()
        }).catch(err => { console.log('ale stream error', err) });
    },
    stopAllStream: () => {
        if (mediaSelector._stream !== null) {
            mediaSelector._stream.getTracks().forEach(track => {
                track.stop()
            })
            mediaSelector._stream = null;
        }
    },
    _stream: null,
    _getDevices: async function (fn) {
        return navigator.mediaDevices.enumerateDevices().then(fn).catch(err => { console.log("mediaSelector err", err) })
    },
    _filter: function (r) {
        if (typeof (r) != "object") {
            return null
        }
        let ret = { "audio": [], "video": [] }
        r.forEach(e => {
            if (e.kind == "audioinput") {
                ret.audio.push(e)
            } else if (e.kind == "videoinput") {
                ret.video.push(e)
            }
        });
        return ret
    }


}
