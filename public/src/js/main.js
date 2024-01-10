/**
 * Scripts by Shayer Developer
 * 05.01.2024
 */

(function($){
    $(document).ready(function(){

        // Actions Ajax Query
        const nonce = window.cart_variation_localize.nonce;
        const actions = {
            edit: "ajax_variation_form",
            update: "ajax_variation_form_update"
        }

        // Customize Cart table
        if($(document.body).hasClass('woocommerce-cart')){
            $('td.product-quantity').remove();
            $('th.product-quantity').remove();
        }

        // Action: Get variable form
        $(document).on('click', '.edit-variable-product-cart-icon', async (e) =>{
            e.preventDefault();

            const currentBtn = e.currentTarget;
            const currentRow = $(currentBtn).closest('.cart_item');

            $(currentBtn).attr('disabled', true);

            // Upload row updated
            currentRow.addClass('process-upload-variable');

            // Item Attribute
            const product_id = currentBtn.getAttribute('data-product-id');
            const product_key = currentBtn.getAttribute('data-cart-item-key');

            // Ajax: Get Form
            const variationFormRequest = await fetch(
                `${window.cart_variation_localize.url}?action=${actions.edit}`,
                {
                    method: "POST",
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        cols: currentRow.children().length,
                        product_key,
                        product_id,
                        nonce
                    }),
                }
            );

            const variationFormResponse = await variationFormRequest.json();

            if(!variationFormResponse.success){
                console.error(variationUpdateResponse);
            }else{

                // Hide row
                currentRow
                    .removeClass('process-upload-variable')
                    .addClass('process-update-variable');

                const formVariation = variationFormResponse.data.form;
                const variationTR = document.createElement('tr');
                variationTR.classList.add(`cart_item_new_` + product_key);
                currentRow.after(variationTR);
                
                const selectVariationTd = $(`tr.cart_item_new_${product_key}`);
                selectVariationTd.html(formVariation);

                // get row form variations
                const rowProductFormVariation = $(`.cart_item_new_${product_key}`);

                // Set selected qty value
                rowProductFormVariation.find(`input[name="quantity"]`)
                    .val(+variationFormResponse.data.selected_qty);

                // Set selected attr values
                Object.entries(variationFormResponse.data.selected_variation).forEach(([key, value]) => {
                    const select = rowProductFormVariation.find('[name="' + key + '"]');
                    if (select)
                        select.val(value);
                });
            }
            $(currentBtn).attr('disabled', false);
        });

        // Action: Update variable product
        $(document).on('click', 'form.variations_form button[data-action="update"]', async (e) => {
            e.preventDefault();
            const currentBtn = e.currentTarget;
            const form = currentBtn.closest('form.variations_form');
            const formData = new FormData(form);

            $(currentBtn).attr('disabled', true);

            // Item Attribute
            const product_key = currentBtn.getAttribute('data-product-key');

            // Custom fields
            formData.append('cart-item-key', product_key);

            // Send Data variable update
            const variationUpdateRequest = await fetch(`${window.cart_variation_localize.url}?action=${actions.update}`, {
                method: "POST",
                body: formData
            });

            // Get response update variation
            const variationUpdateResponse = await variationUpdateRequest.json();

            if(!variationUpdateResponse.success){
                console.error(variationUpdateResponse);
            }else{
                $('button[name="update_cart"]').attr('disabled', false);
                $('button[name="update_cart"]').click()

            }
            $(currentBtn).attr('disabled', false);
        });

        // Action: Cancel update variable product
        $(document).on('click', '.product-variables-actions button[data-action="cancel"]', (e) => {
            e.preventDefault();
            const currentBtn = e.currentTarget;
            const currentProductKey = $(currentBtn).attr('data-product-key');
            const currentProductRow = $(`.cart_item_new_${currentProductKey}`);

            // Remove invise class from origin product variation
            currentProductRow.prev().removeClass('process-update-variable');

            // Remove current product variation form
            currentProductRow.remove();
        })
    });
})(jQuery);

