<?php
/**
 * Wrapper API Graphcomment v1.0.
 * @author ddtraceweb <david@semiologic.fr>
 * @copyright 2017 Graphcomment
 * Date: 12/04/2017
 * Time: 15:29
 */

namespace Graphcomment;

use GuzzleHttp\Client;

/**
 * Class Sdk
 * @package Graphcomment
 */
class Sdk
{

    /**
     * @var
     */
    protected $gcPublic;
    protected $gcSecret;
    protected $dir = 'https://graphcomment.com/api';

    /**
     * Sdk constructor.
     * @param $GC_PUBLIC
     * @param $GC_SECRET
     */
    public function __construct($GC_PUBLIC, $GC_SECRET)
    {
        $this->setGcPublic($GC_PUBLIC);
        $this->setGcSecret($GC_SECRET);
    }

    /**
     * @return mixed
     */
    public function getGcPublic()
    {
        return $this->gcPublic;
    }

    /**
     * @param mixed $gcPublic
     */
    public function setGcPublic($gcPublic)
    {
        $this->gcPublic = $gcPublic;
    }

    /**
     * @return mixed
     */
    public function getGcSecret()
    {
        return $this->gcSecret;
    }

    /**
     * @param mixed $gcSecret
     */
    public function setGcSecret($gcSecret)
    {
        $this->gcSecret = $gcSecret;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getDir()
    {
        return $this->dir;
    }

    /**
     * @param mixed $dir
     */
    public function setDir($dir)
    {
        $this->dir = $dir;
    }

    /**
     * registerUser() Register a user to Graphcomment.
     *
     * @param string $username required unique
     * @param string $email required unique
     * @param string $language (optionnal) default value : en (codes ISO 639-1)
     * @param string $picture (full url only example : https://graphcomment.com/image.jpg)
     *
     * @return object  json response gc_id to store in your database
     */
    public function registerUser($username, $email, $language = "en", $picture = '')
    {
        $client = new Client();
        $data = array(
            "username" => $username, // required unique
            "email" => $email, // required unique
            "language" => $language, //(optionnal) default value : en (codes ISO 639-1)
            "picture" => $picture // (optionnal) full url only
        );

        $res = $client->request('POST', $this->getDir() . '/pub/sso/registerUser/pubkey/' . urlencode($this->getGcPublic()) . '/key/' . urlencode($this->generateSsoData($data)), ['http_errors' => false]);

        if ($res->getStatusCode() == "200") {
            return $res->getBody();
        } else {
            return $res->getBody();
        }
    }

    /**
     * loginUser() authenticate a user and return a token to login in graphcomment.
     *
     * @param string $gc_id
     *
     * @return object  json JWT response
     */
    public function loginUser($gc_id)
    {
        $client = new Client();

        $data = array(
            "gc_id" => $gc_id
        );

        $res = $client->request('POST', $this->getDir() . '/pub/sso/loginUser/pubkey/' . urlencode($this->getGcPublic()). '/key/' . urlencode($this->generateSsoData($data)), ['http_errors' => false]);

        return $res->getBody();
    }


    /**
     * getUser() return the informations that we have on the user
     *
     * @param $gc_id
     * @return object JSON {
     *
     *
     * }
     */
    public function getUser($gc_id)
    {
        $client = new Client();

        $data = array(
            "gc_id" => $gc_id
        );

        $res = $client->request('GET', $this->getDir() . '/pub/sso/getUser/pubkey/' . urlencode($this->getGcPublic()). '/key/' . urlencode($this->generateSsoData($data)), ['http_errors' => false]);

        return $res->getBody();
    }


    /**
     * updateUser() return the informations that we have on the user
     *
     * @param $gc_id
     * @param string $username required unique
     * @param string $email required unique
     * @param string $language (optionnal) default value : en (codes ISO 639-1)
     * @param string $picture (full url only example : https://graphcomment.com/image.jpg)
     *
     * @return object JSON {
        gc_id : data.gc_id,
        res :'updated'
        } or {
            gc_id : data.gc_id,
            res :'nothing updated'
        }
     */
    public function updateUser($gc_id, $username, $email, $language, $picture)
    {
        $client = new Client();

        $data = array(
            "gc_id" => $gc_id,
            "username" => $username,
            "email" => $email,
            "language" => $language,
            "picture" => $picture
        );

        $res = $client->request('PUT', $this->getDir() . '/pub/sso/updateUser/pubkey/' . urlencode($this->getGcPublic()). '/key/' . urlencode($this->generateSsoData($data)), ['http_errors' => false]);

        return $res->getBody();
    }


    /**
     * deleteUser() delete a user and return ok confirmation.
     *
     * @param string $gc_id
     *
     * @return string ok
     */
    public function deleteUser($gc_id)
    {
        $client = new Client();

        $data = array(
            "gc_id" => $gc_id
        );

        $res = $client->request('DELETE', $this->getDir() . '/pub/sso/deleteProfileByGcId/pubkey/' . urlencode($this->getGcPublic()). '/key/' . urlencode($this->generateSsoData($data)), ['http_errors' => false]);

        return $res->getBody();
    }



    /**
     * countComments() return the number thread's comment
     *
     * @param $url (full url only) required
     * @param string $uid (unique id of the thread) optionnal
     * @return object json {count: numberOfComments }
     */
    public function countComments($url, $uid='') {
        $client = new Client();

        $data = array(
            "url" => $url,
            "uid" => $uid
        );

        $res = $client->request('GET', $this->getDir() . '/pub/sso/numberOfComments/pubkey/' . urlencode($this->getGcPublic()). '/key/' . urlencode($this->generateSsoData($data)), ['http_errors' => false]);

        return $res->getBody();
    }

    /**
     * generateSsoData() generate sso Data
     *
     * @param $data array
     * @return string
     */
    private function generateSsoData($data) {
        $message = base64_encode(json_encode($data));
        $timestamp = time();

        $hexsig = $this->gcHmacsha1($message . ' ' . $timestamp, $this->getGcSecret());

        return $message . ' ' . $hexsig . ' ' . $timestamp;
    }

    /**
     * gcHmacsha1() encode datas
     *
     * @param $data
     * @param $key
     * @return string
     */
    private function gcHmacsha1($data, $key)
    {

        $blocksize = 64;
        $hashfunc = 'sha1';

        if (strlen($key) > $blocksize)
            $key = pack('H*', $hashfunc($key));

        $key = str_pad($key, $blocksize, chr(0x00));
        $ipad = str_repeat(chr(0x36), $blocksize);
        $opad = str_repeat(chr(0x5c), $blocksize);
        $hmac = pack(
            'H*', $hashfunc(
                ($key ^ $opad) . pack(
                    'H*', $hashfunc(
                        ($key ^ $ipad) . $data
                    )
                )
            )
        );

        return bin2hex($hmac);
    }
}