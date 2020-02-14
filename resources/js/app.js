require('./bootstrap');

(() => {
  $(window).on('load', () => {
    copyModalsToFooter();
    matchHeights();
  });

  function copyModalsToFooter() {
    const modals = $('.modal');
    modals.each((_, modal) => {
      const content = modal.cloneNode(true);
      modal.remove();
      $(content).appendTo('footer');
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
})();
