// BUSINESS CARDS

/**
 * Business Card Tab Select (Helper Function)
 *
 * changes to page based off of chosen tab
 * @param $ - jQuery selector
 * @param page_num - page number to change to
 */
const bc_select_tab = ($, page_num) => {

  $('#gform_target_page_number_4').val(page_num);
  $('#gform_4').trigger('submit', [true]);

}

/**
 * Business Card Tabs Function
 *
 * creates event listeners for each tab click
 * @param $ - jQuery Selector
 */
const bc_tabs = ($) => {

  // BC Tab 1: Your Information
  $('#gf_step_4_1').live('click', () => bc_select_tab($, '1'));

  // BC Tab 2: Contact
  $('#gf_step_4_2').live('click', () => bc_select_tab($, '2'));

  // BC Tab 3: Request
  $('#gf_step_4_3').live('click', () => bc_select_tab($, '3'));
}

// STANDARD-SIZE PRINTING FORM

/**
 * Business Card Form Setup
 *
 * runs functions to set up business card form
 * @param $
 */
const bc_form_setup = ($) => {

  // add tab functionality to business cards
  bc_tabs($);

}

/**
 * Standard-Size Printing Form Addinng Classes
 *
 * current workaround to add classes to WooCommerce product forms
 * (gf classes are removed when forms are integrated with WC)
 * @param $ - jQuery selector
 */
const ssp_form_class = ($) => {

  // Add generic "cc-form" class to all forms
  $('form.cart').addClass('cc-form');

  // Add "standard-size-form" class
  $('form.cart.cc-form').addClass('standard-size-form');

}

/**
 *  Standard-Size Printing Insert Container
 * @param $
 */
const ssp_insert_containers = ($) => {

  const formWrapper = 'form.standard-size-form ul.gform_fields';

  // create containers 1 thru 4 and add within formWrapper
  for (let i = 1; i <= 4; i++) {

    let childFields = `form.standard-size-form div.gform_body div.gform_page ul.gform_fields li.gfield.container-${i}-child`;

    // new container element
    let newChild = $(`
      <li class="container-${i}">
        <ul class="container-${i}-list">
        
        </ul>
      </li>
    `);

    // detach from parent node & append to <ul> element inside of newChild
    $(childFields).detach().appendTo(newChild.children());

    // add empty container-{#} to our form body wrapper
    $(formWrapper).append(newChild);
  }

}

/**
 * Standard-Size Printing Form Setup
 *
 * runs function to set up business card forms
 * @param $ - jQuery selector
 */
const ssp_form_setup = ($) => {

  // adding additional classes to SSP form
  ssp_form_class($);

  // insert new containers
  ssp_insert_containers($);
}

/**
 * Load jQuery when document is ready...
 */
jQuery(document).ready(function ($) {

  // Set up business card form
  bc_form_setup($);

  // Set up standard-size printing form
  ssp_form_setup($);
});
