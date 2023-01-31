(function() {
	// The width and height of the captured photo. We will set the
	// width to the value defined here, but the height will be
	// calculated based on the aspect ratio of the input stream.
	// Original Reference from : 
	// https://github.com/mdn/samples-server/tree/master/s/webrtc-capturestill
	// editted by doyang
  
	var width = 760;    // We will scale the photo width to this
	var height = 0;     // This will be computed based on the input stream
  
	// |streaming| indicates whether or not we're currently streaming
	// video from the camera. Obviously, we start at false.
  
	var streaming = false;
  
	// The various HTML elements we need to configure or control. These
	// will be set by the startup() function.
  
	var video = null;
	var canvas = null;
	var photo = null;
	var startbutton = null;
  
	function startup() {
	  video = document.getElementById('video');
	  canvas = document.getElementById('canvas');
	  photo = document.getElementById('photo');
		startbutton = document.getElementById('startbutton');
		
		if (video) {
			navigator.mediaDevices.getUserMedia({video: true, audio: false})
			.then(function(stream) {
			video.srcObject = stream;
			video.play();
			})
			.catch(function(err) {
			console.log("An error occurred: " + err);
			});
			video.addEventListener('canplay', function(ev){
				if (!streaming) {
					height = video.videoHeight / (video.videoWidth/width);
				
					// Firefox currently has a bug where the height can't be read from
					// the video, so we will make assumptions if this happens.
				
					if (isNaN(height)) {
					height = width / (4/3);
					}
				
					video.setAttribute('width', width);
					video.setAttribute('height', height);
					canvas.setAttribute('width', width);
					canvas.setAttribute('height', height);
					streaming = true;
				}
				}, false);
		}
	  if (startbutton) {
			startbutton.addEventListener('click', function(ev){
				takepicture();
				ev.preventDefault();
				}, false);
		}
	  
	  clearphoto();
	}

	// Fill the photo with an indication that none has been
	// captured.
  
	function clearphoto() {
		if (canvas) {
			var context = canvas.getContext('2d');
			context.fillStyle = "#AAA";
			context.fillRect(0, 0, canvas.width, canvas.height);
			var data = canvas.toDataURL('image/png');
		}
	}
	
	// Capture a photo by fetching the current contents of the video
	// and drawing it into a canvas, then converting that to a PNG
	// format data URL. By drawing it on an offscreen canvas and then
	// drawing that to the screen, we can change its size and/or apply
	// other changes before drawing it.
  
	function takepicture() {
		if (width && height) {
			var context = canvas.getContext('2d');
			canvas.width = width;
			canvas.height = height;
			context.drawImage(video, 0, 0, width, height);
			var data = canvas.toDataURL('image/png');
			var pic_list = document.getElementById('sticker');
			var img_src = document.createElement('label');
			img_src.innerHTML = `<input type="hidden" name="test" value="${data}">`;
			pic_list.appendChild(img_src);
			document.getElementById('preview').submit();
		} else {
			clearphoto();
			document.getElementById('preview').submit();
		}
	}
  
	// Set up our event listener to run the startup process
	// once loading is complete.
	window.addEventListener('load', startup, false);
	})();
	
	function previewFile(event) {
		var preview = document.getElementById('output');
		var file = event.target.files[0];
		var reader = new FileReader();

		reader.addEventListener("load", function () {
			preview.src = reader.result;
			document.getElementById('take_val').value = reader.result;
		}, false);

		if (file) {
			reader.readAsDataURL(file);
		}
	}