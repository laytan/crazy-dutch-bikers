class ImageUpload {

    private input: HTMLInputElement;

    constructor(private wrapper: Element, private image: string, private name: string, private id: string, private invalid: boolean, private label: string) {
        const input = this.wrapper.querySelector('input.js-image-upload__input') as HTMLInputElement;
        this.input = input;

        this.initInput();
        this.render();
    }

    static Initialize() {
        const wrappers = document.querySelectorAll('[data-image-upload=""]') as NodeListOf<HTMLDivElement>;
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

            new ImageUpload(wrapper, image, name, id, invalid, label);
        });
    }

    private initInput() {
        this.input.name = this.name;
        this.input.id = `${this.id}-input`;

        this.input.addEventListener('change', this.onImage.bind(this));
    }

    private onImage(e: Event) {
        if(!e.target.files || !e.target.files[0]) {
            return;
        }

        const reader = new FileReader();
        reader.onload = e => {
            const src = e.target?.result;
            if(typeof src === 'string') {
                this.setImage(src);
            }
        };
        const file = e.target?.files[0];
        if(file) {
            reader.readAsDataURL(file);
        }
    }

    private setImage(src: string) {
        this.image = src;
        this.render();
    }

    private render() {
        const render = this.wrapper.querySelector('.js-render');
        if(!render) return;

        render.innerHTML = `
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
        `;
    }
}
