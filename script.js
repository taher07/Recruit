AWS.config.region = "ap-south-1";
AWS.config.credentials = new AWS.CognitoIdentityCredentials({
  IdentityPoolId: "ap-south-1:ea4a738f-276c-486b-9415-e4ffd49bfaa5"
});

var s3 = new AWS.S3({
  apiVersion: "2006-03-01",
  params: { Bucket: "php-interview" }
});

const recordVideo = () => {
  let video = document.querySelector("video");
  let recordedChunks = [];
  navigator.mediaDevices
    .getUserMedia({
      video: true,
      audio: true
    })
    .then(stream => {
      video.srcObject = stream;
      video.addEventListener("loadedmetadata", () => {
        video.play();
      });
      video.muted = true;

      let options = { mimeType: "video/webm; codecs=vp9" };
      let recorder = new MediaRecorder(stream, options);

      recorder.start();

      document.querySelector("#done").addEventListener("click", () => {
        recorder.stop();
      });

      recorder.ondataavailable = e => {
        recordedChunks.push(e.data);
      };
      recorder.onstop = e => {
        let blob = new Blob(recordedChunks, { type: "video/webm;codecs=vp9" });
        recordedChunks = [];
        let url = window.URL.createObjectURL(blob);
        console.log(url);
        let key = document.querySelector("#key").value;
        s3.putObject(
          {
            Key: key,
            Body: blob,
            ACL: "public-read",
            ServerSideEncryption: "AES256",
            Tagging: "key1=value1&key2=value2",
            ContentType: "video/webm;codecs=vp9"
          },
          function (err, data) {
            if (err) {
              console.log(err);
            }
            console.log(`Successfully Uploaded for candidate id ${key}!`);
            window.location = "withdrawal.php";
          }
        );
      };
      recorder.onerror = e => {
        let error = e.error;
        console.log(error);
        switch (error.name) {
          case InvalidStateError:
            alert("You can't record the video right now. Try again later.");
            break;
          case SecurityError:
            alert(
              "Recording the specified source is not allowed due to security restrictions."
            );
            break;
          default:
            alert("A problem occurred while trying to record the video.");
            break;
        }
      };
    })
    .catch(e => {
      if (e.name === "NotAllowedError") {
        let element = new bootstrap.Modal(document.getElementById("warn"));
        element.show();
      }
    });
};

const getItem = name => {
  s3.listObjects({ Prefix: name }, function (err, data) {
    if (err) {
      console.log(err.message);
    }
    var href = this.request.httpRequest.endpoint.href;
    var bucketUrl = href + "php-interview/" + name;
    document.getElementById(name).src = bucketUrl;
  });
};
