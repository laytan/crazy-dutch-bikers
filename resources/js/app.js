require('./bootstrap');

(() => {
  $(window).on('load', () => {
    copyModalsToFooter();
    matchHeights();
    pulsateLogo();
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

  function pulsateLogo() {
    const audio = document.querySelector('.js-audio-theme');
    const logo = document.querySelector('.js-logo');
    if(audio && logo) {
      const pulse = (60 / Number(audio.dataset.bpm)) * 1000;

      audio.play();
      audio.classList.add('playing');

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
