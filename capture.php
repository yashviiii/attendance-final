<!DOCTYPE html>
<html>
<head>
  <title>Upload Image to Azure Blob Storage</title>
</head>
<body>
  <h1>Upload Image to Azure Blob Storage</h1>

  <video id="video" width="320" height="240" autoplay></video>
  <br>
  <button id="capture">Capture Image</button>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@3.8.0/dist/tf.min.js"></script>
  <script>
    // Get a reference to the video element
    const video = document.getElementById('video');

    // Get a reference to the capture button
    const captureButton = document.getElementById('capture');

    // Get the media devices and start the video stream
    navigator.mediaDevices.getUserMedia({ video: true })
      .then((stream) => {
        video.srcObject = stream;
      })
      .catch((error) => {
        console.log('Error starting video stream:', error);
      });

    // Add a click event listener to the capture button
    captureButton.addEventListener('click', () => {
      // Pause the video stream
      video.pause();

      // Take a snapshot of the video frame
      const canvas = document.createElement('canvas');
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;
      const ctx = canvas.getContext('2d');
      ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
      canvas.toBlob(function(blob) {

// Upload the image to Azure Blob Storage using jQuery and PHP
const formData = new FormData();
formData.append('image', blob, 'image.jpg');
$.ajax({
  type: 'POST',
  url: 'upload.php',
  data: formData,
  processData: false,
  contentType: false,
  success: function(response) {
    console.log('Image uploaded to Azure Blob Storage successfully.');
    console.log(response);
  },
  error: function(error) {
    console.log('Error uploading image to Azure Blob Storage:', error);
  }
});

}, 'image/jpeg', 0.8);
//       const imageData = canvas.toDataURL('image/jpeg');
//       const blob = dataURLtoBlob(imageData);
//     const file = new File([blob], 'image.jpg', { type: 'image/jpeg' });
//     console.log("file created",file);

//     // Upload the image to Azure Blob Storage using jQuery and PHP
//     const formData = new FormData();
//     formData.append('image', file);

//       // Convert the data URL to a Blob object

//       // Upload the image to Azure Blob Storage using jQuery and PHP
//       $.ajax({
//   type: 'POST',
//   url: 'upload.php',
//   data: formData,
//   processData: false,
//   contentType: false,
//   success: function(response) {
//     console.log('Image uploaded to Azure Blob Storage successfully.');
//     console.log(response);
//   },
//   error: function(error) {
//     console.log('Error uploading image to Azure Blob Storage:', error);
//   }
// });

// function dataURLtoBlob(dataURL) {
//   const byteString = atob(dataURL.split(',')[1]);
//   const mimeString = dataURL.split(',')[0].split(':')[1].split(';')[0];
//   const ab = new ArrayBuffer(byteString.length);
//   const ia = new Uint8Array(ab);
//   for (let i = 0; i < byteString.length; i++) {
//     ia[i] = byteString.charCodeAt(i);
//   }
//   return new Blob([ab], { type: mimeString });
// }
      // Resume the video stream
      video.play();
    });
  </script>
</body>
</html>
