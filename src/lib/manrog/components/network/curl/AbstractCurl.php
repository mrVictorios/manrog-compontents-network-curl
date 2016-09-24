<?php

namespace manrog\components\network\curl;

/**
 * Class AbstractCurl
 *
 * This class acts as Wrapper for curl functions
 *
 * @package manrog\components\network\curl
 * @codeCoverageIgnore
 */
abstract class AbstractCurl implements CurlInterface
{
    /**
     * Closes a cURL session and frees all resources. The cURL handle, ch, is also deleted.
     *
     * @param resource $ch cURL handle returned by init().
     */
    public function close($ch)
    {
        return curl_close($ch);
    }

    /**
     * Copy a cURL handle along with all of its preferences
     *
     * @param resource $ch Copies a cURL handle keeping the same preferences.
     *
     * @return resource Returns a new cURL handle.
     */
    public function copy_handle($ch)
    {
        return curl_copy_handle($ch);
    }

    /**
     * Returns the error number for the last cURL operation.
     *
     * @param resource $ch $ch A cURL handle returned by init().
     *
     * @return int Returns the error number or 0 (zero) if no error occurred.
     */
    public function errno($ch)
    {
        return curl_errno($ch);
    }

    /**
     * Return a string containing the last error for the current session
     *
     * @param resource $ch $ch A cURL handle returned by init().
     *
     * @return string Returns the error message or '' (the empty string) if no error occurred.
     */
    public function error($ch)
    {
        return curl_error($ch);
    }

    /**
     * URL encodes the given string
     *
     * @param resource $ch  A cURL handle returned by init().
     * @param string   $str The string to be encoded.
     *
     * @return string|false Returns escaped string or FALSE on failure.
     */
    public function escape($ch, $str)
    {
        return curl_escape($ch, $str);
    }

    /**
     * Execute the given cURL session
     *
     * @param resource $ch A cURL handle returned by init().
     *
     * @return mixed Returns TRUE on success or FALSE on failure. However, if the CURLOPT_RETURNTRANSFER option is set,
     *               it will return the result on success, FALSE on failure.
     */
    public function exec($ch)
    {
        return curl_exec($ch);
    }

    /**
     * This function is an alias of: CURLFile::__construct()
     * CURLFile::__construct -- curl_file_create — Create a CURLFile object
     *
     * @param string $filename Path to the file which will be uploaded.
     * @param string $mimetype Mimetype of the file.
     * @param string $postname Name of the file to be used in the upload data.
     *
     * @return \CURLFile
     */
    public function file_create($filename, $mimetype, $postname)
    {
        return curl_file_create($filename, $mimetype, $postname);
    }

    /**
     * Get information regarding a specific transfer
     *
     * @param resource $ch      A cURL handle returned by init().
     * @param int      $opt     This may be one of the following constants: (look at
     *                          http://php.net/manual/en/function.curl-getinfo.php
     *                          )
     *
     * @return array|false If opt is given, returns its value. Otherwise, returns an associative array with the
     *                     following elements (which correspond to opt), or FALSE on failure
     */
    public function getinfo($ch, $opt)
    {
        return curl_getinfo($ch, $opt);
    }

    /**
     * Initializes a new session and return a cURL handle for use with the setopt(), exec(), and close() functions.
     *
     * @param string|null $url [optional]
     *
     * @return resource|false a cURL handle on success, false on errors.
     */
    public function init($url = null)
    {
        return curl_init($url);
    }

    /**
     * Add a normal cURL handle to a cURL multi handle
     *
     * @param resource $mh A cURL multi handle returned by multi_init().
     * @param resource $ch A cURL handle returned by nit().
     *
     * @return int Returns 0 on success, or one of the CURLM_XXX errors code.
     */
    public function multi_add_handle($mh, $ch)
    {
        return curl_multi_add_handle($mh, $ch);
    }

    /**
     * Close a set of cURL handles
     *
     * @param resource $mh A cURL multi handle returned by multi_init().
     *
     * @return void
     */
    public function multi_close($mh)
    {
        curl_multi_close($mh);
    }

    /**
     * Run the sub-connections of the current cURL handle
     *
     * @param resource $mh            A cURL multi handle returned by multi_init().
     * @param int      $still_running A reference to a flag to tell whether the operations are still running.
     *
     * @return int A cURL code defined in the cURL Predefined Constants.
     */
    public function multi_exec($mh, &$still_running)
    {
        return curl_multi_exec($mh, $still_running);
    }

    /**
     * Return the content of a cURL handle if CURLOPT_RETURNTRANSFER is set
     *
     * @param resource $ch A cURL handle returned by init().
     *
     * @return mixed Return the content of a cURL handle if CURLOPT_RETURNTRANSFER is set.
     */
    public function multi_getcontent($ch)
    {
        return curl_multi_getcontent($ch);
    }

    /**
     * Get information about the current transfers
     *
     * @param resource $mh           A cURL multi handle returned by multi_init().
     * @param int|null $msg_in_queue Number of messages that are still in the queue.
     *
     * @return array|false On success, returns an associative array for the message, FALSE on failure.
     */
    public function multi_info_read($mh, &$msg_in_queue = null)
    {
        return curl_multi_info_read($mh, $msg_in_queue);
    }

