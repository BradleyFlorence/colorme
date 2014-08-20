<?php

namespace ColorMe;

use GuzzleHttp\Client as HttpClient;

/**
 * Class managing authentication with the ColorMe API.
 *
 * @author Frederic Filosa <filosa@applistic.com>
 * @copyright (c) 2014, Frederic Filosa
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Auth
{
// ===== CONSTANTS =============================================================
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

    /**
     * @var string The code received after user's authorization.
     */
    public $authorizationCode;

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
    public function getAuthorizationUrl(array $scope)
    {
        $joinedScope = implode(" ", $scope);

        $parameters = array(
            "client_id=" . urlencode($this->clientId),
            "response_type=code",
            "scope=" . urlencode($joinedScope),
            "redirect_uri=" . urlencode($this->redirectUri),
        );

        $url = Constants::API_URL . Constants::EP_AUTHORIZE
             . "?" . implode("&", $parameters);

        return $url;
    }

    /**
     * Handles the authorization response, retreiving the code in case of
     * success.
     *
     * If the authorization code is retreived, we contact ColorMe to get an
     * access token. In case of success, that access token is returned.
     * In case of failure `null` is returned.
     *
     * @return string|null
     */
    public function handleAuthorizationResponse()
    {
        $this->authorizationCode = null;

        if (array_key_exists("code", $_GET)) {
            $this->authorizationCode = $_GET["code"];
        }

        if (is_string($this->authorizationCode)) {
            return $this->requestAccessToken();
        } else {
            return null;
        }
    }

    /**
     * Requests an access token using the received authorization code.
     *
     * @param  string $code Optional authorization code. If it is not provided,
     *                      the `authorizationCode` property will be used.
     * @return string
     * @throws \InvalidArgumentException If $code is not provided and the
     *                                   `authorizationCode` property is null.
     */
    public function requestAccessToken($code = null)
    {
        if (!is_string($code) && !is_string($this->authorizationCode)) {
            $message = "The authorization code is required.";
            throw new \InvalidArgumentException($message);
        }

        if (!is_string($code)) {
            $code = $this->authorizationCode;
        }

        $this->accessToken = null;

        $url = Constants::API_URL . Constants::EP_ACCESS_TOKEN;

        $http = new HttpClient();
        $request = $http->createRequest("POST", $url);
        $body = $request->getBody();
        $body->setField("client_id", $this->clientId);
        $body->setField("client_secret", $this->clientSecret);
        $body->setField("code", $code);
        $body->setField("grant_type", "authorization_code");
        $body->setField("redirect_uri", $this->redirectUri);

        try {
            $response = $http->send($request)->json();
            $this->accessToken = $response["access_token"];
        } catch (\Exception $e) {
            // An error occurred.
            // The null access token will be returned.
        }


        return $this->accessToken;
    }

    /**
     * Returns the `Authorization` header used to authorize API requests.
     *
     * @return string
     */
    public function getAuthorizationHeader()
    {
        if (is_string($this->accessToken)) {
            return "Bearer {$this->accessToken}";
        } else {
            return null;
        }
    }

// ===== PROTECTED METHODS =====================================================
// ===== PRIVATE METHODS =======================================================
}