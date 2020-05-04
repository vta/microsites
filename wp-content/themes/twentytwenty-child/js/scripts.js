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
 * Standard-Size Printing Form Adding Classes
 *
 * current workaround to add classes to WooCommerce product forms
 * (gf classes are removed when forms are integrated with WC)
 * @param $ - jQuery selector
 * @param form_id
 */
const ssp_form_class = ($, form_id) => {

  //@TODO - id selector is not working, will need to resolve later on

  // Add "standard-size-form" & "cc-form" class
  $(`form.cart`)
    .addClass('standard-size-form')
    .addClass('cc-form');

}

/**
 * Standard-Size Printing Form Setup
 *
 * runs function to set up business card forms
 * @param $ - jQuery selector
 */
const ssp_form_setup = ($, form_id, current_page) => {

  // adding additional classes to SSP form
  ssp_form_class($, form_id);
}

/**
 * Load scripts when Gravity Forms Render
 */
jQuery(document).on('gform_post_render',  (event, form_id, current_page) => {

  // save global variable
  const $ = jQuery;

  // Set up business card form
  bc_form_setup($);

  // Set up standard-size printing form
  ssp_form_setup($, form_id, current_page);
});
