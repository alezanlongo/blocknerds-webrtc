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
  testVideoInputDevice,
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
    const optionsDevices = filterDevices(devices, KIND_AUDIO_INPUT);
    console.log("options", optionsDevices);
    deviceSelected = optionsDevices[0];
  })
  .catch((err) => console.log(err));

navigator.mediaDevices
  .getUserMedia({ audio: true, video: true })
  .then(function (mediaStream) {
    console.log("media", mediaStream);
    initTests();
  })
  .catch(function (err) {
    console.log("err", err);
  });

const initTests = (devices) => {

  doAudioOutputTest();

  doAudioInputTest();

  doVideoInputTest($('#video-test'));
};

const doAudioInputTest = (deviceId = 'default') => {
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

const doAudioOutputTest = (deviceId = 'default') => {
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

const doVideoInputTest = (element) => {
  const videoInputDeviceTest = testVideoInputDevice({ element });
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
    console.log("do stop");
    compTest.stop();
  }, TIME_OUT_MILLISECONDS);
};
