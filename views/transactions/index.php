<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>
        Upload transactions files in CSV format
        <form action="/upload" method="POST" enctype="multipart/form-data">
            <input type="file" name="transaction_files[]" accept="text/csv" multiple/>
            <button type="submit">Upload</button>
        </form>
    </body>
</html>
