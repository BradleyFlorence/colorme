<?php

namespace ColorMe\Resources;

use ColorMe\Constants;

/**
 * The Sale resource.
 *
 * @author Frederic Filosa <filosa@applistic.com>
 * @copyright (c) 2014, Frederic Filosa
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Sale extends Request
{
// ===== CONSTANTS =============================================================
// ===== STATIC PROPERTIES =====================================================
// ===== STATIC FUNCTIONS ======================================================
// ===== PROPERTIES ============================================================
// ===== ACCESSORS =============================================================
// ===== CONSTRUCTOR ===========================================================

    public function __construct(\ColorMe\Auth $auth, $id = null)
    {
        parent::__construct($auth);

        $this->id = $id;

        if (is_null($this->id)) {
            $this->url = Constants::API_URL . Constants::EP_SALES;
        } else {
            $this->url = Constants::API_URL . Constants::EP_SALE_SINGLE;
        }
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
                if (is_null($this->id)) {
                    $data = $json;
                } else {
                    $data = $json['sale'];
                }
                break;
        }

        return $data;
    }

// ===== PRIVATE METHODS =======================================================
}