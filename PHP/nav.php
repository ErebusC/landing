<?php
  $current = $_SERVER['REQUEST_URI'];
?>
<div class="top-stripe"></div>
<nav class="nav">
  <div class="container">
    <div class="nav__inner">
      <a class="nav__logo" href="/" style="text-decoration: none;">
        <img class="nav__logo-mark" src="/images/sails.png" alt="Erebus" height="26">
        <div class="nav__logo-text">
          <span class="nav__logo-name">Erebus</span>
        </div>
      </a>
      <button class="nav__toggle" onclick="this.nextElementSibling.classList.toggle('nav__links--open')" aria-label="Toggle navigation">
        <span class="nav__toggle-bar"></span>
        <span class="nav__toggle-bar"></span>
        <span class="nav__toggle-bar"></span>
      </button>
      <ul class="nav__links">
        <li><a href="/" <?php if (strpos($current, '/comics') === false) echo 'aria-current="page"'; ?>>home</a></li>
        <li><a href="/comics" <?php if (strpos($current, '/comics') !== false) echo 'aria-current="page"'; ?>>comics</a></li>
      </ul>
    </div>
  </div>
</nav>
