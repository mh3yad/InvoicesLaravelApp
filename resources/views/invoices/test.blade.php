<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Summernote</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
</head>
<body>
<iframe src="https://tokbox.com/embed/embed/ot-embed.js?embedId=2210e637-3979-4f41-a581-e67c0d965a5f&room=DEFAULT_ROOM&iframe=true" width="800px" height="640px" scrolling="auto" allow="microphone; camera" ></iframe>
<form action="">
    <textarea name="body" id="summernote"></textarea>
</form>
<button id="click" >funcClick</button>
<script>
    $(document).ready(function() {
        let div = $('#summernote')
       div.summernote();


        $('#click').click(function (){
            window.alert(div.val())
        })
    });
</script>
</body>
</html>
