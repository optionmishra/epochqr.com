// Call the dataTables jQuery plugin
$(document).ready(function() { 	
      

    // 
    jQuery(function ($) {
      
        $('div').on('click', '.previewDelete', function () {
            $(this).prev().remove();
            $(this).remove();
            $('.logoLabel').show();
            $('#file-5').val("");
        });
        var fileDiv = document.getElementById("upload");
        var fileInput = document.getElementById("file-5");

        fileInput.addEventListener("change", function (e) {

            var filesVAR = this.files;

            showThumbnail(filesVAR);

        }, false);

        function showThumbnail(files) {
            var file = files[0]
            var thumbnail = document.getElementById("thumbnail");
            var pDiv = document.createElement("div");
            var image = document.createElement("img");
            var div = document.createElement("div");

            pDiv.setAttribute('class', 'pDiv');
            thumbnail.appendChild(pDiv);

            image.setAttribute('class', 'imgPreview');
            pDiv.appendChild(image)

            div.innerHTML = "X";
            div.setAttribute('class', 'previewDelete previewDeletediv');
            pDiv.appendChild(div)

            image.file = file;
            var reader = new FileReader()
            reader.onload = (function (aImg) {
                return function (e) {
                    aImg.src = e.target.result;
                };
            }(image))
            var ret = reader.readAsDataURL(file);
            var canvas = document.createElement("canvas");
            ctx = canvas.getContext("2d");
            image.onload = function () {
                ctx.drawImage(image, 100, 100);

                $('.logoLabel').hide();
            }
        }            

    });
    
    //
    	
});
