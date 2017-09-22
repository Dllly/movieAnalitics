<script type="text/javascript>

if (!window.FIle) {
  document.getElementById('image_upload_section).style.display = "none";
}

function onDragOver(event) {
  event.preventDefault();
}

function onDrop(event) {
  event.preventDefault();

  var files = event.dataTransfer.files;
  for (var i = 0; i<files.length; i++){
    imageFileUpload(files[i]);
  }
}

function imageFileUpload(f) {
  var formData.append('image', f);
  $.ajax({
    type: 'POST',
    contentType: false,
    processData: false,
    url: 'http://example.com/image/upload',
    data: formData,
    dataType: 'Json',
    success: function(data) {
      Succeed in uploading your movie file!!
    }
  });
}
</script>
