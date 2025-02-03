<?php
/**
 * Gateway
 *
 * @package       directorist
 * @subpackage    directorist/includes/gateways
 * @copyright     Copyright 2018. AazzTech
 * @license       https://www.gnu.org/licenses/gpl-3.0.en.html GNU Public License
 * @since         7.0.6
 */

// Exit if accessed directly
if (!defined( 'ABSPATH' )) {
    exit;
}

/**
 * ATBDP_Gateway Class
 *
 * @since    7.0.6
 * @access   public
 */

class ATBDP_Gateway{
    private string $extension_url;

    public function __construct()
    {
        // add monetization menu

        add_filter('atbdp_settings_menus', [$this, 'add_monetization_menu']);

        // add gateway submenu
        add_filter('atbdp_monetization_settings_submenus', [$this, 'gateway_settings_submenu'], 10, 1);
        //fields widgets
        add_filter('atbdp_form_preset_widgets', [$this, 'atbdp_form_builder_widgets']);

        $this->extension_url = sprintf("<a target='_blank' href='%s'>%s</a>", esc_url(admin_url('edit.php?post_type=at_biz_dir&page=atbdp-extension')), __('Checkout Other Payment Gateways & Extensions', 'directorist'));

    }

    public function atbdp_form_builder_widgets(array $widgets): array {
            if ( ! is_fee_manager_active() && directorist_is_featured_listing_enabled() ) {
                $widgets['listing-type'] = [
                    'label' => 'Listing Type',
                    'icon' => 'las la-toggle-on',
                    'show' => true,
                    'options' => [
                        'type' => [
                            'type'  => 'hidden',
                            'value' => 'radio',
                        ],
                        'field_key' => [
                            'type'  => 'hidden',
                            'value' => 'listing_type',
                        ],
                        'label' => [
                            'type'  => 'text',
                            'label' => 'Label',
                            'value' => 'Select Listing Type',
                        ],
                        'general_label' => [
                            'type'  => 'text',
                            'label' => 'General label',
                            'value' => 'General',
                        ],
                        'featured_label' => [
                            'type'  => 'text',
                            'label' => 'Featured label',
                            'value' => 'Featured',
                        ],
                        'featured_description' => [
                            'type'  => 'text',
                            'label' => 'Featured description',
                            'value' => 'Promote your listing to the top of search results and listings pages for a specific duration, with an additional payment',
                        ],
                    ],
                ];
            }

            return $widgets;
        }

    /**
     * Add Monetization menu
     * @param array $menus The array of menus
     * @return array It returns the new array of menus.
     */
    public function add_monetization_menu(array $menus): array
    {
        $menus['monetization_menu'] = [
            'title' => __('Monetization', 'directorist'),
            'name' => 'monetization_menu',
            'icon' => 'font-awesome:fa-money-bill-alt',
            'menus' => $this->get_monetization_settings_submenus(),
        ];
        return $menus;
    }


    /**
     * It registers the monetization submenu
     * @return array it returns an array of submenus
     */
    public function get_monetization_settings_submenus()
    {
        return apply_filters('atbdp_monetization_settings_submenus', [
            'monetization_submenu1' => [
                'title' => __( 'Monetization Settings', 'directorist'),
                'name' => 'monetization_submenu1',
                'icon' => 'font-awesome:fa-home',
                'controls' => apply_filters('atbdp_monetization_settings_controls', [
                    'monetization_section' => [
                        'type'          => 'section',
                        'title'         => __('Monetization General Settings', 'directorist'),
                        'description'   => __('You can Customize Monetization settings here. After switching any option, Do not forget to save the changes.', 'directorist'),
                        'fields'        => $this->get_monetization_settings_fields(),
                    ], // ends monetization settings section
                    //class_exists('ATBDP_Pricing_Plans') ? '' :
                    'featured_listing_section' => [
                        'type'          => 'section',
                        'title'         => __('Monetize by Featured Listing', 'directorist'),
                        'description'   => __('You can Customize featured listing related settings here', 'directorist'),
                        'fields'        => $this->get_featured_listing_settings_fields(),
                    ], // ends monetization settings section
                    'monetize_by_subscription' => [
                        'type'          => 'section',
                        'title'         => __('Monetize by Listing Plans', 'directorist'),
                        'fields'        => $this->get_monetize_by_subscription_fields(),
                    ], // ends monetization settings section

                ]),
            ],

        ] );
    }


