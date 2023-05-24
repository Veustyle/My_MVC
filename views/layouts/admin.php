<!doctype html><html lang=fr>
<head>
   <meta charset="UTF-8">
   <meta name="viewport"
         content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <link rel="stylesheet" href="/css/main.css">
   <title><?= $title ?? 'My MVC' ?></title>
   <?= $CSS ?? '' ?>
   <?= $JS ?? '' ?>
</head>
<body>
<header class="header">
   <nav class="navbar">
      <a href="/home/index">Home</a>
      <a href="/blog/index">Blog</a>
      <a href="/admin/articles">Admin</a>
      <a href="/home/logout">Logout</a>
   </nav>
   <div>
      <a href="/admin/articles">Articles</a>
      <a href="/admin/categories">Categories</a>
   </div>
</header>

<main class="main">
   <?= $pageContent ?>
</main>

<footer class="footer">
   <p>&copy; Copyright 2023</p>
</footer>
</body>
</html>