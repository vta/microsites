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
  <h1 style="text-align: center;">Place Your Order</h1>
  <div style="visibility: hidden; text-align: center;" id="failure-message" class="ui negative message">
    <div class="header text-center">
      Please enter a Cost Center Number in order to place your Order.
    </div>
  </div>

    <?php if ( $checkout->get_checkout_fields() ) : ?>

        <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

      <div class="col2-set" id="customer_details">

        <h2>Cost Center Number / Project Number <span class="ui red header">*</span></h2>
        <div class="field">
          <div class="ui fluid selection search dropdown">
            <input type="hidden" name="cost_center_number">
            <i class="dropdown icon"></i>
            <div class="default text">Cost Center Number</div>
            <div class="menu cost-center-list">
            </div>
          </div><!-- Cost Center Dropdown -->
        </div>
      </div>

        <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

    <?php endif; ?>

    <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

  <h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>

    <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

  <div id="order_review" class="woocommerce-checkout-review-order">
      <?php do_action( 'woocommerce_checkout_order_review' ); ?>
  </div>

    <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

<script>
  const $ = jQuery;

  // initialize dropdown w/ rules
  $('.ui.search.dropdown').dropdown({
    onChange: function (value, text, $choice) {
      if (value.length)
        console.log(value);
      else
        console.log('empty');
    },
    forceSelection: false,
    selectOnKeydown: false,
    showOnFocus: true,
    clearable: true,
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

      const {data} = await res.json();
      addMenuItems(data);

    });

  const cost_center_input = $('input[name="cost_center_number"][type="hidden"]');
  const checkout_form = $('form.checkout.woocommerce-checkout');
  const place_order_button = $('button#place_order');

  // add classes to Form button
  checkout_form.addClass('ui form');
  place_order_button.addClass('submit');

  // add form validation
  checkout_form
    .form({
      on: 'blur',
      fields: {
        cost_center_number: {
          identifier: 'cost_center_number',
          rules: [{
            type: 'empty',
            prompt: 'Please enter a value'
          }]
        }
      },
      onFailure: function () {
        $('#failure-message').css('visibility', 'visible');
      }
    });

</script>
