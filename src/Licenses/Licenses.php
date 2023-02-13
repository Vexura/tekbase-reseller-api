<?php


namespace TekBaseAPI\Licenses;

use TekBaseAPI\TekBaseAPI;

class Licenses
{
    private $TekBaseAPI;

    public function __construct(TekBaseAPI $TekBaseAPI)
    {
        $this->TekBaseAPI = $TekBaseAPI;
    }

    /**
     * @return array|string
     */
    public function count()
    {
        return $this->TekBaseAPI->get('count/');
    }

    /**
     * @return array|string
     */
    public function getLicenses()
    {
        return $this->TekBaseAPI->get('/');
    }

    /**
     * @return array|string
     */
    public function getLicense(int $id)
    {
        return $this->TekBaseAPI->get($id.'/');
    }

    /**
     * @param int $id LicenseID
     * @param int $version 7 = TekBase 7.x / 8 = TekBase 8.x
     * @return array|string
     */
    public function getLicenseKey(int $id, int $version)
    {
        return $this->TekBaseAPI->get($id.'/'.$version);
    }


    /**
     * @param string $username The name was assigned by the reseller. (max. 20 characters)
     * @param string $siteIP The IP address of the server where the license was installed.
     * @param string $siteUrl The IP address or domain where the license was installed.
     * @param string $sitePath Name of the directory where the license was installed.
     * @param string $version TekBASE version (lite = Lite, privat = privat, std = business, adv = business + billing)
     * @param bool $cms This indicates whether the cms is available. (0 = no, 1 = yes)
     * @param bool $shop This indicates whether the shop is available (The shop needs the CMS). (0 = no, 1 = yes)
     * @param int $gwislots Here you can see how many gameservers can be managed. (e.g. 0, 10, 20, 50, 100, 200, 500, 999999)
     * @param int $rwislots Here you can see how many customer server/vserver can be managed. (e.g. 0, 10, 20, 50, 100, 200, 500, 999999)
     * @param int $swislots Here you can see how many streamervers can be managed. (e.g. 0, 10, 20, 50, 100, 200, 500, 999999)
     * @param int $vwislots Here you can see how many voiceservers can be managed. (e.g. 0, 10, 20, 50, 100, 200, 500, 999999)
     * @param bool $purchase Specifies whether the version is a rental or purchase version. (0 = rental, 1 = purchase)
     * @return array|string
     */
    public function createLicense(string $username, string $siteIP, string $siteUrl, string $sitePath, string $version, bool $cms, bool $shop, int $gwislots, int $rwislots, int $swislots, int $vwislots, bool $purchase)
    {
        return $this->TekBaseAPI->post('/', [
            'customer' => $username,
            'siteip' => $siteIP,
            'siteurl' => $siteUrl,
            'sitepath' => $sitePath,
            'version' => $version,
            'cms' => $cms,
            'shop' => $shop,
            'gwislots' => $gwislots,
            'rwislots' => $rwislots,
            'swislots' => $swislots,
            'vwislots' => $vwislots,
            'type' => $purchase
        ]);
    }
 
    /**
     * @param int $id License ID
     * @param string $username The name was assigned by the reseller. (max. 20 characters)
     * @param string $siteIP The IP address of the server where the license was installed.
     * @param string $siteUrl The IP address or domain where the license was installed.
     * @param string $sitePath Name of the directory where the license was installed.
     * @param string $version TekBASE version (lite = Lite, privat = privat, std = business, adv = business + billing)
     * @param bool $cms This indicates whether the cms is available. (0 = no, 1 = yes)
     * @param bool $shop This indicates whether the shop is available (The shop needs the CMS). (0 = no, 1 = yes)
     * @param int $gwislots Here you can see how many gameservers can be managed. (e.g. 0, 10, 20, 50, 100, 200, 500, 999999)
     * @param int $rwislots Here you can see how many customer server/vserver can be managed. (e.g. 0, 10, 20, 50, 100, 200, 500, 999999)
     * @param int $swislots Here you can see how many streamervers can be managed. (e.g. 0, 10, 20, 50, 100, 200, 500, 999999)
     * @param int $vwislots Here you can see how many voiceservers can be managed. (e.g. 0, 10, 20, 50, 100, 200, 500, 999999)
     * @param bool $purchase Specifies whether the version is a rental or purchase version. (0 = rental, 1 = purchase)
     * @return array|string
     */
    public function updateLicense(int $id, string $username, string $siteIP, string $siteUrl, string $sitePath, string $version, bool $cms, bool $shop, int $gwislots, int $rwislots, int $swislots, int $vwislots, bool $purchase)
    {
        return $this->TekBaseAPI->put('/' . $id, [
            'customer' => $username,
            'siteip' => $siteIP,
            'siteurl' => $siteUrl,
            'sitepath' => $sitePath,
            'version' => $version,
            'cms' => $cms,
            'shop' => $shop,
            'gwislots' => $gwislots,
            'rwislots' => $rwislots,
            'swislots' => $swislots,
            'vwislots' => $vwislots,
            'type' => $purchase
        ]);
    }


    /**
     * @param int $id License ID
     * @return array|string
     */
    public function delete(int $id){
        return $this->TekBaseAPI->delete('/' . $id);
    }

}