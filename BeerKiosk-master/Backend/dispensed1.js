console.log("running");

var Particle = require('particle-api-js');
var particle = new Particle();
var token;

// particle.login({username: 'user@email.com', password: 'pass'}).then(
//   function(data) {
//     token = data.body.access_token;
//   },
//   function (err) {
//     console.log('Could not log in.', err);
//   }
// );

var myParticleAccessToken = "6a71966c0e9c9f08ddcb16664668a3217f128297"
var myDeviceId =            "2f001b001247363336383437"
var topic =                 "cse521/final"

particle.getEventStream({ deviceId: myDeviceId, auth: myParticleAccessToken }).then(function(stream) {
    stream.on('event', function(data) {
      console.log("Event: ", data);
    });
  });