<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    
</head>
<body>
    <h5>File upload</h5>

    <button id="browseFile">Browsn File</button>

    <div class="progress" style="display: none">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="...">
            0%
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>

    <script>
        let browseFile = $('#browseFile');

        let resumable = new Resumable({
            target: '{{route('video.upload')}}',
            query: {_token:'{{ csrf_token() }}'},
            fileType: ['mp4'],
            //chunkSize: 1*1024*1024,
            headers: {
                'Accept': 'application/json'
            },
            testChunks: false,
            throttleProgressCallbacks: 1,
        });

        resumable.assignBrowse(browseFile[0]);

        resumable.on('fileAdded', function(file){
            showProgress();
            resumable.upload()
        })

        resumable.on('fileProgress', function(file){
            updateProgress(Math.floor(file.progress()*100));
        })

        resumable.on('fileSuccess', function(file, response){
            console.log(response.path)
            $('#videoPreview').attr('src','video src');
        })
        resumable.on('fileError', function(file, response){
            console.log(response)
            alert('file uploading error.')
        })


        let progress = $('.progress');
        function showProgress(){
            progress.find('.progress-bar').css('width', '0%');
            progress.find('.progress-bar').html('0%');
            progress.find('.progress-bar').removeClass('bg-success');
            progress.show();
        }
        function updateProgress(value) {
        progress.find('.progress-bar').css('width', `${value}%`)
        progress.find('.progress-bar').html(`${value}%`)
    }
    </script>

</body>
</html>