<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    <?php
      include '../PHP/comics.php';
      session_start();
      $comic_name = Comics::validate_comic($_GET['comic']);
      echo htmlspecialchars(ucwords(preg_replace("(_)", " ", $comic_name))) . ' — Erebus';
    ?>
  </title>
  <link rel="stylesheet" href="../CSS/erebus.css">
  <link rel="stylesheet" href="../CSS/nav.css">
  <link rel="stylesheet" href="../CSS/manga.css">

  <script>
    // Change page image when the page dropdown changes
    function displayImage(elem) {
      var image = document.getElementById('cPage');
      image.src = elem.value;
    }

    // Open modal on image click
    function openModal() {
      var page = document.getElementById('cPage');
      var modal = document.getElementById('readerModal');
      var modalImg = document.getElementById('modalImg');
      modalImg.src = page.src;
      modal.classList.add('reader__modal--open');
    }

    // Close modal
    function closeModal() {
      document.getElementById('readerModal').classList.remove('reader__modal--open');
    }

    // Arrow key navigation between pages
    window.addEventListener('keydown', function(event) {
      var select = document.getElementById('pageOption');
      var image = document.getElementById('cPage');

      if (event.key === 'ArrowRight') {
        select.selectedIndex += 1;
        image.src = select.value;
      } else if (event.key === 'ArrowLeft') {
        select.selectedIndex -= 1;
        image.src = select.value;
      } else if (event.key === 'Escape') {
        closeModal();
      }
    }, true);
  </script>
</head>
<body>

  <?php include '../PHP/nav.php'; ?>

  <section class="section" style="padding-top: var(--space-xl);">
    <div class="container">
      <p class="eyebrow">// reading</p>
      <h1 class="heading-display">
        <?php echo htmlspecialchars(ucwords(preg_replace("(_)", " ", $_SESSION['comic']))); ?>
      </h1>
      <hr class="rule">
    </div>
  </section>

  <section class="section">
    <div class="container">

      <div class="reader__controls">
        <div class="reader__select-wrap">
          <select id="volumeOption" class="reader__select"
                  onchange="location = this.options[this.selectedIndex].value;">
            <option value="">Volume / Chapter</option>
            <?php Comics::vol_dropdown(); ?>
          </select>
        </div>

        <div class="reader__select-wrap">
          <select id="pageOption" class="reader__select"
                  onchange="displayImage(this);">
            <option value="">Page</option>
            <?php Comics::page_dropdown(); ?>
          </select>
        </div>
      </div>

      <div class="reader__page-wrap" onclick="openModal()">
        <?php if (isset($_GET['vol']) && !empty($_GET['vol'])): ?>
          <img src="<?php echo htmlspecialchars($_SESSION['page']); ?>" id="cPage" class="reader__page" alt="Comic page">
        <?php endif; ?>
        <p class="reader__hint">← → arrow keys to turn pages &nbsp;·&nbsp; click image to zoom</p>
      </div>

    </div>
  </section>

  <!-- Fullscreen modal -->
  <div id="readerModal" class="reader__modal">
    <button class="reader__modal-close" onclick="closeModal()" aria-label="Close">&times;</button>
    <img id="modalImg" class="reader__modal-img" alt="Comic page zoomed">
  </div>

</body>
</html>
