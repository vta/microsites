// GLOBAL GF FORM FUNCTIONS // (APPLIES TO MORE THAN 1 FORM)

/**
 * Tab Select (Helper Function)
 *
 * changes to page based off of chosen tab
 * @param $ - jQuery selector
 * @param page_num - page number to change to
 */
const add_tab_select = ($, form_id, page_num) => {

  $(`#gform_target_page_number_${form_id}`).val(page_num);
  $(`#gform_${form_id}`).trigger('submit', [true]);

}

/**
 * Tabs Function
 *
 * creates event listeners for each tab click
 * @param $ - jQuery Selector
 */
const bind_tabs_event = ($, form_id) => {

  // Loop through the 3 tabs and set up event listeners
  for (let page_num = 1; page_num <= 3; page_num++) {
    $(`#gf_step_${form_id}_${page_num}`)
      .attr('role', 'button')
      .attr('aria-pressed', 'false')
      .attr('tabindex', page_num)
      .live('click', () => add_tab_select($, form_id, page_num));
  }

}

/**
 * Add Form classes Classes
 *
 * current workaround to add classes to WooCommerce product forms
 * (gf classes are removed when forms are integrated with WC)
 * @param $ - jQuery selector
 * @param form_id
 */
const add_form_class = ($, form_id) => {

  // assign the correct class depending on Form ID
  // (may need to change in the future we add more forms)
  let form_class = form_id === 1 ? 'standard-size-form' : 'large-format-form';

  // Add "standard-size-form" & "cc-form" class
  $('form.cart')
    .addClass(form_class)
    .addClass('cc-form');

}

// BUSINESS CARD FORM //

/**
 * Business Card Form Setup
 *
 * runs functions to set up business card form
 * @param $
 */
const bc_form_setup = ($, form_id) => {

  // add tab functionality to business cards
  bind_tabs_event($, form_id);

}

// STANDARD-SIZE PRINTING FORM //

/**
 * SSP Conditional Checkbox Choices
 *
 * only allow for one type of staple to be chosen for stapling
 * @param $
 * @param form_id
 */
const ssp_staple_conditional_checkbox = ($, form_id, current_page) => {

  if (form_id === 1 && current_page === 3) {

    const one_staple = $('li.gfield.staple.hole-punch ul li:nth-of-type(1) input');
    const two_staple = $('li.gfield.staple.hole-punch ul li:nth-of-type(2) input');
    const four_staple = $('li.gfield.staple.hole-punch ul li:nth-of-type(3) input');

    // if 1-staple is chosen, remove options 2- & 4-
    one_staple.change(() => {
      two_staple.attr('checked', false);
      four_staple.attr('checked', false);
    });

    // if 2-staple is chosen, remove options 1- & 4-
    two_staple.change(() => {
      one_staple.attr('checked', false);
      four_staple.attr('checked', false);
    });

    // if 4-staple is chosen, remove options 1- & 2-
    four_staple.change(() => {
      one_staple.attr('checked', false);
      two_staple.attr('checked', false);
    });

  }
}

const check_num_paper_size = ($) => {
  const num_checked = $(`form.standard-size-form div.gform_wrapper div.gform_page ul.gform_fields li.paper-size.page-2 div ul li input:checked`).length;
  const mult_paper_size_input = $(`form.standard-size-form div.gform_wrapper div.gform_page ul.gform_fields li.multiple-paper-size.page-2`);

  // update hidden field to correctly satisfy GF conditional feld
  $(`form.standard-size-form div.gform_wrapper div.gform_page ul.gform_fields li.page-2.num-selected-paper-sizes div input`).val(num_checked);

  num_checked > 1
    ? mult_paper_size_input.css('display', 'block') && mult_paper_size_input.css('animation', '0.5s fadeIn')
    : mult_paper_size_input.css('display', 'none');
}

const show_mult_paper_size = ($, form_id, current_page) => {

  // Make sure we are on Standard-Size Printing form page 2
  if (form_id === 1 && current_page === 2) {

    const paper_size_inputs = $(`form.standard-size-form div.gform_wrapper div.gform_page ul.gform_fields li.paper-size.page-${current_page} div ul li input`);

    // check num selection & render description input on page load
    check_num_paper_size($);

    // detect changes from all checkboxes
    paper_size_inputs.change(() => {
      // check num selection & render description input on input change
      check_num_paper_size($);
    });

  }

}

/**
 * Standard-Size Printing Form Setup
 *
 * runs function to set up "Standard-Size Printing" form
 * @param $ - jQuery selector
 * @param form_id
 * @param current_page
 */
const ssp_form_setup = ($, form_id, current_page) => {

  if (form_id === 1) {
    // adding additional classes to SSP form
    add_form_class($, form_id);

    // Conditional values for stapling options
    ssp_staple_conditional_checkbox($, form_id, current_page);

    // Add tab functionality to SSP
    bind_tabs_event($, form_id);

    // Multiple paper size input
    show_mult_paper_size($, form_id, current_page);

  }

}

// LARGE FORMAT PRINTING FORM //

/**
 * LFP Disable Format 2nd Choice
 *
 * the second choice acts as a label. Disable the input
 */
const disable_format_label = ($, form_id, current_page) => {

  const input_elem = `form.large-format-form ul.gform_fields li.gfield.page-${current_page}.format ul.gfield_radio li:nth-child(2) input`;

  // Make sure we are on LFP page 2
  if (form_id === 7 && current_page === 2) {
    $(input_elem).prop('disabled', true);
  }

}

/**
 * Large Format Printing Form Setup
 *
 * runs function to set up "Large Format Printing" form
 * @param $
 * @param form_id
 * @param current_page
 */
const lfp_form_setup = ($, form_id, current_page) => {

  if (form_id === 7) {
    // adding additional classes to LFP form
    add_form_class($, form_id);

    // Add tab functionality to LFP
    bind_tabs_event($, form_id);

    // disable page 2 Format 2nd input
    disable_format_label($, form_id, current_page);

  }

}

// MAIN //

/**
 * Load scripts when Gravity Forms Render
 */
jQuery(document).on('gform_post_render', (event, form_id, current_page) => {

  // save global variable
  const $ = jQuery;

  // Set up Business Card Printing form
  bc_form_setup($, form_id);

  // Set up Standard-Size Printing form
  ssp_form_setup($, form_id, current_page);

  // Set up Large Format Printing form
  lfp_form_setup($, form_id, current_page);

});
