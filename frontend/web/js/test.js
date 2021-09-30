const TIME_OUT_MILLISECONDS = 3000;
const KIND_AUDIO_INPUT = "audioinput";
const KIND_VIDEO_INPUT = "videoinput";
const KIND_AUDIO_OUTPUT = "audiooutput";
const EVENT_END = "end";
const EVENT_VOLUME = "volume";
const EVENT_ERROR = "error";
let deviceSelected = null;

const {
  testMediaConnectionBitrate,
  testAudioOutputDevice,
  testAudioInputDevice,
} = Twilio.Diagnostics;

console.log("twilio data to diagnostics", Twilio.Diagnostics, Twilio);
const getDevicesConnected = () => {
  return navigator.mediaDevices.enumerateDevices();
};
const filterDevices = (devices, kind) => {
  return devices.filter((device) => device.kind === kind);
};
getDevicesConnected()
  .then((devices) => {
    console.log("devices", devices);
    const optionsDevices = filterDevices(devices, KIND_AUDIO_INPUT)
    console.log('options',optionsDevices)
    // deviceSelected = optionsDevices[0];
    initTests();
  })
  .catch((err) => console.log(err));

// navigator.mediaDevices
//   .getUserMedia({ audio: true, video: false })
//   .then(function (mediaStream) {
//     console.log("media", mediaStream);

//   })
//   .catch(function (err) {
//     console.log("err", err);
//   });
const initTests = (devices) => {
//   const outputHeadphonesDeviceId = "1f7677ca74b7d45fa99f19f46187e71afc72454d3bee888e8371a74b6a2b9ee0";
//   doAudioOutputTest(outputHeadphonesDeviceId)
//     const micHeadphonesDeviceId = "92c35b5b3166c069b8c0f31d2a3a753c420a312982ccb425d92df1b765241ceb"
//   doAudioInputTest(micHeadphonesDeviceId);
  
};

const doAudioInputTest = (deviceId) => {
  const audioInputDeviceTest = testAudioInputDevice({
    deviceId,
  });
  console.log("audioInputDeviceTest", audioInputDeviceTest);

  audioInputDeviceTest.on(EVENT_VOLUME, (volume) => {
    console.log("volume", volume);
  });

  audioInputDeviceTest.on(EVENT_ERROR, (error) => {
    console.error("error", error);
  });

  audioInputDeviceTest.on(EVENT_END, (report) => {
    console.log("report", report);
  });

  stopTest(audioInputDeviceTest);
};

const doAudioOutputTest = (deviceId) => {
  const audioOutputDeviceTest = testAudioOutputDevice({
    deviceId,
  });

  audioOutputDeviceTest.on(EVENT_VOLUME, (volume) => {
    console.log("VOLUME", volume);
  });

  audioOutputDeviceTest.on(EVENT_ERROR, (error) => {
    console.error("ERROR", error);
  });

  audioOutputDeviceTest.on(EVENT_END, (report) => {
    console.log("report", report);
  });
  stopTest(audioOutputDeviceTest);
};

const doVideoInputTest = (videoElement) => {
  const videoInputDeviceTest = testVideoInputDevice({ element: videoElement });

  videoInputDeviceTest.on(EVENT_ERROR, (error) => {
    console.error(error);
  });

  videoInputDeviceTest.on(EVENT_END, (report) => {
    console.log("report", report);
  });

  stopTest(videoInputDeviceTest);
};

const doBitrateTest = () => {
  const mediaConnectionBitrateTest = testMediaConnectionBitrate({
    iceServers: [
      {
        credential: "bar",
        username: "foo",
        urls: "turn:global.turn.twilio.com:3478?transport=udp",
      },
    ],
  });

  mediaConnectionBitrateTest.on("bitrate", (bitrate) => {
    console.log(bitrate);
  });

  mediaConnectionBitrateTest.on("error", (error) => {
    console.log(error);
  });

  mediaConnectionBitrateTest.on("end", (report) => {
    console.log(report);
  });

  stopTest(mediaConnectionBitrateTest);
};
const stopTest = (compTest) => {
    setTimeout(() => {
      console.log('do stop')
    compTest.stop();
  }, TIME_OUT_MILLISECONDS);
};
