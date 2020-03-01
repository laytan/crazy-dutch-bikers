enum Status {
  Muted = 'MUTED',
  Paused = 'PAUSED',
  Playing = 'PLAYING',
  Ended = 'ENDED'
}

interface PartialState {
  status?: Status,
  currentTime?: number,
  shouldHint?: boolean,
}

interface State {
  status: Status,
  currentTime: number,
  shouldHint: boolean,
}

export default class AudioTheme {
  private audioElement: HTMLAudioElement;

  private state: State;

  private duration: number;

  private dismissedHint: boolean;

  constructor(private wrapper: Element, private songName: string) {
    [this.audioElement] = Array.from(wrapper.getElementsByTagName('audio'));

    // Get localstorage item or false and turn into boolean
    this.dismissedHint = ((localStorage.getItem('audioDismissedHint') || 'false') === 'true');

    this.state = {
      status: Status.Muted,
      currentTime: 0,
      shouldHint: false,
    };

    this.duration = this.audioElement.duration;

    this.start();
  }

  static stringToStatus(status: string) : Status {
    switch (status) {
      case 'MUTED':
        return Status.Muted;
      case 'PAUSED':
        return Status.Paused;
      case 'PLAYING':
        return Status.Playing;
      case 'ENDED':
        return Status.Ended;
      default:
        return Status.Muted;
    }
  }

  /**
   * Turns 80 into 01:20 etc.
   * @param val number of seconds
   */
  static parseTime(val: number): string {
    const string = val.toString();
    const numberOfSeconds = parseInt(string, 10);
    const hours = Math.floor(numberOfSeconds / 3600);
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
    audioPlayers.forEach((player) => {
      if (!(player instanceof HTMLDivElement)) {
        console.error('Audio player should be a div element');
        return;
      }
      const { songName } = player.dataset;
      if (!songName) {
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
    const sessionCurrentTime = parseInt(localStorage.getItem('audioCurrentTime') || '0', 10);

    this.audioElement.play()
      .then(() => {
        const sessionStatus = localStorage.getItem('audioStatus') || 'PLAYING';
        this.setState({ status: AudioTheme.stringToStatus(sessionStatus) });
      })
      .catch(() => {
        // Autoplay did not work, mute audio and play again
        this.setState({ status: Status.Muted, shouldHint: true });
      }).finally(() => {
        this.setState({ currentTime: sessionCurrentTime });
        setInterval(this.updateTime.bind(this), 1000);
      });
  }

  /**
   * Update time when we have the audioelement actually playing
   */
  private updateTime() {
    if (this.state.status === Status.Playing || this.state.status === Status.Muted) {
      this.setState({});
    }
  }

  /**
   * Change the state and render with that state
   * @param state - The state you wish to change
   */
  private setState(state: PartialState) {
    // Make a new object with all the values of state, const prevState = state would only point
    const prevState = { ...this.state };
    if (state.currentTime) {
      this.audioElement.currentTime = state.currentTime;
      this.state.currentTime = state.currentTime;
    } else {
      this.state.currentTime = this.audioElement.currentTime;
    }
    this.state.status = state.status || this.state.status;
    this.state.shouldHint = state.shouldHint || this.state.shouldHint;

    // Update localstorage to have it resume where it left of on another page
    localStorage.setItem('audioCurrentTime', this.state.currentTime.toString());
    localStorage.setItem('audioStatus', this.state.status);
    localStorage.setItem('audioDismissedHint', this.dismissedHint.toString());

    this.syncAudioElement(prevState);
    this.render();
  }

  private syncAudioElement(prevState: State) {
    switch (this.state.status) {
      case Status.Muted:
        this.audioElement.muted = true;
        this.audioElement.play().catch(() => {
          console.warn('Autoplay on mute blocked');
          this.setState({ status: Status.Paused, shouldHint: true });
        });
        break;
      case Status.Paused:
        this.audioElement.pause();
        break;
      case Status.Playing:
        if (prevState.status === Status.Ended) {
          this.audioElement.currentTime = 0;
        } else if (prevState.status === Status.Muted) {
          this.audioElement.muted = false;
        }
        this.audioElement.play();
        break;
      default:
    }
  }

  /**
   * Handle click on the current icon
   */
  private onClickIcon() {
    if ([Status.Ended, Status.Muted, Status.Paused].includes(this.state.status)) {
      this.setState({ status: Status.Playing });
    } else if (this.state.status === Status.Playing) {
      this.setState({ status: Status.Paused });
    } else {
      this.start();
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
    this.setState({ currentTime: percent * this.duration });
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
    switch (this.state.status) {
      case Status.Muted:
        return '<i class="fas fa-volume-up"></i>';
      case Status.Paused:
        return '<i class="fas fa-play"></i>';
      case Status.Playing:
        return '<i class="fas fa-pause"></i>';
      case Status.Ended:
        return '<i class="fas fa-redo"></i>';
      default:
        return '<i class="fas fa-play"></i>';
    }
  }

  /**
   * Let the user know that the audio is muted because autoplay is blocked
   */
  private getMutedNotice(): string {
    if (this.dismissedHint || !this.state.shouldHint) {
      return '';
    }

    return `
    <div class="alert alert-warning alert-dismissible fade show position-lg-absolute m-3 right-0" role="alert">
        <strong>Let op!</strong> De achtergrondmuziek is op mute gezet omdat je browser het blokkeert, zet hem hierboven aan!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    `;
  }

  /**
   * Render the element with the current state
   */
  private render() {
    const renderIn = this.wrapper.querySelector('.js-render');
    if (!renderIn) return;
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
    ${this.getMutedNotice()}
    `;

    // Set up event listeners
    const icon = renderIn.querySelector('.audio-player__play i');
    icon?.addEventListener('click', this.onClickIcon.bind(this));

    const progress = renderIn.querySelector('progress');
    progress?.addEventListener('click', this.seek.bind(this));

    const close = renderIn.querySelector('.close');
    close?.addEventListener('click', () => { this.dismissedHint = true; });
  }
}