    /**
     * Returns a new cURL multi handle
     *
     * @return resource|false Returns a cURL multi handle resource on success, FALSE on failure.
     */
    public function multi_init()
    {
        return curl_multi_init();
    }

    /**
     * Remove a multi handle from a set of cURL handles
     *
     * @param resource $mh A cURL multi handle returned by multi_init().
     * @param resource $ch A cURL handle returned by init().
     *
     * @return int Returns 0 on success, or one of the CURLM_XXX error codes.
     */
    public function multi_remove_handle($mh, $ch)
    {
        return curl_multi_remove_handle($mh, $ch);
    }

    /**
     * Wait for activity on any curl_multi connection
     *
     * @param resource $mh      A cURL multi handle returned by multi_init().
     * @param float    $timeout Time, in seconds, to wait for a response.
     *
     * @return int On success, returns the number of descriptors contained in the descriptor sets. This may be 0 if
     *             there was no activity on any of the descriptors. On failure, this function will return -1 on a
     *             select failure (from the underlying select system call).
     */
    public function multi_select($mh, $timeout = 1.0)
    {
        return curl_multi_select($mh, $timeout);
    }

    /**
     * Set an option for the cURL multi handle
     *
     * @param resource $mh
     * @param int      $option One of the CURLMOPT_* constants.
     * @param mixed    $value  The value to be set on option. value should be an int for the following values of the
     *                         option parameter: (look at http://php.net/manual/en/function.curl-multi-setopt.php
     *                         )
     *
     * @return boolean Returns TRUE on success or FALSE on failure.
     */
    public function multi_setopt($mh, $option, $value)
    {
        return curl_multi_setopt($mh, $option, $value);
    }

    /**
     *  Return string describing error code
     *
     * @param int $errornum One of the » CURLM error codes constants.
     *
     * @return string|null Returns error string for valid error code, NULL otherwise.
     */
    public function multi_strerro($errornum)
    {
        return curl_multi_strerror($errornum);
    }

    /**
     * Pause and unpause a connection
     *
     * @param resource $ch
     * @param int      $bitmask
     *
     * @return int Returns an error code (CURLE_OK for no error).
     */
    public function pause($ch, $bitmask)
    {
        return curl_pause($ch, $bitmask);
    }

    /**
     * Reset all options of a libcurl session handle
     *
     * @param resource $ch A cURL handle returned by init().
     *
     * @return void
     */
    public function reset($ch)
    {
        curl_reset($ch);
    }

    /**
     * Set multiple options for a cURL transfer
     *
     * @param resource $ch      A cURL handle returned by init().
     * @param array    $options An array specifying which options to set and their values. The keys should be valid
     *                          curl_setopt() constants or their integer equivalents
     *
     * @return boolean Returns TRUE if all options were successfully set. If an option could not be successfully set,
     *                 FALSE is immediately returned, ignoring any future options in the options array.
     */
    public function setopt_array($ch, $options)
    {
        return curl_setopt_array($ch, $options);
    }

    /**
     * Set an option for a cURL transfer
     *
     * @param resource $ch     A cURL handle returned by init().
     * @param int      $option The CURLOPT_XXX option to set
     * @param mixed    $value  The value to be set on option.
     *                         value should be a bool for the following values of the option parameter: (look at
     *                         http://php.net/manual/en/function.curl-setopt.php)
     *
     * @return boolean Returns TRUE on success or FALSE on failure.
     */
    public function setopt($ch, $option, $value)
    {
        return curl_setopt($ch, $option, $value);
    }

    /**
     * Close a cURL share handle
     *
     * @param resource $sh A cURL share handle returned by share_init()
     *
     * @return void
     */
    public function share_close($sh)
    {
        curl_share_close($sh);
    }

    /**
     * Initialize a cURL share handle
     *
     * @return resource Returns resource of type "cURL Share Handle".
     */
    public function share_init()
    {
        return curl_share_init();
    }

    /**
     * Set an option for a cURL share handle.
     *
     * @param resource $sh A cURL share handle returned by share_init().
     * @param int      $option
     * @param string   $value
     *
     * @return boolean Returns TRUE on success or FALSE on failure.
     */
    public function share_setopt($sh, $option, $value)
    {
        return curl_share_setopt($sh, $option, $value);
    }

    /**
     * Return string describing the given error code
     *
     * @param int $errornum One of the » cURL error codes constants.
     *
     * @return string|null Returns error description or NULL for invalid error code.
     */
    public function strerror($errornum)
    {
        return curl_strerror($errornum);
    }

    /**
     * Decodes the given URL encoded string
     *
     * @param resource $ch  A cURL handle returned by init().
     * @param string   $str The URL encoded string to be decoded.
     *
     * @return string|boolean Returns decoded string or FALSE on failure.
     */
    public function unescape($ch, $str)
    {
        return curl_unescape($ch, $str);
    }

    /**
     * Gets cURL version information
     *
     * @param $age
     *
     * @return array Returns an associative array with the following elements: (look at Returns an associative array with the following elements:)
     */
    public function version($age = CURLVERSION_NOW)
    {
        return curl_version($age);
    }
}
