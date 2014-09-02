<?php

namespace ColorMe\Resources;

use ColorMe\Constants;

/**
 * The Shop resource.
 *
 * @author Frederic Filosa <filosa@applistic.com>
 * @copyright (c) 2014, Frederic Filosa
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Shop extends Request
{
// ===== CONSTANTS =============================================================
// ===== STATIC PROPERTIES =====================================================
// ===== STATIC FUNCTIONS ======================================================
// ===== PROPERTIES ============================================================
// ===== ACCESSORS =============================================================
// ===== CONSTRUCTOR ===========================================================

    public function __construct(\ColorMe\Auth $auth)
    {
        parent::__construct($auth);

        $this->url = Constants::API_URL . Constants::EP_SHOP;
    }

// ===== PUBLIC METHODS ========================================================
// ===== PROTECTED METHODS =====================================================

    /**
     * @param  \GuzzleHttp\Response $response
     * @return mixed
     */
    protected function parseResponse($method, $response)
    {
        $data = null;

        switch ($method) {
            case "GET":
                $json = $response->json();
                if (array_key_exists("shop", $json)) {
                    $data = $json["shop"];
                }
                break;
        }

        return $data;
    }

// ===== PRIVATE METHODS =======================================================
}