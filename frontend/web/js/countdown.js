const handleCountdown = (endTime) => {
  const MILLISECONDS_STRING = "milliseconds";
  const eventTimeFinish = moment(endTime);
  const currentTime = moment();
  let diffTime = eventTimeFinish._i - currentTime.unix();
  let duration = moment.duration(diffTime * 1000, MILLISECONDS_STRING);
  const interval = 1000;

  setInterval(() => {
    duration = moment.duration(duration - interval, MILLISECONDS_STRING);
    if (duration.seconds() < 0) $(".spanCountdown").addClass('text-danger')
    $(".spanCountdown").text(
        checkAddZero(duration.hours()) +
        ":" +
        checkAddZero(duration.minutes()) +
        ":" +
        checkAddZero(duration.seconds())
    );
  }, interval);
};

const checkAddZero = (value) => {
  value = Math.abs(value);
  return value < 10 ? `0${value}` : `${value}`;
};

const switchSignal = (seconds) => {
  if (seconds < 0) return "+ ";
  if (seconds > 0) return "- ";
  return "";
};
