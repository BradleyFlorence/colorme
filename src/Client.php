<?php

namespace ColorMe;

/**
 * Client for the ColorMe API
 *
 * @author Frederic Filosa <filosa@applistic.com>
 * @copyright (c) 2014, Frederic Filosa
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Client
{
// ===== CONSTANTS =============================================================

    const API_URL = "https://api.shop-pro.jp";
    const EP_AUTHORIZE = "/oauth/authorize";

// ===== STATIC PROPERTIES =====================================================
// ===== STATIC FUNCTIONS ======================================================
// ===== PROPERTIES ============================================================

    /**
     * @var string The client ID of your application.
     * @link http://api.shop-pro.jp/oauth/applications
     */
    public $clientId;

    /**
     * @var string The client secret of your application.
     * @link http://api.shop-pro.jp/oauth/applications
     */
    public $clientSecret;

    /**
     * @var string The URL where ColorMe will redirect the user after
     *             authorization.
     * @link http://api.shop-pro.jp/oauth/applications
     */
    public $redirectUri;

    /**
     * @var string The access token used to make API requests on behalf of the
     *             user.
     */
    public $accessToken;

// ===== ACCESSORS =============================================================
// ===== CONSTRUCTOR ===========================================================

    public function __construct(
        $clientId,
        $clientSecret,
        $redirectUri,
        $accessToken = null
    ) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUri = $redirectUri;
        $this->accessToken = $accessToken;
    }

// ===== PUBLIC METHODS ========================================================

    /**
     * Returns the URL where you should send the user for authorization.
     *
     * @param  array  $scope The permissions required by your application.
     *                       Include one or many of the following:
     *                       - read_products
     *                       - write_products
     *                       - read_sales
     *                       - write_sales
     * @return string
     */
    public function getAuthorizeUrl(array $scope)
    {
        $joinedScope = implode(" ", $scope);

        $parameters = array(
            'client_id=' . urlencode($this->clientId),
            'response_type=code',
            'scope=' . urlencode($joinedScope),
            'redirect_uri=' . urlencode($this->redirectUri),
        );

        $url = self::API_URL . self::EP_AUTHORIZE
             . "?" . implode("&", $parameters);

        return $url;
    }

// ===== PROTECTED METHODS =====================================================
// ===== PRIVATE METHODS =======================================================
}