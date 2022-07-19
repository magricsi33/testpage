<?php

use System\Classes\PluginManager;
use System\Classes\UpdateManager;
use System\Classes\VersionManager;
use LivestudioDev\Lscore\Models\Sitemap;

Route::get('api/livestudio', function() {

    $pmanager = PluginManager::instance();
    $umanager = UpdateManager::instance();
    $vmanager = VersionManager::instance();

    $pluginid = "Livestudio.Lscore";

    $returninfo = [];
    /* Functionlist
    // PLUGIN MANAGER
    $test = $pmanager->getPluginNamespaces(); // Vissza adja a pluginok elérési helyét Class ügyileg
    $test = $pmanager->getPlugins(); // Vissza adja a pluginokat basic infokkal
    $test = $pmanager->exists("Livestudio.Lscore"); // Megnézi hogy létezik-e az adott plugin és ha igen akkor be van-e kapcsolva. RETURN : BOOLEAN
    //$test = $pmanager->getIdentifier( PLUGIN CLASS OBJECT ) // Vissza adja az id-jét object alapján egy pluginnak.
    $test = $pmanager->getVendorAndPluginNames();// Vissza adja ugyanúgy ez alérési helyeket csak absolute path-ban a plugin tulajával együtt. 2D array.
    $test = $pmanager->hasPlugin($pluginid); // Megnézi hogy fel van-e telepítve egy adott plugin, namespace alapján, return boolean

    // UPDATE MANAGER
    $test = $umanager->requestChangelog(); // OctoberCms Update Changelog.
    $test = $umanager->update(); // updatel, pontos info nincs mivel gondolom ha nincs update akkor adja vissza az üres objectet

    // VERSION MANAGER
    $test = $vmanager->getNotes(); // Az utolsó update / install vagy bármilyen task return stringje. Ha az update lefutott és nem volt mit updatelni akkor "Nothing to update." lesz pl.
    $test = $vmanager->listNewVersions($pluginid); // Listázza az új updateket egy adott pluginnak (Plugin Namespace [Author.Plugin pl.: Livestudio.Lscore])
    */
    $returninfo["plugins"] = $pmanager->getPlugins();
    $returninfo["pluginNamespaces"] = $pmanager->getPluginNamespaces();
    $returninfo["pluginAbsolute"] = $pmanager->getVendorAndPluginNames();
    $returninfo["changelog"] = $umanager->requestChangelog();
    $returninfo["lastOctoberTask"] = $vmanager->getNotes();

    return json_encode($returninfo,true);
});

Route::get("ls/sitemap.xml", function() {
    return Sitemap::getLatestXml();
});

?>
