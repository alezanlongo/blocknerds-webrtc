const TIME_OUT_MILLISECONDS = 5000;
const KIND_AUDIO_INPUT = "audioinput";
const KIND_VIDEO_INPUT = "videoinput";
const KIND_AUDIO_OUTPUT = "audiooutput";
const EVENT_END = "end";
const EVENT_VOLUME = "volume";
const EVENT_ERROR = "error";
const TOTAL_TESTS = 4;

let deviceSelected = null;
let test_performed = 0;
let log = "";

const {
  testMediaConnectionBitrate,
  testAudioOutputDevice,
  testAudioInputDevice,
  testVideoInputDevice,
} = Twilio.Diagnostics;

const logger = (obj) => {
  if (
    typeof obj === 'object' &&
    !Array.isArray(obj) &&
    obj !== null
  ) {
    str = JSON.stringify(obj, null, 4);
  } else {
    str = String(obj);
  }

  log = log + str;

  console.log(str);
}

console.log("data to diagnostics", Twilio.Diagnostics, Twilio);

const getDevicesConnected = () => {
  return navigator.mediaDevices.enumerateDevices();
};

const filterDevices = (devices, kind) => {
  return devices.filter((device) => device.kind === kind);
};

getDevicesConnected()
  .then((devices) => {
    logger({ "devices": devices })
    const optionsDevices = filterDevices(devices, KIND_AUDIO_INPUT);
    logger({ "optionsDevices": optionsDevices });
    deviceSelected = optionsDevices[0];
  })
  .catch((err) => {
    logger({ "getDevicesConnectedError": err });
  });

navigator.mediaDevices
  .getUserMedia({ audio: true, video: true })
  .then(function (mediaStream) {
    logger({ "mediaStream": { "id": mediaStream.id, "active": mediaStream.active } });
    initTests();
  })
  .catch(function (err) {
    logger({ "mediaDevicesError": String(err) })

    $("#testAudioVideoDevices h1").append('<i class="text-danger fas fa-exclamation-triangle"></i>');
    $("#testAudioVideoDevices").append('<p class="text-danger">Failed to access your computer\'s camera and microphone</p>');
    $("#testAudioVideoDevices").append('<p class="text-danger">' + err + '</p>');
  });

const initTests = () => {

  $(".overlay").removeClass("d-none");

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
    console.log("audioOutputDeviceTestVolume", volume);
  });

  audioOutputDeviceTest.on(EVENT_ERROR, (error) => {
    logger({ "audioOutputDeviceTestError": error });
    $("#testAudioOutputDevice").addClass("text-danger");
  });

  audioOutputDeviceTest.on(EVENT_END, (report) => {
    logger({ "audioOutputDeviceTestReport": report });

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
    console.log("audioInputDeviceTestVolume", volume);
  });

  audioInputDeviceTest.on(EVENT_ERROR, (error) => {
    logger({ "audioInputDeviceTestError": error });
    $("#testAudioInputDevice").addClass("text-danger");
  });

  audioInputDeviceTest.on(EVENT_END, (report) => {
    logger({ "audioInputDeviceTestReport": report });

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
    logger({ "videoInputDeviceTestError": error });
    $("#testVideoInputDevice").addClass("text-danger");
  });

  videoInputDeviceTest.on(EVENT_END, (report) => {
    logger({ "videoInputDeviceTestReport": report });

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
    logger({ "mediaConnectionBitrateTestBitrate": bitrate });
  });

  mediaConnectionBitrateTest.on(EVENT_ERROR, (error) => {
    logger({ "mediaConnectionBitrateTestError": error });
    $("#testMediaConnectionBitrate").addClass("text-danger");
  });

  mediaConnectionBitrateTest.on(EVENT_END, (report) => {
    logger({ "mediaConnectionBitrateTestReport": report });

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
    test_performed++;
    if (test_performed === TOTAL_TESTS) {
      $(".overlay").addClass("d-none");
      if (log !== "") {
        console.save(log, "diagnostic.log")
      }
    }

  }, TIME_OUT_MILLISECONDS);
};

(function (console) {

  console.save = function (data, filename) {

    if (!data) {
      alert('Console.save: No data')
      return;
    }

    if (!filename) filename = 'console.log'

    if (typeof data === "object") {
      data = JSON.stringify(data, undefined, 4)
    }

    var blob = new Blob([data], { type: 'text/json' }),
      e = document.createEvent('MouseEvents'),
      a = document.createElement('a')

    a.download = filename
    a.href = window.URL.createObjectURL(blob)
    a.dataset.downloadurl = ['text/json', a.download, a.href].join(':')
    e.initMouseEvent('click', true, false, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null)
    a.dispatchEvent(e)
  }
})(console)
