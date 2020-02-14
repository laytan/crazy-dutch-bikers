require('./bootstrap');
import LazyLoad from "vanilla-lazyload";

(() => {
  $(window).on('load', () => {
    copyModalsToFooter();
    setupLazyCarousels();

    new LazyLoad({
      elements_selector: "img.lazy"
    });

    // Handle fullscreening gallery images
    $('.gallery-grid__image-wrap').on('click', (e) => {
      const wrap =  $(e.target).parents('.gallery-grid__image-wrap');
      wrap.toggleClass('gallery-grid__image-wrap--full');
    });
  });

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
})();
