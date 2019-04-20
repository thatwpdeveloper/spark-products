<?php

/**
 * Manages http cookies.
 *
 * This class allows to get, set and unset cookies in the browser.
 *
 * @since      1.0.0
 * @package    Spark_Products
 * @subpackage Spark_Products/includes
 * @link http://www.rogerethomas.com/blog/php-class-to-manage-http-cookies
 */

class Spark_Products_Cookie {

	/**
	 * Holds the instance of this class.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var $_instance
	 */
	protected static $_instance = null;

	/**
	 * Retrieves the singleton instance.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return Spark_Products_Cookie
	 */
	public static function get_instance() {
		if ( self::$_instance == null ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Sets a cookie in the browser.
	 *
	 * Do not store sensitive information.
	 *
	 * @since 1.0.0
	 * @access public
	 * @link http://www.php.net/manual/en/function.set_cookie.php
	 * @param name string The name of the cookie.
	 * @param value string The value of the cookie.
	 * @param expire int The time the cookie expires.
	 * @param path string The path on the server in which the cookie will be available on.
	 * @param domain string The domain that the cookie is available.
	 * @param secure bool Indicates that the cookie should only be transmitted over a secure HTTPS connection from the client.
	 * @param httponly bool If true the cookie will be made accessible only through the HTTP protocol.
	 * @return bool Indicates whether the user accepted the cookie.
	 */
	public function set_cookie( $name, $value = null, $expire = null, $path = null, $domain = null, $secure = null, $httponly = null ) {
		$set = setcookie( $name, $value, $expire, $path, $domain, $secure, $httponly );

		return $set;
	}

	/**
	 * Unset a cookie by name
	 *
	 * @since 1.0.0
	 * @access public
	 * @param string $name
	 * @return boolean
	 */
	public function unset_cookie( $name ) {
		if ( $this->get_cookie( $name ) != false ) {
			set_cookie( $name, "", time() - 3600 );

			return true;
		}

		return false;
	}

	/**
	 * Retrieves a cookie by name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @param string $name
	 * @return string|boolean Returns false in case of failure.
	 */
	public function get_cookie( $name ) {
		if ( isset( $_COOKIE ) && is_array( $_COOKIE ) && array_key_exists( $name, $_COOKIE ) ) {
			return $_COOKIE[ $name ];
		}

		return false;
	}
}