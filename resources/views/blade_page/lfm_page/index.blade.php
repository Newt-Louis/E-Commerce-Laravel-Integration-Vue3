<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Document</title>
  @vite(['resources/js/app.js','resources/laravel-filemanager/js/stand-alone-button.js','resources/js/jquery-init.js'])
</head>
<body>
  <div>
    <h1>Hello World!</h1>
    <div class="container">
      <div class="input-group">
       <span class="input-group-btn">
         <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
           <i class="fa fa-picture-o"></i> Choose
         </a>
       </span>
        <input id="thumbnail" class="form-control" type="text" name="filepath">
      </div>
      <div id="holder" style="margin-top:15px;max-height:100px;"></div>
    </div>
  </div>
</body>
</html>
