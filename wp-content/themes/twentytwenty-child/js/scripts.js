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
const ssp_staple_conditional_checkbox = ($, form_id) => {

  if (form_id === 1) {

    // array of child inputs
    // const checkboxInputs = $(`li.gfield.staple.hole-punch div.ginput_container li input`);

    const one_staple = $('input#choice_1_66_1');
    const two_staple = $('input#choice_1_66_2');
    const four_staple = $('input#choice_1_66_3');

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
    ssp_staple_conditional_checkbox($, form_id);

    // Add tab functionality to SSP
    bind_tabs_event($, form_id);

  }

}

// LARGE FORMAT PRINTING FORM //

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
