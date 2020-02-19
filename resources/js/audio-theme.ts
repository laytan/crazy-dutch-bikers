enum Status {
  Muted = "MUTED",
  Paused = "PAUSED",
  Playing = "PLAYING",
  Ended = "ENDED",
  Loading = "LOADING",
}

interface PartialState {
  status?: Status,
  currentTime?: number,
}

interface State {
  status: Status,
  currentTime: number,
}

export default class AudioTheme {

  private audioElement: HTMLAudioElement;
  private state: State;
  private duration: number;
  private dismissedHint = false;

  constructor (private wrapper: Element, private songName: string) {
    this.audioElement = wrapper.getElementsByTagName('audio')[0];

    this.state = {
      status: Status.Loading,
      currentTime: 0,
    };

    this.duration = this.audioElement.duration;

    this.start();
  }

  /**
   * Turns 80 into 01:20 etc.
   * @param val number of seconds
   */
  static parseTime(val: number): string {
    const string = val.toString();
    const numberOfSeconds = parseInt(string, 10);
    const hours   = Math.floor(numberOfSeconds / 3600);
    const minutes = Math.floor((numberOfSeconds - (hours * 3600)) / 60);
    const seconds = numberOfSeconds - (hours * 3600) - (minutes * 60);

    let stringMinutes = minutes.toString();
    let stringSeconds = seconds.toString();
    if (minutes < 10) {
      stringMinutes = `0${minutes}`;
    }
    if (seconds < 10) {
      stringSeconds = `0${seconds}`;
    }
    return `${stringMinutes}:${stringSeconds}`;
  }

  /**
   * Create objects for all data-audio-player=""
   */
  static initialize() {
    const audioPlayers = document.querySelectorAll('[data-audio-player=""');
    audioPlayers.forEach(player => {
      if(!(player instanceof HTMLDivElement)) {
        console.error('Audio player should be a div element');
        return;
      }
      const songName = player.dataset.songName;
      if(!songName) {
        console.error('Audio element needs a data-song-name attribute');
        return;
      }
      new AudioTheme(player, songName);
    });
  }

  /**
   * Try to autoplay the audio, if it didn't work mute and play it that way
   */
  private start() {
    this.audioElement.addEventListener('ended', () => this.setState({ status: Status.Ended }));

    this.audioElement.play()
      .then(() => {
        // Autoplay worked
        this.setState({
          status: Status.Playing,
        });
      })
      .catch(() => {
        // Autoplay did not work, mute audio and play again
        this.audioElement.muted = true;
        this.audioElement.play();
        this.setState({
          status: Status.Muted,
        });
      }).finally(() => {
        setInterval(this.updateTime.bind(this), 1000);
      });
  }

  /**
   * Update time when we have the audioelement actually playing
   */
  private updateTime() {
    if(this.state.status === Status.Playing || this.state.status === Status.Muted) {
      this.setState({ currentTime: this.audioElement.currentTime });
    }
  }

  /**
   * Change the state and render with that state
   * @param state - The state you wish to change
   */
  private setState(state: PartialState) {
    this.state = {
      status: state.status || this.state.status,
      currentTime: state.currentTime || this.state.currentTime,
    };
    this.render();
  }

  /**
   * Handle click on the current icon
   */
  private onClickIcon() {
    switch(this.state.status) {
      case Status.Muted:
        this.audioElement.muted = false;
        this.setState({ status: Status.Playing });
        break;
      case Status.Ended:
        this.audioElement.currentTime = 0;
        this.audioElement.play();
        this.setState({ status: Status.Playing });
        break;
      case Status.Loading:
        // Try starting again
        this.start();
        break;
      case Status.Paused:
        this.audioElement.play();
        this.setState({ status: Status.Playing });
        break;
      case Status.Playing:
        this.audioElement.pause();
        this.setState({ status: Status.Paused });
        break;
    }
  }

  /**
   * On click progress bar check the click percent and adjust current time
   * @param e progress bar click event
   */
  // TODO: Does not work in chrome
  private seek(e: MouseEvent) {
    const target = e.target as HTMLProgressElement;
    const percent = e.offsetX / target.offsetWidth;
    this.audioElement.currentTime = percent * this.duration;
    this.setState({ currentTime: this.audioElement.currentTime });
  }

  /**
   * Return the progress percentage that the progress element takes
   */
  private getProgress(): string {
    return (this.state.currentTime / this.duration).toString();
  }

  /**
   * Return an icon based on the status
   */
  private getIcon(): string {
    switch(this.state.status) {
      case Status.Muted:
        return '<i class="fas fa-volume-up"></i>';
      case Status.Paused:
        return '<i class="fas fa-play"></i>';
      case Status.Playing:
        return '<i class="fas fa-pause"></i>';
      case Status.Ended:
        return '<i class="fas fa-redo"></i>';
      case Status.Loading:
        return '<i class="fas fa-spinner fa-spin"></i>'
    }
  }

  /**
   * Let the user know that the audio is muted because autoplay is blocked
   */
  private getMutedNotice() {
    if(this.dismissedHint) {
        return '';
    } else {
        return `
        <div class="alert alert-warning alert-dismissible fade show position-absolute mr-3 mt-3 right-0 d-none d-lg-block" role="alert">
            <strong>Let op!</strong> De achtergrondmuziek is op mute gezet omdat je browser het blokkeert, zet hem hierboven aan!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        `;
    }
  }

  /**
   * Render the element with the current state
   */
  private render() {
    const renderIn = this.wrapper.querySelector('.js-render');
    if(!renderIn) return;
    renderIn.innerHTML = `
    <div class="js-audio-player border-cdbb py-1" data-bpm="72" data-state="${this.state.status}">
      <div class="d-flex flex-column flex-lg-row align-items-center">
        <div class="audio-player__play pl-3 pr-2 pt-2 pt-lg-0">
          ${this.getIcon()}
        </div>
        <div class="d-flex align-items-center flex-column pr-3 pl-2">
          <p class="mb-0 lead">
            ${this.songName}
          </p>
          <progress value="${this.getProgress()}" max="1" class="mw-100"></progress>
          <div class="d-flex justify-content-between w-100">
            <small class="js-audio-player__current">
              ${AudioTheme.parseTime(this.state.currentTime)}
            </small>
            <small class="js-audio-player__duration">
              ${AudioTheme.parseTime(this.duration)}
            </small>
          </div>
        </div>
      </div>
    </div>
    ${ this.state.status === Status.Muted ? this.getMutedNotice() : '' }
    `;

    // Set up event listeners
    const icon = renderIn.querySelector('.audio-player__play i');
    icon?.addEventListener('click', this.onClickIcon.bind(this));

    const progress = renderIn.querySelector('progress');
    progress?.addEventListener('click', this.seek.bind(this));

    const close = renderIn.querySelector('.close');
    close?.addEventListener('click', () => this.dismissedHint = true);
  }
}
