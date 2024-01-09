import Ajax from "../inc/Ajax";

class ItemVariableCart
{
    constructor()
    {
        try {
            if(!window.hasOwnProperty('cart_variation_localize'))
                throw new Error("Module ItemVariableCart return error, because variable cart_variation_script not found. Please try Again!")

            this.actions = {
                edit: "ajax_variation_form"
            }
            this.buttons = {
                edit: '.edit-variable-product-cart-icon'
            }
            this.url = window.cart_variation_localize.url;
            this.nonce = window.cart_variation_localize.nonce;
            this.selected = [];

            // Init actions
            this.actionEditProduct();

        }
        catch (e) {
            console.error(e);
        }
    }

    actionEditProduct()
    {
        const buttonsEdit = document.querySelectorAll(this.buttons.edit);

        buttonsEdit.forEach(buttonEdit => {
            buttonEdit.addEventListener('click', async (e) => {
                e.preventDefault();
                const currentItem = e.currentTarget;
                const currentItemParent = currentItem.closest('.cart_item')
                try {
                    const editProductRequest = await this.fetchEditProduct({
                        nonce: this.nonce,
                        product_id: +currentItem.getAttribute('data-product-id'),
                        product_key: currentItem.getAttribute('data-cart-item-key'),
                        cols: currentItemParent.children.length
                    });
                    const editProductResponse = await editProductRequest.json();

                    if(!Boolean(editProductResponse.success))
                        throw new Error("Server return invalid data");

                    this.buildEditVariationRow(
                        currentItem,
                        currentItemParent,
                        editProductResponse.data.form,
                        currentItem.getAttribute('data-cart-item-key')
                    );

                    this.setItemQuantity(
                        currentItem.getAttribute('data-cart-item-key'),
                        editProductResponse.data.selected_qty
                    );

                    this.setItemSelectedVariation(
                        currentItem.getAttribute('data-cart-item-key'),
                        editProductResponse.data.selected_variation
                    );
                }
                catch (e){
                    console.error(e)
                }
            })
        })
    }

    setItemQuantity(
        id,
        value
    ) {
        const newRowVariation = document.querySelector(`[data-product-key="${id}"]`);
        const qtyInputItemNewVariation = newRowVariation.querySelector('input[name="quantity"]');
        qtyInputItemNewVariation.value = value;
    }

    setItemSelectedVariation(
        id,
        values
    ) {
        const newRowVariation = document.querySelector(`[data-product-key="${id}"]`);

        Object.entries(values).forEach(([key, value]) => {
            const select = newRowVariation.querySelector('[name="' + key + '"]');
            if (select) select.value = value;
        });
    }

    buildEditVariationRow(
        productButton,
        productRow,
        productVariationResponse,
        product_key
    ) {
        // Clone product thumbnail for variation edit form
        const newItemProductCartRow = document.createElement('tr');
        const script = document.createElement('script');
        script.src = `${window.location.origin}/wp-content/plugins/woocommerce/assets/js/frontend/add-to-cart-variation.min.js?ver=8.4.0`;
        script.type = "text/javascript";

        newItemProductCartRow.classList.add('cart_item_new');
        newItemProductCartRow.setAttribute('data-product-key', product_key);
        newItemProductCartRow.innerHTML = productVariationResponse;
        productRow.after(newItemProductCartRow);

       // productRow.appendChild(script);
    }

    async fetchEditProduct(data)
    {
        return Ajax.post(this.url, this.actions.edit, data);
    }
}

export default ItemVariableCart;