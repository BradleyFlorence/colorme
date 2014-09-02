<?php

namespace ColorMe;

use ColorMe\Resources\Shop;
use ColorMe\Resources\Product;
use ColorMe\Resources\Category;
use ColorMe\Resources\Sale;
use ColorMe\Resources\Payment;
use ColorMe\Resources\Customer;

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
// ===== STATIC PROPERTIES =====================================================
// ===== STATIC FUNCTIONS ======================================================
// ===== PROPERTIES ============================================================

    /**
     * @var \ColorMe\Auth
     */
    protected $auth;

// ===== ACCESSORS =============================================================

    /**
     * Returns the authentication manager.
     *
     * @return \ColorMe\Auth
     */
    public function auth()
    {
        return $this->auth;
    }

// ===== CONSTRUCTOR ===========================================================

    public function __construct(
        $clientId,
        $clientSecret,
        $redirectUri,
        $accessToken = null
    ) {
        $this->auth = new Auth(
            $clientId,
            $clientSecret,
            $redirectUri,
            $accessToken
        );
    }

// ===== PUBLIC METHODS ========================================================

    public function shop()
    {
        return new Shop($this->auth);
    }

    public function categories()
    {
        return new Category($this->auth);
    }

    public function products($id = null)
    {
        return new Product($this->auth, $id);
    }

    public function sales($id = null)
    {
        return new Sale($this->auth, $id);
    }

    public function payments($id = null)
    {
        return new Payment($this->auth, $id);
    }

    public function customers($id = null)
    {
        return new Customer($this->auth, $id);
    }

// ===== PROTECTED METHODS =====================================================
// ===== PRIVATE METHODS =======================================================
}