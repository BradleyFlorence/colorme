<?php

use ColorMe\Client;

/**
 * Test case for the Client class.
 *
 * @author Frederic Filosa <filosa@applistic.com>
 * @copyright (c) 2014, Frederic Filosa
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class ClientTestCase extends ColorMeTestCase
{
// ===== CONSTANTS =============================================================

    const CLIENT_ID = "12345abcdefghijklmn";
    const CLIENT_SECRET = "opqrstuvwxyz67890";
    const REDIRECT_URI = "http://fake-domain-example.com/after-auth";

// ===== STATIC PROPERTIES =====================================================
// ===== STATIC FUNCTIONS ======================================================
// ===== PROPERTIES ============================================================
// ===== ACCESSORS =============================================================
// ===== CONSTRUCTOR ===========================================================
// ===== PUBLIC METHODS ========================================================

    public function testValidInstanciation()
    {
        $client = new Client(
            self::CLIENT_ID,
            self::CLIENT_SECRET,
            self::REDIRECT_URI
        );
    }

    /**
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function testInvalidInstanciation()
    {
        $client = new Client();
    }

    public function testAuthorizeUrlWithOnePermission()
    {
        $client = new Client(
            self::CLIENT_ID,
            self::CLIENT_SECRET,
            self::REDIRECT_URI
        );

        $scope = array('read_products');

        $expectedUrl = Client::API_URL . Client::EP_AUTHORIZE
                     . "?client_id=" . self::CLIENT_ID
                     . "&response_type=code"
                     . "&scope=read_products"
                     . "&redirect_uri=" . urlencode(self::REDIRECT_URI);

        $authorizeUrl = $client->getAuthorizeUrl($scope);

        $this->assertSame($expectedUrl, $authorizeUrl);
    }

    public function testAuthorizeUrlWithAllPermissions()
    {
        $client = new Client(
            self::CLIENT_ID,
            self::CLIENT_SECRET,
            self::REDIRECT_URI
        );

        $scope = array(
            'read_products',
            'write_products',
            'read_sales',
            'write_sales',
        );

        $expectedUrl = Client::API_URL . Client::EP_AUTHORIZE
                     . "?client_id=" . self::CLIENT_ID
                     . "&response_type=code"
                     . "&scope=read_products+write_products+read_sales+write_sales"
                     . "&redirect_uri=" . urlencode(self::REDIRECT_URI);

        $authorizeUrl = $client->getAuthorizeUrl($scope);

        $this->assertSame($expectedUrl, $authorizeUrl);
    }

// ===== PROTECTED METHODS =====================================================
// ===== PRIVATE METHODS =======================================================
}