    /**
     * It register the settings fields for monetization submenu
     * @return array It returns an array of settings fields arrays
     */
    public function get_monetization_settings_fields()
    {
        return apply_filters('atbdp_monetization_settings_fields', [
                [
                    'type' => 'toggle',
                    'name' => 'enable_monetization',
                    'label' => __('Enable Monetization Feature', 'directorist'),
                    'description' => __('Choose whether you want to monetize your site or not. Monetization features will let you accept payment from your users if they submit listing based on different criteria. Default is NO.', 'directorist'),
                    'default' => '',
                ],


            ]
        );
    }


    /**
     * It registers the settings fields of featured listings
     * @return array It returns an array of featured settings fields arrays
     */
    public function get_featured_listing_settings_fields()
    {
        return apply_filters('atbdp_monetization_settings_fields', [
                [
                    'type' => 'toggle',
                    'name' => 'enable_featured_listing',
                    'label' => __('Monetize by Featured Listing', 'directorist'),
                    'description' => __('You can enabled this option to collect payment from your user for making their listing featured.', 'directorist'),
                    'default' => '',
                ],
                [
                    'type' => 'textarea',
                    'name' => 'featured_listing_desc',
                    'label' => __('Description', 'directorist'),
                    'description' => __('You can set some description for your user for upgrading to featured listing.', 'directorist'),
                    'default' => __('(Top of the search result and listings pages for a number days and it requires an additional payment.)', 'directorist'),
                ],
                [
                    'type' => 'textbox',
                    'name' => 'featured_listing_price',
                    'label' => __('Price in ', 'directorist') . atbdp_get_payment_currency(),
                    'description' => __('Set the price you want to charge a user if he/she wants to upgrade his/her listing to featured listing. Note: you can change the currency settings under the gateway settings', 'directorist'),
                    'default' => 19.99,
                ],
            ]
        );
    }


    /**
     * It registers the settings fields of promoting subscription
     * @return array It returns an array of promoting subscription settings fields arrays
     */
    public function get_monetize_by_subscription_fields()
    {
        $pricing_plan = '<a style="color: red" href="https://directorist.com/product/directorist-pricing-plans" target="_blank">Pricing Plans</a>';
        return apply_filters('atbdp_monetization_by_subscription_settings_fields', [
                [
                    'type' => 'notebox',
                    'name' => 'monetization_promotion',
                    'description' => sprintf(__('Monetize your website by selling listing plans using %s extension.', 'directorist'), $pricing_plan),
                ],
            ]
        );
    }


    /**
     * It register the gateway settings submenu
     * @param array $submenus       Array of Submenus
     * @return array                It returns gateway submenu
     */
    public function gateway_settings_submenu(array $submenus): array{
        $submenus['gateway_submenu'] =  [
            'title' => __('Gateways Settings', 'directorist'),
            'name' => 'gateway_general',
            'icon' => 'font-awesome:fa-bezier-curve',
            'controls' => apply_filters('atbdp_gateway_settings_controls', [
                'gateways' => [
                    'type' => 'section',
                    'title' => __('Gateway General Settings', 'directorist'),
                    'description' => __('You can Customize Gateway-related settings here. You can enable or disable any gateways here. Here, YES means Enabled, and NO means disabled. After switching any option, Do not forget to save the changes.', 'directorist'),
                    'fields' => $this->get_gateway_settings_fields(),
                ],
            ]),
        ];
        return $submenus;
    }

