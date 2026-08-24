$(document).ready(function () {
  // Product gallery — thumbs, arrows, swipe, lightbox
  (function () {
    var gallery = document.getElementById('productGallery');
    if (!gallery) return;

    var mainImg = document.getElementById('productMainImage');
    var thumbs = gallery.querySelectorAll('.product-thumb-btn');
    var counter = document.getElementById('productGalleryCounter');
    var prevBtn = gallery.querySelector('.product-gallery-prev');
    var nextBtn = gallery.querySelector('.product-gallery-next');
    var zoomBtn = document.getElementById('productGalleryZoom');
    var lightbox = document.getElementById('productLightbox');
    var lightboxImg = document.getElementById('productLightboxImg');
    var lightboxCounter = document.getElementById('productLightboxCounter');
    var lightboxClose = document.getElementById('productLightboxClose');
    var lightboxPrev = document.getElementById('productLightboxPrev');
    var lightboxNext = document.getElementById('productLightboxNext');

    var sources = [];
    thumbs.forEach(function (btn) {
      sources.push(btn.getAttribute('data-src') || '');
    });
    if (!sources.length && mainImg) {
      sources.push(mainImg.getAttribute('src') || '');
    }

    var current = 0;
    var total = sources.length;
    var touchStartX = 0;

    function setImage(index, animate) {
      if (!total) return;
      current = (index + total) % total;
      var src = sources[current];
      if (!src || !mainImg) return;

      function apply() {
        mainImg.src = src;
        mainImg.setAttribute('data-index', String(current));
        thumbs.forEach(function (btn, i) {
          var active = i === current;
          btn.classList.toggle('active', active);
          btn.setAttribute('aria-current', active ? 'true' : 'false');
        });
        if (counter) counter.textContent = (current + 1) + ' / ' + total;
        if (lightboxCounter) lightboxCounter.textContent = (current + 1) + ' / ' + total;
        if (lightboxImg && !lightbox.hidden) lightboxImg.src = src;
      }

      if (animate) {
        mainImg.classList.add('is-switching');
        var preload = new Image();
        preload.onload = function () {
          apply();
          requestAnimationFrame(function () {
            mainImg.classList.remove('is-switching');
          });
        };
        preload.src = src;
      } else {
        apply();
      }
    }

    function openLightbox() {
      if (!lightbox || total < 1) return;
      lightboxImg.src = sources[current];
      if (lightboxCounter) lightboxCounter.textContent = (current + 1) + ' / ' + total;
      lightbox.hidden = false;
      lightbox.setAttribute('aria-hidden', 'false');
      document.body.classList.add('product-lightbox-open');
    }

    function closeLightbox() {
      if (!lightbox) return;
      lightbox.hidden = true;
      lightbox.setAttribute('aria-hidden', 'true');
      document.body.classList.remove('product-lightbox-open');
    }

    thumbs.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var idx = parseInt(btn.getAttribute('data-index'), 10);
        if (!isNaN(idx)) setImage(idx, true);
      });
    });

    if (prevBtn) prevBtn.addEventListener('click', function () { setImage(current - 1, true); });
    if (nextBtn) nextBtn.addEventListener('click', function () { setImage(current + 1, true); });
    if (zoomBtn) zoomBtn.addEventListener('click', openLightbox);
    if (mainImg) mainImg.addEventListener('click', function () {
      if (total > 1) openLightbox();
    });

    if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
    if (lightboxPrev) lightboxPrev.addEventListener('click', function () { setImage(current - 1, true); });
    if (lightboxNext) lightboxNext.addEventListener('click', function () { setImage(current + 1, true); });
    if (lightbox) {
      lightbox.addEventListener('click', function (e) {
        if (e.target === lightbox) closeLightbox();
      });
    }

    document.addEventListener('keydown', function (e) {
      if (!gallery) return;
      var lbOpen = lightbox && !lightbox.hidden;
      if (e.key === 'Escape' && lbOpen) {
        closeLightbox();
        return;
      }
      if (!lbOpen) return;
      if (e.key === 'ArrowLeft') setImage(current - 1, true);
      if (e.key === 'ArrowRight') setImage(current + 1, true);
    });

    var stage = gallery.querySelector('.product-gallery-stage');
    if (stage && total > 1) {
      stage.addEventListener('touchstart', function (e) {
        touchStartX = e.changedTouches[0].screenX;
      }, { passive: true });
      stage.addEventListener('touchend', function (e) {
        var diff = e.changedTouches[0].screenX - touchStartX;
        if (Math.abs(diff) < 40) return;
        if (diff < 0) setImage(current + 1, true);
        else setImage(current - 1, true);
      }, { passive: true });
    }

    var thumbStrip = document.getElementById('productGalleryThumbs');
    if (thumbStrip && thumbs.length) {
      thumbs.forEach(function (btn) {
        btn.addEventListener('click', function () {
          btn.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
        });
      });
    }
  })();

  // Legacy thumbnail handler
  $('.thumbnail-img').on('click', function () {
    $('.main-product-image').attr('src', $(this).attr('src'));
  });

  // Scroll reveal — product cards & sections (always visible if JS/observer fails)
  (function () {
    var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var targets = document.querySelectorAll('.product-reveal-item, .reveal-on-scroll');
    if (!targets.length) return;

    function reveal(el) {
      el.classList.add('is-visible');
    }

    function isInViewport(el) {
      var rect = el.getBoundingClientRect();
      return rect.top < window.innerHeight && rect.bottom > 0;
    }

    if (prefersReduced || !('IntersectionObserver' in window)) {
      targets.forEach(reveal);
      return;
    }

    targets.forEach(function (el) {
      if (isInViewport(el)) {
        reveal(el);
      }
    });

    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          reveal(entry.target);
          observer.unobserve(entry.target);
        }
      });
    }, { rootMargin: '0px 0px 5% 0px', threshold: 0.05 });

    targets.forEach(function (el) {
      if (!el.classList.contains('is-visible')) {
        observer.observe(el);
      }
    });
  })();

  // Smooth scroll (offset for sticky header + mobile bar)
  $('a[href^="#"]').on('click', function (e) {
    var href = this.getAttribute('href');
    if (href.length <= 1) return;
    var target = $(href);
    if (target.length) {
      e.preventDefault();
      var offset = window.innerWidth < 992 ? 130 : 90;
      $('html, body').animate({ scrollTop: target.offset().top - offset }, 500);
      closeMobileNav();
    }
  });

  // Close mobile menu on link click
  $('#mainNav .nav-link:not(.dropdown-toggle), #mainNav .dropdown-item').on('click', function () {
    if (window.innerWidth < 992) {
      closeMobileNav();
    }
  });

  function closeMobileNav() {
    var collapse = document.getElementById('mainNav');
    if (collapse && collapse.classList.contains('show')) {
      bootstrap.Collapse.getOrCreateInstance(collapse).hide();
    }
    document.body.classList.remove('nav-open');
  }

  $('#mainNav').on('show.bs.collapse', function () {
    document.body.classList.add('nav-open');
  }).on('hide.bs.collapse', function () {
    document.body.classList.remove('nav-open');
  });

  // Header shadow on scroll
  var header = document.querySelector('.site-header');
  if (header) {
    var onScroll = function () {
      header.classList.toggle('is-scrolled', window.scrollY > 8);
    };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  // Auto-dismiss alerts
  setTimeout(function () {
    $('.alert-success').fadeOut();
  }, 5000);

  // Homepage enquiry → WhatsApp
  $('#homeEnquiryForm').on('submit', function (e) {
    e.preventDefault();
    var $form = $(this);
    var name = $.trim($form.find('[name="name"]').val());
    var phone = $.trim($form.find('[name="phone"]').val());
    if (!name || !phone) {
      $form.find('[name="name"], [name="phone"]').addClass('is-invalid');
      return;
    }
    $form.find('.is-invalid').removeClass('is-invalid');
    var lines = [window.PIONEER_WA_INTRO || 'Hello, I need a price quote.', '', 'Name: ' + name, 'Phone: ' + phone];
    var product = $.trim($form.find('[name="product"]').val());
    var size = $.trim($form.find('[name="size"]').val());
    var state = $.trim($form.find('[name="state"]').val());
    var city = $.trim($form.find('[name="city"]').val());
    var qty = $.trim($form.find('[name="quantity"]').val());
    if (product) lines.push('Product: ' + product);
    if (size) lines.push('Size: ' + size);
    if (state) lines.push('State: ' + state);
    if (city) lines.push('City: ' + city);
    if (qty) lines.push('Quantity: ' + qty);
    var base = window.PIONEER_WA_BASE || 'https://wa.me/';
    var sep = base.indexOf('?') >= 0 ? '&' : '?';
    window.open(base + sep + 'text=' + encodeURIComponent(lines.join('\n')), '_blank');
  });
});
