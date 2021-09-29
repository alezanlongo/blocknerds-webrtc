const { testMediaConnectionBitrate, testAudioOutputDevice } = Twilio.Diagnostics;

const getDevicesConnected = () => {
  return navigator.mediaDevices.enumerateDevices();
};
getDevicesConnected()
.then(data => {
    console.log('devices',data)
})
.catch(err=> console.log(err))

// navigator.mediaDevices
//   .getUserMedia({ audio: true, video: false })
//   .then(function (mediaStream) {
//     console.log("media", mediaStream);
//     const audioOutputDeviceTest = testAudioOutputDevice({
//       deviceId: 'default',
//     });
//     console.log("obj", audioOutputDeviceTest);
//   })
//   .catch(function (err) {
//     console.log("err", err);
//   });
 
const mediaConnectionBitrateTest = testMediaConnectionBitrate({
    iceServers: [{
      credential: 'bar',
      username: 'foo',
      urls: 'turn:global.turn.twilio.com:3478?transport=udp',
    }],
   });
    
   mediaConnectionBitrateTest.on('bitrate', (bitrate) => {
    console.log(bitrate);
   });
    
   mediaConnectionBitrateTest.on('error', (error) => {
    console.log(error);
   });
    
   mediaConnectionBitrateTest.on('end', (report) => {
    console.log(report);
   });
    
   setTimeout(() => {
    mediaConnectionBitrateTest.stop();
   }, 10000);

   console.log('asdas',mediaConnectionBitrateTest)