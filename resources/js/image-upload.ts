/**
 * An image upload box with preview
 */
export default class ImageUpload {
    // Element to render the dynamic parts of the ImageUpload in
    private renderEl: HTMLDivElement|undefined;

    /**
     * Initialize the ImageUpload
     * @param wrapper - The element to render this object in
     * @param image - Image currently uploaded, can be empty
     * @param name - Name to put on the input element
     * @param id - Id to put on the wrapper element
     * @param invalid - Render the element with an invalid class?
     * @param label - The text to add to our button
     * @param canBeRemoved - Can the element be completely removed by the user?
     */
    constructor(private wrapper: Element, private image: string, private name: string, private id: string, private invalid: boolean, private label: string, private canBeRemoved: boolean) {
        this.initInput();
        this.render();
    }

    /**
     * Get all the data-image-upload elements and initialize as ImageUpload objects
     */
    static initialize() {
        const wrappers = document.querySelectorAll('[data-image-upload]') as NodeListOf<HTMLDivElement>;
        if(!wrappers) return;

        wrappers.forEach(wrapper => {
            const image = wrapper.dataset.startImage || '';

            let invalid = Boolean(wrapper.dataset.invalid);

            const name = wrapper.dataset.name;
            if(!name) {
                console.error('Image upload needs a data-name property');
                return;
            }

            const id = wrapper.dataset.id;
            if(!id) {
                console.error('Image upload needs a data-id property');
                return;
            }

            const label = wrapper.dataset.label;
            if(!label) {
                console.error('Image upload needs a data-label property');
                return;
            }

            new ImageUpload(wrapper, image, name, id, invalid, label, false);
        });
    }

    /**
     * Fill the wrapper element with our static elements and add a listener for when a user selects an image
     */
    private initInput() {
    const renderDiv = document.createElement('div');
    renderDiv.classList.add('js-render');
    const input = document.createElement('input');
    input.classList.add('js-image-upload__input');
    input.classList.add('d-none');
    input.setAttribute('type', 'file');
    input.accept = 'image/*';
    input.id = `${this.id}-input`;
    input.name = this.name;
    this.wrapper.append(renderDiv, input);
    this.renderEl = renderDiv;
    input.addEventListener('change', this.onImage.bind(this));
    }

    /**
     * Get the file that was uploaded as a dataURL image and call setImage with it
     * @param e Event of input element upload
     */
    private onImage(e: any) {
        const file = e.target?.files[0];
        if(!file) return;

        const reader = new FileReader();
        reader.onload = e => {
            const src = e.target?.result;
            if(typeof src === 'string') {
                this.setImage(src);
            }
        };

        reader.readAsDataURL(file);
    }

    /**
     * Clears the image or removes it
     */
    private removeImage() {
        if(this.image.length > 0) {
            this.setImage('');
        } else if(this.canBeRemoved) {
            this.wrapper.remove();
        }
    }

    /**
     * Set new image source and call render to re-render
     * @param src Image source
     */
    private setImage(src: string) {
        this.image = src;
        this.render();
    }

    /**
     * Render our image upload with the current state and bind a listener to the trash icon to remove the image
     */
    private render() {
        if(!this.renderEl) {
            return;
        }
        this.renderEl.innerHTML = `
            <div id="${this.id}" class="${this.invalid ? 'is-invalid' : ''} w-100 h-100 image-upload position-relative bg-cdbb d-flex justify-content-center align-items-center">
                <i class="image-upload__remove-icon h-100 text-danger position-absolute top-0 right-0 mt-2 mr-2 fas fa-trash"></i>
                <img alt="" class="${this.image ? '' : 'd-none'} w-100 h-100 object-fit-cover position-absolute" src="${this.image}">
                <div class="js-upload-button">
                    <label for="${this.id}-input" class="${this.image ? 'd-none' : ''} js-label btn btn-primary"><i class="fas fa-upload mr-2"></i>
                    <span class="v-align-middle">
                        ${this.label}
                    </span>
                    </label>
                </div>
            </div>
            ${this.invalid ? '<div class="text-danger text-sm mb-2">Dit is geen geldige foto</div>' : '<div class="mb-2"></div>'}
        `;

        const trashIcon = this.wrapper.querySelector('.image-upload__remove-icon');
        trashIcon?.addEventListener('click', this.removeImage.bind(this));
    }
}
