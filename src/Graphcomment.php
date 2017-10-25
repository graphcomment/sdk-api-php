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
    protected $username;
    protected $password;
    protected $token;
    protected $websiteId;
    protected $dir = 'https://graphcomment.com/api';

    /**
     * Sdk constructor.
     * @param $username
     * @param $password
     * @param string $websiteId
     */
    public function __construct($username, $password, $websiteId = "")
    {
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setWebsiteId($websiteId);
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
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
     * @return mixed
     */
    public function getWebsiteId()
    {
        return $this->websiteId;
    }

    /**
     * @param mixed $websiteId
     */
    public function setWebsiteId($websiteId)
    {
        $this->websiteId = $websiteId;
    }


    /**
     * Authentification() this method use to authenticate your account to allow the SDK.
     * You must call after the constructor settings and before all methods.
     *
     * @return string  json response JWT
     */
    public function authentification()
    {
        $client = new Client();
        $res = $client->request('POST', $this->getDir() . '/users/login',
            [
                'form_params' => [
                    'username' => $this->getUsername(),
                    'password' => $this->getPassword()
                ],
                'http_errors' => false
            ]);

        if ($res->getStatusCode() == "200") {
            $result = json_decode($res->getBody());

            $this->setToken($result->token);
        } else {
            return $res->getBody();
        }
    }

    /**
     * GetUsersQuery() this method call your members list and you can search by query and paginate the result.
     *
     * @param string $page_size
     * @param string $page_nbr
     * @param string $query
     *
     * @return string  json response user list
     */
    public function getUsersQuery($page_size = "10", $page_nbr = "1", $query = "user")
    {
        $client = new Client();
        $res = $client->request('GET', $this->getDir() . '/users',
            [
                'headers' => [
                    'Authorization' => 'JWT ' . $this->getToken()
                ],
                'query' => [
                    'website_id' => $this->getWebsiteId(),
                    'page_size' => $page_size,
                    'page_nbr' => $page_nbr,
                    'query' => $query
                ],
                'http_errors' => false
            ]);

        return $res->getBody();
    }

    /**
     * registerUser() Register a user to Graphcomment.
     *
     * @param string $username
     * @param string $email
     * @param string $language
     *
     * @return string  json response gc_id to store in your database
     */
    public function registerUser($username, $email, $language = "en")
    {
        $client = new Client();
        $res = $client->request('POST', $this->getDir() . '/users/registerUserSdk',
            [
                'headers' => [
                    'Authorization' => 'JWT ' . $this->getToken()
                ],
                'multipart' => [
                    [
                        'name' => 'username',
                        'contents' => $username
                    ],
                    [
                        'name' => 'email',
                        'contents' => $email
                    ],
                    [
                        'name' => 'language',
                        'contents' => $language
                    ],
                    [
                        'name' => 'from_website',
                        'contents' => $this->getWebsiteId()
                    ]
                ],
                'query' => [
                    'website_id' => $this->getWebsiteId()
                ],
                'http_errors' => false
            ]);

        if ($res->getStatusCode() == "200") {
            return $res->getBody();
        }
        else {
            return $res->getBody();
        }
    }

    /**
     * loginUser() authenticate a user and return a token to login in graphcomment.
     *
     * @param string $gc_id
     *
     * @return string  json JWT response
     */
    public function loginUser($gc_id)
    {
        $client = new Client();
        $res = $client->request('POST', $this->getDir() . '/users/loginSdk',
            [
                'headers' => [
                    'Authorization' => 'JWT ' . $this->getToken()
                ],
                'form_params' => [
                    'gc_id' => $gc_id,
                    'website_id' => $this->getWebsiteId()
                ],
                'http_errors' => false
            ]);

        return $res->getBody();
    }

    /**
     * getThread() Load the Thread of the url of the page with all comments of the thread for the SEO.
     *
     * @param string $url be "//domain/path" example //graphcomment.com/accueil.html
     *
     * @return string  json thread details
     */
    public function getThread($url)
    {
        $client = new Client();
        $res = $client->request('GET', $this->getDir() . '/website/'.$this->getWebsiteId().'/Threadload',
            [
                'headers' => [
                    'Authorization' => 'JWT ' . $this->getToken()
                ],
                'query' => [
                    'website_id' => $this->getWebsiteId(),
                    'url' => $url,
                ],
                'http_errors' => false
            ]);

        return $res->getBody();
    }
}