/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./public/src/js/main.js":
/*!*******************************!*\
  !*** ./public/src/js/main.js ***!
  \*******************************/
/***/ (() => {

eval("/**\r\n * Scripts by Shayer Developer\r\n * 05.01.2024\r\n */\n\n(function ($) {\n  $(document).ready(function () {\n    // Actions Ajax Query\n    const nonce = window.cart_variation_localize.nonce;\n    const actions = {\n      edit: \"ajax_variation_form\",\n      update: \"ajax_variation_form_update\"\n    };\n\n    // Customize Cart table\n    if ($(document.body).hasClass('woocommerce-cart')) {\n      $('td.product-quantity').remove();\n      $('th.product-quantity').remove();\n    }\n\n    // Action: Get variable form\n    $(document).on('click', '.edit-variable-product-cart-icon', async e => {\n      e.preventDefault();\n      const currentBtn = e.currentTarget;\n      const currentRow = $(currentBtn).closest('.cart_item');\n      $(currentBtn).attr('disabled', true);\n\n      // Upload row updated\n      currentRow.addClass('process-upload-variable');\n\n      // Item Attribute\n      const product_id = currentBtn.getAttribute('data-product-id');\n      const product_key = currentBtn.getAttribute('data-cart-item-key');\n\n      // Ajax: Get Form\n      const variationFormRequest = await fetch(`${window.cart_variation_localize.url}?action=${actions.edit}`, {\n        method: \"POST\",\n        headers: {\n          'Content-Type': 'application/json'\n        },\n        body: JSON.stringify({\n          cols: currentRow.children().length,\n          product_key,\n          product_id,\n          nonce\n        })\n      });\n      const variationFormResponse = await variationFormRequest.json();\n      if (!variationFormResponse.success) {} else {\n        // Hide row\n        currentRow.removeClass('process-upload-variable').addClass('process-update-variable');\n        const formVariation = variationFormResponse.data.form;\n        const variationTR = document.createElement('tr');\n        variationTR.classList.add(`cart_item_new_` + product_key);\n        currentRow.after(variationTR);\n        const selectVariationTd = $(`tr.cart_item_new_${product_key}`);\n        selectVariationTd.html(formVariation);\n\n        // get row form variations\n        const rowProductFormVariation = $(`.cart_item_new_${product_key}`);\n\n        // Set selected qty value\n        rowProductFormVariation.find(`input[name=\"quantity\"]`).val(+variationFormResponse.data.selected_qty);\n\n        // Set selected attr values\n        Object.entries(variationFormResponse.data.selected_variation).forEach(([key, value]) => {\n          const select = rowProductFormVariation.find('[name=\"' + key + '\"]');\n          if (select) select.val(value);\n        });\n      }\n      $(currentBtn).attr('disabled', false);\n    });\n\n    // Action: Update variable product\n    $(document).on('click', 'form.variations_form button[data-action=\"update\"]', async e => {\n      e.preventDefault();\n      const currentBtn = e.currentTarget;\n      const form = currentBtn.closest('form.variations_form');\n      const formData = new FormData(form);\n      $(currentBtn).attr('disabled', true);\n\n      // Item Attribute\n      const product_key = currentBtn.getAttribute('data-product-key');\n\n      // Custom fields\n      formData.append('cart-item-key', product_key);\n\n      // Send Data variable update\n      const variationUpdateRequest = await fetch(`${window.cart_variation_localize.url}?action=${actions.update}`, {\n        method: \"POST\",\n        body: formData\n      });\n\n      // Get response update variation\n      const variationUpdateResponse = await variationUpdateRequest.json();\n      if (!variationUpdateResponse.success) {} else {\n        $('button[name=\"update_cart\"]').attr('disabled', false);\n        $('button[name=\"update_cart\"]').click();\n      }\n      $(currentBtn).attr('disabled', false);\n    });\n\n    // Action: Cancel update variable product\n    $(document).on('click', '.product-variables-actions button[data-action=\"cancel\"]', e => {\n      e.preventDefault();\n      const currentBtn = e.currentTarget;\n      const currentProductKey = $(currentBtn).attr('data-product-key');\n      const currentProductRow = $(`.cart_item_new_${currentProductKey}`);\n\n      // Remove invise class from origin product variation\n      currentProductRow.prev().removeClass('process-update-variable');\n\n      // Remove current product variation form\n      currentProductRow.remove();\n    });\n  });\n})(jQuery);\n\n//# sourceURL=webpack://modal-lang-redirect/./public/src/js/main.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./public/src/js/main.js"]();
/******/ 	
/******/ })()
;