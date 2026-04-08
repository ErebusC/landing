<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comics — Erebus</title>
  <link rel="stylesheet" href="../CSS/erebus.css">
  <link rel="stylesheet" href="../CSS/manga.css">
</head>
<body>

  <?php include '../PHP/nav.php'; ?>

  <section class="section" style="padding-top: var(--space-xl);">
    <div class="container">
      <p class="eyebrow">// library</p>
      <h1 class="heading-display">Comics</h1>
      <hr class="rule">
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="comic-grid">
        <?php
          include '../PHP/comics.php';
          Comics::comic_list();
        ?>
      </div>
    </div>
  </section>

</body>
</html>
