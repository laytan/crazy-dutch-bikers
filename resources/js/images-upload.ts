import ImageUpload from './image-upload';

/**
 * Mounts on an element and adds an image upload box, with the ability to add more
 */
export default class ImagesUpload {
  // A reference to all our imageupload objects
  private imageUploads: ImageUpload[];

  // Element to render new image uploads in
  private boxWrapper: HTMLDivElement;

  // Reference to the load more button
  private loadMoreBtn: HTMLAnchorElement;

  /**
   * Initialize the images upload element
   * @param wrapper - The element we will render our imagesUpload in
   * @param initialImageUploads - Amount of image uploads to start with
   * @param name - Name of the file input element
   * @param label - Label for the upload image button
   * @param rowSize - How many image uploads to add on load more button click
   */
  constructor(
    private wrapper: Element,
    private initialImageUploads: number,
    private name: string,
    private label: string,
    private rowSize: number,
  ) {
    const boxWrapper = document.createElement('div');
    this.wrapper.append(boxWrapper);
    this.boxWrapper = boxWrapper;
    this.loadMoreBtn = this.initLoadMoreBtn();
    this.loadMoreBtn.addEventListener('click', () => this.imageUploads.push(...this.getImageUploads(this.rowSize)));

    this.imageUploads = this.getImageUploads(this.initialImageUploads);
  }

  /**
   * Finds all elements with data-images-upload and initializes them
   */
  static initialize(): void {
    const wrappers = document.querySelectorAll('[data-images-upload]') as NodeListOf<HTMLDivElement>;
    wrappers.forEach((wrapper) => {
      const initialImageUploads = parseInt(wrapper.dataset.initialBoxes || '1', 10);
      const { name } = wrapper.dataset;
      const { label } = wrapper.dataset;
      const rowSize = parseInt(wrapper.dataset.rowSize || '1', 10);

      if (!label) {
        console.error('Images Upload needs the property data-label');
        return;
      }

      if (!name) {
        console.error('Images Upload needs the property data-name');
        return;
      }

      new ImagesUpload(wrapper, initialImageUploads, name, label, rowSize);
    });
  }

  /**
   * Adds the specified amount of image upload elements and returns them
   * @param amount - How many to add
   */
  private getImageUploads(amount: number): ImageUpload[] {
    const toReturn: ImageUpload[] = [];
    for (let i = 0; i < amount; i += 1) {
      toReturn.push(
        new ImageUpload(
          this.addWrapper(),
          '',
          this.name,
          // Count imagesUpload and add our current index
          `${this.name}-upload-${(this.imageUploads?.length || 0) + i}`,
          false,
          this.label,
          // Don't allow destroy itself when index is 0, otherwise allow it
          !(((this.imageUploads?.length || 0) + i) === 0),
        ),
      );
    }
    return toReturn;
  }

  /**
   * Create a load more button markup and add it to the wrapper
   * @returns {HTMLAnchorElement} - The button element
   */
  private initLoadMoreBtn(): HTMLAnchorElement {
    const loadMore = document.createElement('a');
    loadMore.classList.add('text-center', 'w-100', 'text-primary', 'd-block');
    loadMore.innerHTML = 'Laad meer foto\'s <i class="fas fa-caret-down"></i>';
    loadMore.href = '#';
    this.wrapper.append(loadMore);
    return loadMore;
  }

  /**
   * Returns a wrapper for a new image upload
   * @returns {Element} - The new wrapper where a imageupload element can be initialized
   */
  private addWrapper(): Element {
    const wrapper = document.createElement('div');

    // Append wrapper to parent wrapper
    this.boxWrapper.append(wrapper);

    return wrapper;
  }
}
