// @ts-check
/**
 * @typedef {Object} Product
 * @property {number} id - Product ID.
 * @property {number} updated_by - User ID of last updater.
 * @property {string} title - Product title.
 * @property {(string|null)} description - Product description. 
 * @property {number} price - Product price in cents.
 * @property {string} product_picture - Storage path of picture (prepend /storage for relative path).
 * @property {string} created_at - When the product was created yyyy-mm-dd hh:mm:ss
 * @property {string} updated_at - When the product was last updated yyyy-mm-dd hh:mm:ss
 */

/**
 * @typedef {Object} CartOptions
 * @property {string} [productsSelector] - The selector to query for product elements.
 * @property {string} [totalReceivers] - The selector to query for all elements that need the total.
 * @property {Product} [initialProducts] - Products to begin with
 * @property {string} [addToCartSelector] - Selector within product which will add product to cart onclick.
 */

/**
 * @typedef {Element} ProductElement
 * @property {Object} dataset
 * @property {string} dataset.product
 */

/**
 * Simple Cart implementation
 */
export default class Cart {
  /**
   * Set initial cart state and get needed elements
   *
   * @param {Element} wrapper - An element wrapping all products and the cart.
   * @param {HTMLInputElement} productIdsReceiver - Input element to add id's of products in the cart to.
   * @param {CartOptions} opts - Extra options
   */
  constructor(wrapper, productIdsReceiver,  opts = {}) {
    this.wrapper = wrapper;
    this.productIdsReceiver = productIdsReceiver;
    this.productElements = wrapper.querySelectorAll(opts.productsSelector || '.js-product');
    this.totalReceivers = wrapper.querySelectorAll(opts.totalReceivers || '.js-total-receiver');
    this.cart = opts.initialProducts || [];

    this.productElements.forEach(productElement => {
      productElement.querySelector(opts.addToCartSelector || '.js-add-to-cart').addEventListener('click', _ => {
        this.addToCart(productElement.dataset.product);
      });
    });
  }

  /**
   * Add a product to the cart
   * @param {Product} product - The product to add.
   */
  addToCart(product) {
    this.cart.push(product);
    this.onCartChange();
  }

  /**
   * Removes all items from the cart
   */
  clearCart() {
    this.cart.length = 0;
    this.onCartChange();
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
    this.cartItemsContainer.innerHTML = '';
    this.cart.forEach(product => {
      this.cartItemsContainer.appendChild(this.getElement(product));
    });
  }

  /**
   * Calculates the total price and sets it on the element
   */
  renderTotal() {
    const total = this.centsToEuro(this.cart.reduce((prev, curr) => prev + curr.price, 0));
    this.totalReceiver.textContent = total;
  }
  
  /**
   * Converts cents to euros for display
   * @param {number} cents - The cents to convert to euros.
   */
  centsToEuro(cents) {
    let euro = cents / 100;
    return euro.toLocaleString("nl-NL", {style:"currency", currency:"EUR"});
  }

  /**
   * Puts a comma seperated list of all product ids into the ids element
   */
  updateProductIds() {
    this.productIdsReceiver.value = this.cart.reduce((prev, curr) => prev.length > 0 ? prev + ',' + curr.id : prev + curr.id, '');
  }

  /**
   * Return product markup
   * @param {Product} product - The product's information to use.
   */
  getElement(product) {
    const element = document.createElement('div');
    element.classList.add('cart-item', 'd-flex', 'align-items-center', 'justify-content-between');
    
    const image = document.createElement('img');
    image.src = '/storage/' + product.product_picture;
    image.classList.add('cart-ítem-img');
    element.appendChild(image);
  
    const title = document.createElement('span');
    title.textContent = product.title.length > 50 ? product.title.substring(0, 50) + '...' : product.title;
    title.classList.add('cart-item-title');
    element.appendChild(title);
  
    const price = document.createElement('span');
    price.textContent = this.centsToEuro(product.price);
    title.classList.add('cart-item-price');
    element.appendChild(price);
  
    return element;
  }
}
