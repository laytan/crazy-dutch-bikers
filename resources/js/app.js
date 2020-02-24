/* global $ */

import 'bootstrap';
import LazyLoad from 'vanilla-lazyload';
import Cart from './cart.ts';
import AudioTheme from './audio-theme.ts';
import ImageUpload from './image-upload.ts';
import ImagesUpload from './images-upload.ts';

require('./bootstrap');

window.Cart = Cart;

(() => {
  /**
  * Set footer padding bottom to the nav's height
  * when the window width is less than 992px (bootstrap large breakpoint)
  */
  function footerPadding() {
    if ($(window).width() < 992) {
      const navHeight = $('.navigation').height();
      $('footer').css('padding-bottom', `${navHeight}px`);
    } else {
      $('footer').css('padding-bottom', '0px');
    }
  }

  /**
   * Puts all modals on the page into the footer,
   * so we can initialize them everywhere and the z-index will works
   */
  function copyModalsToFooter() {
    const modals = document.querySelectorAll('.modal');
    const footer = document.querySelector('.footer');
    modals.forEach((modal) => {
      const modalContent = modal.cloneNode(true);
      modal.parentNode.removeChild(modal);
      footer.appendChild(modalContent);
    });
  }

  /**
   * On slide it will load in the next carousel item's image
   */
  function setupLazyCarousels() {
    $('.carousel.lazy').on('slide.bs.carousel', (ev) => {
      const curr = ev.relatedTarget.id;
      const currParts = curr.split('-');
      const next = $(`#${currParts[0]}-${currParts[1]}-${currParts[2]}-${Number(currParts[3]) + 1}`).find('[data-src]');
      if (next) {
        next.attr('src', next.data('src'));
        next.removeAttr('data-src');
      }
    });
  }

  /**
   * Match the height of data-match elements to the
   * accumalated height of the children of the element to match
   */
  function matchHeights() {
    document.querySelectorAll('[data-match]').forEach((el) => {
      const toMatch = document.querySelector(el.dataset.match);
      const height = Array.from(toMatch.children).reduce(
        (aggr, child) => aggr + child.scrollHeight, 0,
      );
      el.style.height = `${height}px`;
    });
  }

  function pulsing(logo, pulse) {
    logo.classList.add('pulse');

    setTimeout(() => {
      logo.classList.remove('pulse');
    }, pulse - 100);
  }

  function pulsateLogo() {
    const audio = document.querySelector('.js-audio-theme');
    const logo = document.querySelector('.js-logo');
    if (audio && logo) {
      const pulse = (60 / Number(audio.dataset.bpm)) * 1000;

      // audio.play();
      // audio.classList.add('playing');

      pulsing(logo, pulse);
      setInterval(() => { pulsing(logo, pulse); }, pulse);
    }
  }

  $(window).on('load', () => {
    copyModalsToFooter();
    setupLazyCarousels();

    AudioTheme.initialize();
    ImageUpload.initialize();
    ImagesUpload.initialize();

    new LazyLoad({
      elements_selector: 'img.lazy',
    });

    // Handle fullscreening gallery images
    $('.gallery-grid__image-wrap').on('click', (e) => {
      const wrap = $(e.target).parents('.gallery-grid__image-wrap');
      wrap.toggleClass('gallery-grid__image-wrap--full');
    });
    matchHeights();
    pulsateLogo();

    // data-submit submits the form with that selector on click
    $('[data-submit]').click((e) => {
      e.preventDefault();
      document.querySelector(e.target.dataset.submit).submit();
    });

    // Set padding bottom on footer when the nav is fixed to the bottom
    footerPadding();
    $(window).on('resize', footerPadding);
  });
})();
