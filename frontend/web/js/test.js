const TIME_OUT_MILLISECONDS = 5000;
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
    console.log("mediaDevices error", err);
    $("#testAudioVideoDevices h1").append('<i class="text-danger fas fa-exclamation-triangle"></i>');
    $("#testAudioVideoDevices").append('<p class="text-danger">Failed to access your computer\'s camera and microphone</p>');
    $("#testAudioVideoDevices").append('<p class="text-danger">' + err + '</p>');
  });

const initTests = () => {

  doAudioOutputTest();

  doAudioInputTest();

  doVideoInputTest($('#video-test'));

  doBitrateTest();
};

const doAudioOutputTest = (deviceId = 'default') => {

  $("#testAudioOutputDevice").removeClass("text-secondary");

  const audioOutputDeviceTest = testAudioOutputDevice({
    deviceId,
  });

  audioOutputDeviceTest.on(EVENT_VOLUME, (volume) => {
    console.log("audioOutputDeviceTest volume", volume);
  });

  audioOutputDeviceTest.on(EVENT_ERROR, (error) => {
    console.error("audioOutputDeviceTest error", error);
    $("#testAudioOutputDevice").addClass("text-danger");
  });

  audioOutputDeviceTest.on(EVENT_END, (report) => {
    console.log("audioOutputDeviceTest report", report);

    if (report.errors.length <= 0) {
      $("#testAudioOutputDevice").addClass("text-success");
      $("#testAudioOutputDevice h4").append('<i class="fas fa-check"></i>');
    } else {
      $("#testAudioOutputDevice h4").append('<i class="fas exclamation-triangle"></i>');
      report.errors.forEach(err => {
        $("#testAudioOutputDevice").append('<p class="text-danger">' + err.message + '</p>');
      });
    }

  });

  stopTest(audioOutputDeviceTest);
};

const doAudioInputTest = (deviceId = 'default') => {

  $("#testAudioInputDevice").removeClass("text-secondary");

  const audioInputDeviceTest = testAudioInputDevice({
    deviceId,
  });

  console.log("audioInputDeviceTest", audioInputDeviceTest);

  audioInputDeviceTest.on(EVENT_VOLUME, (volume) => {
    console.log("audioInputDeviceTest volume", volume);
  });

  audioInputDeviceTest.on(EVENT_ERROR, (error) => {
    console.error("audioInputDeviceTest error", error);
    $("#testAudioInputDevice").addClass("text-danger");
  });

  audioInputDeviceTest.on(EVENT_END, (report) => {
    console.log("audioInputDeviceTest report", report);

    if (report.errors.length <= 0) {
      $("#testAudioInputDevice").addClass("text-success");
      $("#testAudioInputDevice h4").append('<i class="fas fa-check"></i>');
    } else {
      $("#testAudioInputDevice h4").append('<i class="fas exclamation-triangle"></i>');
      report.errors.forEach(err => {
        $("#testAudioInputDevice").append('<p class="text-danger">' + err.message + '</p>');
      });
    }

  });

  stopTest(audioInputDeviceTest);
};

const doVideoInputTest = (element) => {

  $("#testVideoInputDevice").removeClass("text-secondary");

  const videoInputDeviceTest = testVideoInputDevice({ element: $(element).get(0) });

  videoInputDeviceTest.on(EVENT_ERROR, (error) => {
    console.error("videoInputDeviceTest error", error);
    $("#testVideoInputDevice").addClass("text-danger");
  });

  videoInputDeviceTest.on(EVENT_END, (report) => {
    console.log("videoInputDeviceTest report", report);

    if (report.errors.length <= 0) {
      $("#testVideoInputDevice").addClass("text-success");
      $("#testVideoInputDevice h4").append('<i class="fas fa-check"></i>');
    } else {
      $("#testVideoInputDevice h4").append('<i class="fas exclamation-triangle"></i>');
      report.errors.forEach(err => {
        $("#testVideoInputDevice").append('<p class="text-danger">' + err.message + '</p>');
      });
    }
  });

  stopTest(videoInputDeviceTest);
};

const doBitrateTest = () => {

  $("#testMediaConnectionBitrate").removeClass("text-secondary");

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
    console.log("mediaConnectionBitrateTest bitrate", bitrate);
  });

  mediaConnectionBitrateTest.on("error", (error) => {
    console.log("mediaConnectionBitrateTest error", error);
    $("#testMediaConnectionBitrate").addClass("text-danger");
  });

  mediaConnectionBitrateTest.on("end", (report) => {
    console.log("mediaConnectionBitrateTest report", report);

    if (report.errors.length <= 0) {
      $("#testMediaConnectionBitrate").addClass("text-success");
      $("#testMediaConnectionBitrate h4").append('<i class="fas fa-check"></i>');
    } else {
      $("#testMediaConnectionBitrate h4").append('<i class="fas exclamation-triangle"></i>');
      report.errors.forEach(err => {
        $("#testMediaConnectionBitrate").append('<p class="text-danger">' + err.message + '</p>');
      });
    }
  });

  stopTest(mediaConnectionBitrateTest);
};

const stopTest = (compTest) => {
  setTimeout(() => {
    console.log("do stop");
    compTest.stop();
  }, TIME_OUT_MILLISECONDS);
};
