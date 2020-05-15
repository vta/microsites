<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 *
 * TEMPLATE OVERRIDE - removing the additional column & adding Cost Center Dropdown
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( !$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in() ) {
    echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
    return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout"
      action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
  <h1 class="checkout-form-header">Place Your Order</h1>

  <h2 class="header">
    Review your order and confirm that all of the details are correct. Please select a Cost Center Number before
    placing your order (required). If you have a Project, include it underneath the Cost Center Number.
  </h2>

  <div style="visibility: hidden; text-align: center;" id="failure-message" class="ui negative message">
    <div class="header" id="failure-message-text">

    </div>
  </div>

    <?php if ( $checkout->get_checkout_fields() ) : ?>

        <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

      <div class="col2-set cost-center-project-number" id="customer_details">

        <p class="cost-center-instruction project-number-instruction">
          Please select the Cost Center Number. If you have a Project Number, please include this to the order as well.
        </p>

        <div class="field cost-center-wrapper">
          <h2>Cost Center Number <span class="ui red header">*</span></h2>
          <div class="ui fluid selection search dropdown">
            <input type="hidden" name="cost_center_number">
            <i class="dropdown icon"></i>
            <div class="default text">Cost Center Number</div>
            <div class="menu cost-center-list">
            </div>
          </div><!-- Cost Center Dropdown -->
        </div>

        <div class="field project-number-wrapper">
          <h2>Project Number</h2>
          <div class="ui input">
            <input name="project_number" type="text" placeholder="Project Number">
          </div>
          <p>Project number should start with the letter <strong>P</strong> followed by at <strong>least 3 digits</strong>.
            Example:
            <em>P123</em></p>
        </div>

      </div><!-- Cost Center Number & Project Number Container -->

        <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

    <?php endif; ?>

    <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

  <h3 id="order_review_heading"><?php esc_html_e( 'Order Details', 'woocommerce' ); ?></h3>

    <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

  <div id="order_review" class="woocommerce-checkout-review-order">
      <?php do_action( 'woocommerce_checkout_order_review' ); ?>
  </div>

    <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

<script>
  const $ = jQuery;

  // initialize Cost Center searchable dropdown w/ Semantic UI settings
  $('.ui.search.dropdown').dropdown({
    forceSelection: false,
    selectOnKeydown: false,   // forces user to left-click or hit enter to select option
    showOnFocus: true,        // when input is focused, options appear
    clearable: true,          // allows user to clear input w/ "x" icon
    ignoreCase: true,         // case insensitive when searching
    fullTextSearch: true,     // allow to search parts of strings
    on: "hover"
  });

  /**
   * Dynamically add cost center choices to dropdown
   * @param data - cost center information
   */
  function addMenuItems(data) {

    for (let cost_center_obj of data) {
      // grab variables from object
      const {cost_center, cost_center_name} = cost_center_obj;
      // Create list item as cost center drop down selection
      $('div.cost-center-list.menu')
        .append(`<div class="item" data-value="${cost_center}">${cost_center} -  ${cost_center_name}</div>`);
    }

  }

  // Fetch JSON data and populate select options
  fetch("<?php echo get_stylesheet_directory_uri() . '/woocommerce/checkout/cost_center.json'?>")
    .then(async res => {
      const { data } = await res.json();
      addMenuItems(data);
    });

  const checkout_form = $('form.checkout.woocommerce-checkout');
  const place_order_button = $('button#place_order');

  // add Semantic UI classes to form button (form validation behaviors)
  checkout_form.addClass('ui form');
  place_order_button.addClass('submit');

  // add front-end form validation
  checkout_form
    .form({
      on: 'blur',
      fields: {
        cost_center_number: {
          identifier: 'cost_center_number',
          rules: [{
            type: 'empty',
            prompt: 'You must select a Cost Center Number.'
          }]
        },
        project_number: {
          identifier: 'project_number',
          rules: [{
            type: 'regExp',
            prompt: 'The project number that you have entered has an invalid format.',
            value: /^[\s]*[Pp][0-9]{3,}[\s]*|[\s]*$/    // Input validation: starts with P and a minimum of 3
            // digits
          }]
        }
      },
      onFailure: function (formErrors, fields) {
        // show failure-message container
        $('#failure-message').css('visibility', 'visible');

        // grab only the first error
        const error_message = formErrors[0];

        console.log(error_message);

        // clear any previous error messages and fill new error message
        $('#failure-message-text').empty().text(error_message);
      }
    });

  // clone submit button and place at the top of the Order Review
  const clone_place_order_button = place_order_button.clone();
  $('div#order_review').prepend(clone_place_order_button);


</script>
