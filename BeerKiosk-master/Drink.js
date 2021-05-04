//Kevins first particle
  var myParticleAccessToken = "220e78c5c659469da2ec75ac12fb4dcc3c4b68cc"
  var myDeviceId =            "240020000c47363330353437"
  var topic =                 "cse222/final"

//parces the incoming information from hardware to give to UI
function newGarageEvent(objectContainingData) {

      console.dir("I GOT HERE SOMEHOW");
      var gar = JSON.parse(objectContainingData.data);
      console.dir(gar);
      garage.stat = gar.stat;
      garage.light = gar.light;
      garage.autoDstat = gar.autoDstat;
      garage.autoB = gar.autoB;

      // Publishes the state to any listener
      console.dir("preStateChange");
      garage.stateChange()
      console.dir("Done");

    }

// Declares the door object
var garage = {

//status objects
  stat: "1",
  light: false,
  autoDstat: false,
  autoB: 100,
  autoL: 30,
  bright: 50,

  stateChangeListener: null,

  particle: null,


    // sets door timer
    setDoorTimer: function(power) {

      this.autoD = power
      var functionData = {
           deviceId:myDeviceId,
           name: "setDoorT",
           argument: ""+this.autoD,
           auth: myParticleAccessToken
      }

      // functions that provide info about the progress
      function onSuccess(e) { console.log("setDoorTimer call success") }
      function onFailure(e) { console.log("setDoorTimer call failed")
                             console.dir(e) }
      particle.callFunction(functionData).then(onSuccess,onFailure)
    },

    //Sets auto door on/off
    autoBright: function(power) {
      this.autoBstat = power
      var functionData = {
           deviceId:myDeviceId,
           name: "autoB",
           argument: ""+this.autoBstat,
           auth: myParticleAccessToken
      }
      // Include functions to provide details about the process.
      function onSuccess(e) { console.log("set autoDoor call success") }
      function onFailure(e) { console.log("set autoDoor call failed")
                             console.dir(e) }
      particle.callFunction(functionData).then(onSuccess,onFailure)
    },

    // sets light on/off
    setPump1: function(power) {
      // DONE: This is an example of calling a function
      this.light = power
      var functionData = {
           deviceId:myDeviceId,
           name: "setPump1",
           argument: ""+this.light,
           auth: myParticleAccessToken
      }
      //var particle - new Particle();
      // Include functions to provide details about the process.
      function onSuccess(e) { console.log("pump1 call success") }
      function onFailure(e) { console.log("pump1 call failed")
                             console.dir(e) }
      particle.callFunction(functionData).then(onSuccess,onFailure)
    },

    setPump2: function(power) {
      // function calling door
      this.stat = power
      var functionData = {
           deviceId:myDeviceId,
           name: "setPump2",
           argument: ""+this.stat,
           auth: myParticleAccessToken
      }
      // provides details about the process
      function onSuccess(e) { console.log("pump2 call success") }
      function onFailure(e) { console.log("pump2 call failed")
                             console.dir(e) }
      particle.callFunction(functionData).then(onSuccess,onFailure)
    },

    setStateChangeListener: function(aListener) {
      console.dir("hello")
      this.stateChangeListener = aListener;
    },

    stateChange: function() {
      // If there's a listener, call it with the data
      console.log("made it to StateChange");
      if(garage.stateChangeListener) {
        console.log("inside statechange loop");
        var state = {
          status:garage.stat,
          light:garage.light};
          console.log("pre statechange function call");
          garage.stateChangeListener(state);
          console.log("after statechange function");
      }
    },

    // setup function for initial setup
    setup: function() {
      // particle object
      particle = new Particle();
      // subscribes to the event stream and get State
      function onSuccess(stream) {
        console.log("getEventStream success")
        stream.on('event', newGarageEvent)

        var functionData = {
             deviceId:myDeviceId,
             name: "publishState",
             argument: "",
             auth: myParticleAccessToken
        }
        function onSuccess(e) { console.log("publishState success")}
        function onFailure(e) { console.log("publishState call failed")
                  console.dir(e)}
        console.log("Calling publishState")

        particle.callFunction(functionData).then(onSuccess,onFailure)

      }
      function onFailure(e) { console.log("getEventStream call failed")
                              console.dir(e) }

      // Subscribe to the stream
      console.log("Subscribing")
      particle.getEventStream( { name: topic, auth: myParticleAccessToken, deviceId: 'mine' }).then(onSuccess, onFailure)
    }
}