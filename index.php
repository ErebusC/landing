<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Landed!</title>

  <link rel="stylesheet" href="./CSS/erebus.css">
</head>

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
          <li><a href="/" aria-current="page">home</a></li>
          <li><a href="/comics">comics</a></li>
        </ul>
      </div>
    </div>
  </nav>

<body>
	
  <section class="section" style="padding-top: var(--space-xl);">
  <div class="container">
    <div class ="es-wrap">
    <div class="search-hero">
      <p class="eyebrow">// search</p>
      <h1 class="search-hero__heading">Let's google that</h1>
      <form class="search-hero__form" role="search" action="https://google.com/search?q=" method="get">
        <input
          class="search-hero__input"
          type="search"
          name="q"
          placeholder="google.com"
          autocomplete="off"
          aria-label="Search google"
        >
        <button class="search-hero__btn" type="submit">search →</button>
      </form>
    </div>

  </div>
</section>

</body>
</html>
