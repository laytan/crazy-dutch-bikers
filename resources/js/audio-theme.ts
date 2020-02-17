export default class AudioTheme {
  
  private audioElement: HTMLAudioElement;
  private playButton: Element|null;
  private progress: HTMLProgressElement;
  private currentTime: Element|null;
  private state = 'start'; // start, pause, playing, ended
  
  constructor (private wrapper: Element, private hint: Element) {
    this.audioElement = wrapper.getElementsByTagName('audio')[0];
    this.playButton = wrapper.querySelector('.js-audio-player__play');
    this.progress = wrapper.getElementsByTagName('progress')[0];
    this.currentTime = wrapper.querySelector('.js-audio-player__current');
    
    const duration = wrapper.querySelector('.js-audio-player__duration');
    if (duration) {
      duration.textContent = AudioTheme.parseTime(this.audioElement.duration);
    }

    this.playButton?.addEventListener('click', this.play.bind(this));
    this.audioElement.addEventListener('ended', this.ended.bind(this));

    this.tryAutoplay();

    setInterval(this.updateProgress.bind(this), 1000);
  }

  // TODO: Clean up
  static parseTime(val: number): string {
    const string = val.toString();
    const numberOfSeconds = parseInt(string, 10); // don't forget the second param
    const hours   = Math.floor(numberOfSeconds / 3600);
    const minutes = Math.floor((numberOfSeconds - (hours * 3600)) / 60);
    const seconds = numberOfSeconds - (hours * 3600) - (minutes * 60);

    let stringMinutes = minutes.toString();
    let stringSeconds = seconds.toString();
    if (minutes < 10) {stringMinutes = "0"+minutes;}
    if (seconds < 10) {stringSeconds = "0"+seconds;}
    return stringMinutes+':'+stringSeconds;
  }

  private tryAutoplay() {
    this.audioElement.play()
      .then(() => {
        this.play();
      })
      .catch(() => {
        this.hintPlay();
      });
  }

  private hintPlay() {
    this.hint.classList.add('d-block');
  }

  // TODO: setState function so state is in one place
  private play() {
    switch(this.state) {
      case 'playing':
        this.audioElement.pause();
        this.state = 'pause';
        break;
      case 'ended':
        this.audioElement.currentTime = 0;
        this.audioElement.play();
        this.state = 'playing';
        break;
      default:
        this.audioElement.play();
        this.state = 'playing';
        break;
    }
  }

  private ended() {
    this.state = 'ended';
  }

  // TODO: rename
  private updateProgress() {
    this.wrapper.setAttribute('data-state', this.state);
    this.progress.value = (this.audioElement.currentTime / this.audioElement.duration);
    if(this.currentTime) {
      this.currentTime.textContent = AudioTheme.parseTime(this.audioElement.currentTime);
    }
  }
}
