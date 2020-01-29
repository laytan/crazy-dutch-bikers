require('./bootstrap');

(() => {
  $(window).on('load', () => {
    copyModalsToFooter();
  });

  function copyModalsToFooter() {
    const modals = $('.modal');
    modals.each((_, modal) => {
      const content = modal.cloneNode(true);
      modal.remove();
      $(content).appendTo('footer');
    });
  }
})();
