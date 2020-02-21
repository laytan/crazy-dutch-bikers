require('./bootstrap');
import 'bootstrap';
import LazyLoad from 'vanilla-lazyload';
import Cart from './cart';
window.Cart = Cart;
import AudioTheme from './audio-theme';
import ImageUpload from './image-upload';
import ImagesUpload from './images-upload';

(() => {
  $(window).on('load', () => {
    copyModalsToFooter();
    setupLazyCarousels();

    AudioTheme.initialize();
    ImageUpload.initialize();
    ImagesUpload.initialize();

    new LazyLoad({
      elements_selector: 'img.lazy'
    });

    // Handle fullscreening gallery images
    $('.gallery-grid__image-wrap').on('click', (e) => {
      const wrap =  $(e.target).parents('.gallery-grid__image-wrap');
      wrap.toggleClass('gallery-grid__image-wrap--full');
    });
    matchHeights();
    pulsateLogo();

    // data-submit submits the form with that selector on click
    $('[data-submit]').click(e => {
      e.preventDefault();
      document.querySelector(e.target.dataset.submit).submit();
    });

    // Set padding bottom on footer when the nav is fixed to the bottom
    footerPadding();
    $(window).on('resize', footerPadding);
});

/**
 * Set footer padding bottom to the nav's height when the window width is less than 992px (bootstrap large breakpoint)
 */
function footerPadding() {
    if($(window).width() < 992) {
        const navHeight = $('.navigation').height();
        $('footer').css('padding-bottom', `${navHeight}px`);
    } else {
        $('footer').css('padding-bottom', '0px');
    }
  }

  /**
   * Puts all modals on the page into the footer, so we can initialize them everywhere and the z-index will works
   */
  function copyModalsToFooter() {
    const modals = $('.modal');
    modals.each((_, modal) => {
      const content = modal.cloneNode(true);
      modal.remove();
      $(content).appendTo('footer');
    });
  }

  /**
   * On slide it will load in the next carousel item's image
   */
  function setupLazyCarousels() {
    $('.carousel.lazy').on('slide.bs.carousel', function(ev) {
      const curr = ev.relatedTarget.id;
      currParts = curr.split('-');
      const next = $(`#${currParts[0]}-${currParts[1]}-${currParts[2]}-${Number(currParts[3]) + 1}`).find('[data-src]');
      if(next) {
      next.attr('src', next.data('src'));
      next.removeAttr('data-src');
      }
    });
  }

  /**
   * Match the height of data-match elements to the accumalated height of the children of the element to match
   */
  function matchHeights() {
    document.querySelectorAll('[data-match]').forEach(el => {
      const toMatch = document.querySelector(el.dataset.match);
      const height = Array.from(toMatch.children).reduce((aggr, el) => aggr + el.scrollHeight, 0);
      el.style.height = height + 'px';
    });
  }

  function pulsateLogo() {
    const audio = document.querySelector('.js-audio-theme');
    const logo = document.querySelector('.js-logo');
    if(audio && logo) {
      const pulse = (60 / Number(audio.dataset.bpm)) * 1000;

      // audio.play();
      // audio.classList.add('playing');

      pulsing(logo, pulse);
      setInterval(function() { pulsing(logo, pulse) }, pulse);
    }
  }

  function pulsing(logo, pulse) {
    logo.classList.add('pulse');

    setTimeout(() => {
      logo.classList.remove('pulse');
    }, pulse - 100);
  }
})();