    /**
     * It register gateway settings fields
     * @return array It returns an array of gateway settings fields
     */
    public function get_gateway_settings_fields(){

        return apply_filters('atbdp_gateway_settings_fields', [
               'gateway_promotion' => [
                    'type' => 'notebox',
                    'name' => 'paypal_gateway_promotion',
                    'label' => __('Need more gateways?', 'directorist'),
                    'description' => sprintf(__('You can use different payment gateways to process payment including PayPal. %s', 'directorist'), $this->extension_url),
                    'status' => 'warning',
                ],
                [
                    'type' => 'toggle',
                    'name' => 'gateway_test_mode',
                    'label' => __('Enable Test Mode', 'directorist'),
                    'description' => __('If you enable Test Mode, then no real transaction will occur. If you want to test the payment system of your website then you can set this option enabled. NOTE: Your payment gateway must support test mode eg. they should provide you a sandbox account to test. Otherwise, use only offline gateway to test.', 'directorist'),
                    'default' => 1,
                ],
                [
                    'type' => 'checkbox',
                    'name' => 'active_gateways',
                    'label' => __('Active Gateways', 'directorist'),
                    'description' => __('Check the gateway(s) you would like to use to collect payment from your users. A user will be use any of the active gateways during the checkout process ', 'directorist'),
                    'items' => apply_filters('atbdp_active_gateways', [
                        [
                            'value' => 'bank_transfer',
                            'label' => __('Bank Transfer (Offline Gateway)', 'directorist'),
                        ],
                    ]),

                    'default' => [
                        'bank_transfer',
                    ],
                ],

                [
                    'type' => 'select',
                    'name' => 'default_gateway',
                    'label' => __('Default Gateway', 'directorist'),
                    'description' => __('Select the default gateway you would like to show as a selected gateway on the checkout page', 'directorist'),
                    'items' => apply_filters('atbdp_default_gateways', [
                        [
                            'value' => 'bank_transfer',
                            'label' => __('Bank Transfer (Offline Gateway)', 'directorist'),
                        ],
                    ]),

                    'default' => [
                        'bank_transfer',
                    ],
                ],
                /*@todo; think whether it is good to list online payments here or in separate tab when a new payment gateway is added*/


                [
                    'type' => 'notebox',
                    'name' => 'payment_currency_note',
                    'label' => __('Note About This Currency Settings:', 'directorist'),
                    'description' => __('This currency settings lets you customize how you would like to accept payment from your user/customer and how to display pricing on the order form/history.', 'directorist'),
                    'status' => 'info',
                ],
                [
                    'type' => 'textbox',
                    'name' => 'payment_currency',
                    'label' => __( 'Currency Name', 'directorist' ),
                    'description' => __( 'Enter the Name of the currency eg. USD or GBP etc.', 'directorist' ),
                    'default' => 'USD',
                ],
                /*@todo; lets user use space as thousand separator in future. @see: https://docs.oracle.com/cd/E19455-01/806-0169/overview-9/index.html
                */
                [
                    'type' => 'textbox',
                    'name' => 'payment_thousand_separator',
                    'label' => __( 'Thousand Separator', 'directorist' ),
                    'description' => __( 'Enter the currency thousand separator. Eg. , or . etc.', 'directorist' ),
                    'default' => ',',
                ],

                [
                    'type' => 'textbox',
                    'name' => 'payment_decimal_separator',
                    'label' => __('Decimal Separator', 'directorist'),
                    'description' => __('Enter the currency decimal separator. Eg. "." or ",". Default is "."', 'directorist'),
                    'default' => '.',
                ],
                [
                    'type' => 'select',
                    'name' => 'payment_currency_position',
                    'label' => __('Currency Position', 'directorist'),
                    'description' => __('Select where you would like to show the currency symbol. Default is before. Eg. $5', 'directorist'),
                    'default' => [
                        'before',
                    ],
                    'items' => [
                        [
                            'value' => 'before',
                            'label' => __('$5 - Before', 'directorist'),
                        ],
                        [
                            'value' => 'after',
                            'label' => __('After - 5$', 'directorist'),
                        ],
                    ],
                ],

            ]
        );
    }



    public static function gateways_markup(): string
    {
        $active_gateways = get_directorist_option('active_gateways', [ 'bank_transfer' ]);
        $default_gw = get_directorist_option('default_gateway', 'bank_transfer');
        if (empty( $active_gateways )) {
            return '';
        } // if the gateways are empty, vail out.

        $format = '
        <li class="list-group-item">
            <div class="gateway_list directorist-radio directorist-radio-circle">
                <input type="radio" id="##GATEWAY##" name="payment_gateway" value="##GATEWAY##" ##CHECKED##>
                <label for="##GATEWAY##" class="directorist-radio__label">
                    ##LABEL##
                </label>
            </div>
            ##DESC##
        </li>';

        $markup = '<ul>';
        if( !empty( $active_gateways ) ) {
            foreach ($active_gateways as $gw_name){
                $title = get_directorist_option($gw_name.'_title', 'Bank Transfer');
                $desc = get_directorist_option($gw_name.'_description', 'You can make your payment directly to our bank account using this gateway. Please use your ORDER ID as a reference when making the payment. We will complete your order as soon as your deposit is cleared in our bank.');
                $desc = empty( $desc ) ? '' : sprintf("<p class='directorist-payment-text'>%s</p>", $desc);
                $checked = ( $gw_name == $default_gw ) ? ' checked': '';
                $search = ["##GATEWAY##", "##LABEL##", "##DESC##", "##CHECKED##"];
                $replace = [$gw_name, $title, $desc, $checked];
                $markup .= str_replace($search, $replace , $format);
                /*@todo; Add a settings to select a default payment method.*/
            }
        }

        return $markup . '</ul>';
    }

}