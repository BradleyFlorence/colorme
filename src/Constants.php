<?php

namespace ColorMe;

/**
 * Class that holds constants.
 *
 * @author Frederic Filosa <filosa@applistic.com>
 * @copyright (c) 2014, Frederic Filosa
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Constants
{
// ===== CONSTANTS =============================================================

    /**
     * Base API url.
     */
    const API_URL = "https://api.shop-pro.jp";

    /**
     * Endpoint used for user authorization.
     */
    const EP_AUTHORIZE = "/oauth/authorize";

    /**
     * Endpoint used to exchange an authorization code for an access token.
     */
    const EP_ACCESS_TOKEN = "/oauth/token";

    /**
     * Endpoint for the Shop resource.
     */
    const EP_SHOP = "/v1/shop.json";

    /**
     * Endpoint for the Category resources.
     */
    const EP_CATEGORIES = "/v1/categories.json";

    /**
     * Endpoint for the Product resources.
     */
    const EP_PRODUCTS = "/v1/products.json";

    /**
     * Endpoint for a single Product resource.
     */
    const EP_PRODUCT_SINGLE = "/v1/products/%d.json";

    /**
     * Endpoint for the Sale resources.
     */
    const EP_SALES = "/v1/sales.json";

    /**
     * Endpoint for a single Sale resource.
     */
    const EP_SALE_SINGLE = "/v1/sales/%d.json";

    /**
     * Endpoint for the Payment resources.
     */
    const EP_PAYMENTS = "/v1/payments.json";

    /**
     * Endpoint for the Customer resources.
     */
    const EP_CUSTOMERS = "/v1/customers.json";

    /**
     * Endpoint for a single Customer resource.
     */
    const EP_CUSTOMER_SINGLE = "/v1/customers/%d.json";

// ===== STATIC PROPERTIES =====================================================
// ===== STATIC FUNCTIONS ======================================================
// ===== PROPERTIES ============================================================
// ===== ACCESSORS =============================================================
// ===== CONSTRUCTOR ===========================================================
// ===== PUBLIC METHODS ========================================================
// ===== PROTECTED METHODS =====================================================
// ===== PRIVATE METHODS =======================================================
}