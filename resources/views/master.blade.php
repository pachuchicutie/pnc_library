<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="shortcut icon"
      type="image/png"
      href="images/favicon-32x32.png"
    />

    <link rel="shortcut icon" href="{{ asset('images/library_icon.ico') }}">

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Alata&family=Poppins:wght@400;500;700&display=swap"
      rel="stylesheet"
    />

    <script src="{{ asset('ckeditor/build/ckeditor.js') }}"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>PNC Library</title>
  </head>
  <body class="bg-slate-50">

    <style>
    .ck-editor__editable[role="textbox"] {
          /* editing area */
          min-height: 200px; 
      }

      .ck-content .image {
          /* block images */
          max-width: 80%;
          margin: 20px auto;
     }
    </style>

    <!-- Begin page -->
    @include('body.header')

    @yield('user')

    @include('sweetalert::alert')

    <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>

    @yield('editor')

</body>
</html>