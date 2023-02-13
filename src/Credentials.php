<?php


namespace TekBaseAPI;

class Credentials
{
    private $token;
    private $url;
    private $reseller_id;
    /**
     * Credentials constructor.
     * @param string $token api token
     * @param string $reseller_id Reseller User ID
     */
    public function __construct(string $token, string $reseller_id)
    {
        $this->token = $token;
        $this->reseller_id = $reseller_id;
        $this->url = 'https://api.tekbase.de/v1/reseller/' . $reseller_id . '/';
    }

    public function __toString()
    {
        return sprintf(
            '[Host: %s], [Token: %s].',
            $this->url,
            $this->token
        );
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    public function getResellerId(): string
    {
        return $this->reseller_id;
    }

}
