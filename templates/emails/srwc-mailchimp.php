<?php 

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
?>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
    }
    .confirmation-container {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 40px;
        max-width: 600px;
        width: 90%;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        text-align: center;
    }
    .success-icon {
        font-size: 64px;
        color: #28a745;
        margin-bottom: 20px;
    }
    .success-message {
        font-size: 24px;
        font-weight: bold;
        color: #495057;
        margin-bottom: 15px;
    }
    .success-text {
        font-size: 16px;
        color: #6c757d;
        line-height: 1.6;
        margin-bottom: 30px;
    }
    .back-link {
        display: inline-block;
        padding: 12px 30px;
        background-color: #007bff;
        color: #ffffff;
        text-decoration: none;
        border-radius: 10px;
        font-weight: bold;
    }
    .back-link:hover {
        background-color: #0056b3;
    }
</style>
<body>
    <div class="confirmation-container">
        <div class="success-icon">✓</div>
        <div class="success-message"><?php esc_html_e( 'Subscription Confirmed', 'spin-rewards-for-woocommerce' ); ?></div>
        <div class="success-text">
            <?php esc_html_e( 'Thank you! Your subscription has been confirmed successfully.', 'spin-rewards-for-woocommerce' ); ?>
        </div>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="back-link">
            <?php esc_html_e( 'Return to Home', 'spin-rewards-for-woocommerce' ); ?>
        </a>
    </div>
</body>

