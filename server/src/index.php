<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>File Uploader</title>
    <meta name="description" content="A simple file upload page." />
    <meta name="Niclas" content="file_upload" />

    <link rel="icon" href="/favicon.ico" />

    <link rel="stylesheet" href="css/styles.css" />

    <!-- use module as it is mostly supported -->
    <script src="/js/scripts.js" type="module"></script>
  </head>

  <body>
    <div class="main">
      <div class="upload_container">
        <h1>File Uploader</h1>
        <form enctype="multipart/form-data" action="handleUpload.php" method="POST">
          <!-- MAX_FILE_SIZE must precede the file input field -->
          <div class="file_input_container">
            <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
            <label for="userfile_input">Dateien auswählen:</label> <input id="userfile_input" name="userfile[]" type="file" accept="image/bmp,image/jpeg,image/jpg, image/png,image/svg+xml,image/webp,application/pdf" multiple/>
          </div>
          <input type="submit" value="Abschicken" />
        </form>
      </div>
</div>
  </body>
</html>
