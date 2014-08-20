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


// ===== PROTECTED METHODS =====================================================
// ===== PRIVATE METHODS =======================================================
}