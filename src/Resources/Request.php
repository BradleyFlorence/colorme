<?php

namespace ColorMe\Resources;

use GuzzleHttp\Client as HttpClient;

/**
 * Base request for resources.
 *
 * @author Frederic Filosa <filosa@applistic.com>
 * @copyright (c) 2014, Frederic Filosa
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
abstract class Request
{
// ===== CONSTANTS =============================================================
// ===== STATIC PROPERTIES =====================================================
// ===== STATIC FUNCTIONS ======================================================
// ===== PROPERTIES ============================================================

    /**
     * @var \GuzzleHttp\Client
     */
    private $httpClient;

    /**
     * @var string|int The resource id.
     */
    protected $id;

    /**
     * @var string The resource URL.
     */
    protected $url;

    /**
     * @var array The request parameters.
     */
    protected $parameters = array();

    /**
     * @var array The request body as an array of key/values.
     */
    protected $body = array();

    /**
     * @var \ColorMe\Auth
     */
    protected $auth;

    /**
     * @var array The resource properties.
     */
    protected $properties = array();

// ===== ACCESSORS =============================================================

    public function __get($key)
    {
        if (array_key_exists($key, $this->properties)) {
            return $this->properties[$key];
        } else {
            $message = "The property {$key} doesn't exist.";
            throw new \Exception($message);
        }
    }

    public function __set($key, $value)
    {
        $this->properties[$key] = $value;
    }

// ===== CONSTRUCTOR ===========================================================

    public function __construct(\ColorMe\Auth $auth)
    {
        $this->auth = $auth;
    }

// ===== PUBLIC METHODS ========================================================

    /**
     * Sets a name/value pair to the parameters.
     * Pass a `null` value to remove the previously set parameter.
     *
     * @param string $name
     * @param mixed $value
     * @throws \InvalidArgumentException If the $name parameter is not a string.
     */
    public function setParameter($name, $value = null)
    {
        $this->setArrayKey($this->parameters, $name, $value);
        return $this;
    }

    /**
     * Sets a name/value pair to the request body.
     * Pass a `null` value to remove the previously set property.
     *
     * @param string $name
     * @param mixed $value
     * @throws \InvalidArgumentException If the $name parameter is not a string.
     */
    public function setBodyProperty($name, $value = null)
    {
        $this->setArrayKey($this->body, $name, $value);
        return $this;
    }

    /**
     * Sets the `offset` parameter and returns this request for method chaining.
     *
     * @param  int $offset
     * @return \ColorMe\Resources\Request
     */
    public function offset($offset)
    {
        $this->setParameter("offset", $offset);
        return $this;
    }

    /**
     * Sets the `limit` parameter and returns this request for method chaining.
     *
     * @param  int $offset
     * @return \ColorMe\Resources\Request
     */
    public function limit($limit)
    {
        $this->setParameter("limit", $limit);
        return $this;
    }

    /**
     * Executes a GET request and returns the results.
     *
     * @see    http://shop-pro.jp/?mode=api_interface
     * @param  array $parameters Optional array of filters to include in the
     *                           query string.
     * @return array
     */
    public function get(array $parameters = null)
    {
        if (is_array($parameters)) {
            foreach ($parameters as $key => $value) {
                $this->setParameter($key, $value);
            }
        }

        return $this->executeRequest("GET");
    }

    /**
     * Executes a POST request and returns the results.
     *
     * @see    http://shop-pro.jp/?mode=api_interface
     * @param  array $properties Array of properties to include in the body.
     * @return array
     */
    public function post(array $properties)
    {
        if (is_array($properties)) {
            foreach ($properties as $key => $value) {
                $this->setBodyProperty($key, $value);
            }
        }

        return $this->executeRequest("POST");
    }

    /**
     * Executes a PUT request and returns the results.
     *
     * @see    http://shop-pro.jp/?mode=api_interface
     * @param  array $properties Array of properties to include in the body.
     * @return array
     */
    public function put(array $properties)
    {
        if (is_array($properties)) {
            foreach ($properties as $key => $value) {
                $this->setBodyProperty($key, $value);
            }
        }

        return $this->executeRequest("PUT");
    }

    /**
     * Executes a DELETE request and returns the results.
     *
     * @see    http://shop-pro.jp/?mode=api_interface
     * @param  array $parameters Optional array of filters to include in the
     *                           query string.
     * @return array
     */
    public function delete(array $parameters = null)
    {
        if (is_array($parameters)) {
            foreach ($parameters as $key => $value) {
                $this->setParameter($key, $value);
            }
        }

        return $this->executeRequest("DELETE");
    }

    /**
     * Returns the final request url, including the resource id if it has been
     * set.
     *
     * @return string
     */
    public function getUrl()
    {
        $url = $this->url;

        if (!is_null($this->id)) {
            $url = sprintf($url, $this->id);
        }

        return $url;
    }

    /**
     * Executes the request using the provided HTTP method and returns the
     * results as an array.
     *
     * @param  string $method The HTTP method can be GET, POST, PUT, DELETE.
     *                        The HTTP method can also be a custom method like
     *                        HEAD OR PATCH, but ColorMe doesn't support them.
     * @return array
     */
    public function executeRequest($method)
    {
        $url = $this->getUrl();

        $request = $this->httpClient()->createRequest($method, $url);

        $authHeader = $this->auth->getAuthorizationHeader();
        $request->setHeader("Authorization", $authHeader);

        switch ($method) {

            case "POST":
            case "PUT":
                $body = $request->getBody();
                foreach ($this->parameters as $key => $value) {
                    $body->setField($key, $value);
                }
                break;

            case "GET":
            case "DELETE":
                $query = $request->getQuery();
                foreach ($this->parameters as $key => $value) {
                    $query->set($key, $value);
                }
                break;
        }

        $response = $this->httpClient()->send($request);

        return $this->parseResponse($method, $response);
    }

// ===== PROTECTED METHODS =====================================================

    protected function httpClient()
    {
        if (is_null($this->httpClient)) {
            $this->httpClient = new HttpClient();
        }
        return $this->httpClient;
    }

    /**
     * @param  \GuzzleHttp\Response $response
     * @return mixed
     */
    protected function parseResponse($method, $response)
    {
        // Sub-classes implement this function.
        return null;
    }

    /**
     * Sets or unset a key in an array.
     *
     * @param array  $array
     * @param string $name
     * @param mixed $value
     */
    protected function setArrayKey(array &$array, $name, $value = null)
    {
        if (!is_string($name)) {
            $message = "The parameter name must be a string.";
            throw new \InvalidArgumentException($message);
        }

        if (is_null($value) && array_key_exists($name, $array)) {
            unset($array[$name]);
        } else {
            $array[$name] = $value;
        }
    }

// ===== PRIVATE METHODS =======================================================
}