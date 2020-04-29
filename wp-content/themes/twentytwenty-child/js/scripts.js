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

/**
 * Form Class Function
 *
 * current workaround to add classes to woocommerce product forms
 * (gf classes are removed when forms are integrated with WC)
 * @param $ - jQuery selector
 */
const wc_form_class = ($) => {

  // Add generic "cc-form" class to all forms
  $('form.cart').addClass('cc-form');

  // Add "standard-size-form" class
  $('form.cart.cc-form').addClass('standard-size-form');

}

/**
 * Load jQuery when document is ready...
 */
jQuery(document).ready(function ($) {

  // add tab functionality to business cards
  bc_tabs($);

  // add "cc-class" to wc forms
  wc_form_class($);
});
