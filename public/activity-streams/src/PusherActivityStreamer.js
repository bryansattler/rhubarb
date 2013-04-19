$(function() {
  var pusher = new Pusher('207a7ad08456908ddc9a');
  var channel = pusher.subscribe('site-activity');
  var streamer = new PusherActivityStreamer(channel, '#activity_stream');
});