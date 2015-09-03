function initialize() {}

function loadScript() {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp' +
      '&sensor=false&callback=initialize';
  document.body.appendChild(script);
}

window.onload = loadScript;
