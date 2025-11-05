<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'SRWC_User_Win_Email' ) ) :

	class SRWC_User_Win_Email extends WC_Email {

		protected $customer_email;
		protected $coupon_code;
		protected $date_expires;
		protected $confirmation_url;

		/**
		 * Constructor for the class.
		 */
		public function __construct() {

			$this->id             = 'srwc_customer_win_email';
			$this->customer_email = true;
			$this->title          = esc_html__( 'SRWC: Customer Win Email', 'spin-rewards-for-woocommerce' );
			$this->subject        = esc_html__( 'Congratulations! You won a discount coupon', 'spin-rewards-for-woocommerce' );
			$this->heading        = esc_html__( 'Congratulations! You won a discount coupon', 'spin-rewards-for-woocommerce' );
			$this->description    = esc_html__( 'Sent to customers when they win a coupon from the spin wheel.', 'spin-rewards-for-woocommerce' );
			$this->template_html  = 'emails/srwc-user-win.php';

			$this->init_form_fields();

			add_action( 'srwc_customer_win_email', [ $this, 'trigger' ], 10, 4 );

			parent::__construct();

			$this->email_type = 'html';
		}

		public function get_default_subject() {
			return esc_html__( 'Spin rewards coupon award.', 'spin-rewards-for-woocommerce' );
		}

		public function get_default_heading() {
			return esc_html__( 'Congratulations!', 'spin-rewards-for-woocommerce' );
		}

		public function get_default_email_body() {
            return esc_html__(
                "Hi,\nYou have won a discount coupon by spinning the lucky wheel on our store! \nThank you! \n",
                'spin-rewards-for-woocommerce'
            );
		}

		public function trigger( $customer_email, $coupon_code, $date_expires, $confirmation_url = '' ) {

			if ( ! $this->is_enabled() ) :
				return;
            endif;

			$this->setup_locale();

			$this->customer_email   = $customer_email;
			$this->coupon_code      = $coupon_code;
			$this->date_expires     = $date_expires;
			$this->confirmation_url = $confirmation_url;

			$this->recipient = $this->customer_email;

			$this->send(
				$this->get_recipient(),
				$this->get_subject(),
				$this->get_content(),
				$this->get_headers(),
				$this->get_attachments()
			);

			$this->restore_locale();
		}

		public function get_content_html() {

			$email_body = $this->format_string( $this->get_option( 'email_body', $this->get_default_email_body() ) );

			return wc_get_template_html(
				$this->template_html,
				array(      
					'email_heading'      => $this->get_heading(),
					'email'              => $this,
					'email_body'         => $email_body,
					'coupon_code'        => $this->coupon_code,
					'date_expires'       => $this->date_expires,
					'confirmation_url'   => $this->confirmation_url,
				),
				'spin-rewards-for-woocommerce/',
				SRWC_TEMPLATE_PATH
			);
		}

		public function init_form_fields() {
			$this->form_fields = array(
				'enabled' => array(
					'title'   => esc_html__( 'Enable/Disable', 'spin-rewards-for-woocommerce' ),
					'type'    => 'checkbox',
					'label'   => esc_html__( 'Enable this email notification', 'spin-rewards-for-woocommerce' ),
					'default' => 'yes',
				),
				'subject' => array(
					'title'       => esc_html__( 'Subject', 'spin-rewards-for-woocommerce' ),
					'type'        => 'text',
					'description' => esc_html__( 'Leave blank to use the default subject:', 'spin-rewards-for-woocommerce' ) . sprintf( ' <code>%s</code>', $this->get_default_subject() ),
					'placeholder' => $this->get_default_subject(),
					'default'     => '',
				),
				'heading' => array(
					'title'       => esc_html__( 'Email Heading', 'spin-rewards-for-woocommerce' ),
					'type'        => 'text',
					'description' => esc_html__( 'Leave blank to use the default heading:', 'spin-rewards-for-woocommerce' ) . sprintf( ' <code>%s</code>', $this->get_default_heading() ),
					'placeholder' => $this->get_default_heading(),
					'default'     => '',
				),
				'email_body' => array(
					'title'       => esc_html__( 'Email Body', 'spin-rewards-for-woocommerce' ),
					'type'        => 'textarea',
					'description' => esc_html__( 'Defaults to:', 'spin-rewards-for-woocommerce' )
						. sprintf( ' <code>%s</code>', $this->get_default_email_body() )
						. '<br>' . esc_html_x(
							'You can use the following placeholders:',
							'Email body placeholder instructions',
							'spin-rewards-for-woocommerce'
						)
						. ' <code>{coupon_code}, {date_expires}</code>',
					'placeholder' => '',
					'default'     => '',
				),
			);
		}
	}

endif;
