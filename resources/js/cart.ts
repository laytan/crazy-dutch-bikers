interface Product {
  id: number,
  title: string,
  description: string|null,
  price: number, // In cents
  product_picture: string, // Storage path to the product picture prepend /storage for relative url
  created_at: string,
  updated_at: string,
  updated_by: number, // User id that did the last update
}

interface CartOptions {
  productsSelector?: string,
  totalReceiverSelector?: string,
  initialProducts?: Product[],
  addToCartSelector?: string,
  cartItemsContainerSelector?: string,
  orderBtn?: string,
  clearCartBtn?: string,
  confirmOrder?: boolean,
}

interface ProductDataset {
  product: string,
}

interface ProductElement extends Element {
  dataset: ProductDataset,
}

interface Modal extends JQuery<Element> {
  modal(opts:string): Function;
}

/**
 * Simple Cart implementation
 */
export default class Cart {
  // The products
  private productElements: NodeListOf<ProductElement>;

  // Elements that take the total price
  private totalReceiver: Element|null;

  // Where to render our cart
  private itemsContainer: Element|null;

  // The products currently in the cart
  private cart: Product[];

  // Add to cart button selector
  private addToCartSelector: string;

  private shouldConfirmOrder: boolean;

  /**
   * Set initial cart state and get needed elements
   */
  constructor(wrapper: Element, private productIdsReceiver: HTMLInputElement, {
    productsSelector = '.js-product',
    totalReceiverSelector = '.js-cart-total',
    initialProducts = [],
    addToCartSelector = '.js-product__add-to-cart',
    cartItemsContainerSelector = '.js-cart-items',
    orderBtn = '.js-order-btn',
    clearCartBtn = '.js-clear-cart-btn',
    confirmOrder = true,
  }: CartOptions) {
    this.productElements = wrapper.querySelectorAll(productsSelector);
    this.totalReceiver = wrapper.querySelector(totalReceiverSelector);
    this.itemsContainer = wrapper.querySelector(cartItemsContainerSelector);
    this.cart = initialProducts;
    this.addToCartSelector = addToCartSelector;
    this.shouldConfirmOrder = confirmOrder;

    wrapper.querySelector(orderBtn)?.addEventListener('click', this.order.bind(this));
    wrapper.querySelector(clearCartBtn)?.addEventListener('click', this.clearCart.bind(this));

    // Bind events to the product elements
    this.productElements.forEach(this.bindProductEvents.bind(this));

    // Call onchange when we have initial products
    if (this.cart.length > 0) {
      this.onCartChange();
    }
  }

  /**
   * Converts cents to display friendly euros
   * @param cents Cents to convert
   */
  static centsToEuro(cents: number) {
    const euro = cents / 100;
    return euro.toLocaleString('nl-NL', { style: 'currency', currency: 'EUR' });
  }

  /**
   * Returns the given string with a maximum of 25 chars + ...
   * @param description description string
   */
  static shortenDescription(description: string|null): string {
    if (!description) {
      return '';
    }

    return description.length > 25 ? `${description.substring(0, 25)}...` : description;
  }

  /**
   * Show confirm modal and wait for a decision
   */
  static confirm(): Promise<Boolean> {
    return new Promise((resolve) => {
      const modal = document.querySelector('.modal#confirm-order-modal');
      // If there is no modal just return true
      if (!modal) {
        resolve(true);
        return;
      }

      // Turn into jquery modal
      const jModal = $(modal) as Modal;

      // Return false when the modal is hidden
      jModal.on('hidden.bs.modal', () => {
        resolve(false);
      });

      // Return true when the .order-btn is clicked
      const btn = modal.querySelector('.order-btn');
      btn?.addEventListener('click', () => {
        jModal.modal('hide');
        resolve(true);
      });

      jModal.modal('show');
    });
  }

  /**
   * Binds the events(add to cart click) to the element
   * @param productElement Element to initialize
   */
  bindProductEvents(productElement: ProductElement) {
    const addToCartButton = productElement.querySelector(this.addToCartSelector);
    if (!addToCartButton) {
      return;
    }

    addToCartButton.addEventListener('click', () => {
      const product: Product = JSON.parse(productElement.dataset.product);
      this.addToCart(product);
    });
  }

  /**
   * Add a product to the cart
   * @param {Product} product - The product to add.
   */
  addToCart(product: Product) {
    this.cart.push(product);
    this.onCartChange();

    if (window.innerWidth < 1164) {
      this.itemsContainer?.scrollIntoView({ behavior: 'smooth' });
    }
  }

  /**
   * Removes all items from the cart
   */
  clearCart() {
    this.cart.length = 0;
    this.onCartChange();
  }

  /**
   * Removes a product from the cart
   * @param product Product to remove
   */
  removeProduct(product: Product) {
    // Loop untill we find the product with this id, remove it and break so we only remove it once
    for (let i = 0; i < this.cart.length; i += 1) {
      if (this.cart[i].id === product.id) {
        this.cart.splice(i, 1);
        break;
      }
    }
    this.onCartChange();
  }

  /**
   * Confirm order if we should and then submit the form
   */
  async order() {
    if (this.shouldConfirmOrder) {
      const shouldOrder = await Cart.confirm();
      if (shouldOrder) {
        const form = $(this.productIdsReceiver).parents('form');
        form.submit();
      }
    } else {
      const form = $(this.productIdsReceiver).parents('form');
      form.submit();
    }
  }

  /**
   * Syncs the html with this.cart
   */
  onCartChange() {
    this.updateProductIds();
    this.renderItems();
    this.renderTotal();
  }

  /**
   * Clears the cartItemsContainer and adds all products in the cart to it
   */
  renderItems() {
    if (!this.itemsContainer) {
      console.error('No cart items container found');
      return;
    }

    this.itemsContainer.innerHTML = '';
    this.cart.forEach((product) => {
      const el = this.getElement(product);
      if (el) {
        this.itemsContainer?.appendChild(el);
      }
    });
  }

  /**
   * Calculates the total price and sets it on the element
   */
  renderTotal() {
    if (!this.totalReceiver) {
      return;
    }

    const total = Cart.centsToEuro(this.cart.reduce((prev, curr) => prev + curr.price, 0));
    this.totalReceiver.textContent = total;
  }

  /**
   * Puts a comma seperated list of all product ids into the ids element
   */
  updateProductIds() {
    this.productIdsReceiver.value = this.cart.reduce((prev, curr) => (prev.length > 0 ? `${prev},${curr.id}` : prev + curr.id), '');
  }

  /**
   * Return product markup
   * @param product - The product's information to use.
   */
  getElement(product: Product): Element {
    const template = document.createElement('template');
    const html = `
    <div class="cart-item d-flex align-items-center justify-content-between mt-2">
      <div class="d-flex flex-column">
        <span class="cart-item__title">${product.title}</span>
        <small class="cart-item__description">${Cart.shortenDescription(product.description)}</small>
      </div>
      <span class="cart-item__price">${Cart.centsToEuro(product.price)}</span>
      <i class="fas fa-trash hover-primary"></i>
    </div>
    `;
    template.innerHTML = html.trim();
    const element = <Element> template.content.firstChild;

    // Bind trash icon to removing this product from the cart
    const trashIcon = element.querySelector('.fa-trash');
    trashIcon?.addEventListener('click', () => this.removeProduct(product));

    return element;
  }
}
