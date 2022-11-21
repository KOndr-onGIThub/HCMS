<?php
/**
 * Trida pro authentikaci a autorizaci uzivatelu. 
 * Obsahuje metody pro zobrazeni dostupnych udaju o zamestnanci, spravu roli 
 * a pro zmenu oddeleni zamestnance.
 * 
 * <b>Priklad pouziti - nacteni informaci o uzivateli a roli, ktere mu v aplikaci nalezi:</b>
 * <pre><code>
 * $oAdam = new Adam();
 * $userName = $_SERVER['AUTH_USER'];
 * $aData = $oAdam->getUserInfo($userName);
 * $aRoles = $oAdam->getUserRoles($userName);
 * </code></pre>
 *
 * @author Havlas
 */
namespace App\Authentication;
class AdamLaravel {
    
    private $appName;
    private $serverName; 
        
    public function __construct()
    {
        $this->appName = config('app.LDSNAME');
        $environment = config('app.env');        
        if ($environment != "production"){
            $this->serverName = 'http://intranet52';
        }
        else {
            $this->serverName = 'http://intranet02';
        }      
    }

    /**
     * vraci udaje o uzivateli -
     * @param int/string $user - osc(potom metoda je findUserByOsc, jinak loginName a metoda findUser
     * @return array
     */
    public function getUser($user)
    {      
        try {
            $user = str_ireplace("tpca\\", "", $user);
            $user = str_ireplace("common\\", "", $user);
            $uriData = "id/".$user."/app/".$this->appName."/method/findUser/code/".sha1($this->appName);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$this->serverName."/webserv/ldap/public/index/".$uriData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);

            $response = curl_exec($ch);
            curl_close($ch);

            return json_decode($response, true);
        }
        catch (Exception $e)
        {
            if(config('app.APP_ENV') == "production") {
                echo "<div style='font-size: 18px; padding: 50px;font-weight: bold;'>";
                echo "Je nám líto, authorizační služba potřebná pro zobrazení aplikace ".config('app.APP_NAME')."
                    je momentálně nedostupná, kontaktujte prosím IS oddělení!";
                echo "<br /><br />";
                echo "We are sorry. Authorization service is unavailable, but needed for the application, 
                    please contact application admins or IS department!";
                echo "</div>";
                die();
            } else {
                echo $e->getMessage();
                die();
            }     
        }
    }

    /**
     * Metoda, ktera vrati vsechny role uzivatele v aplikaci
     * @param int/string $userName - prihlasovaci jmeno nebo osc
     * @return array
     */
    public function getUserRoles($userName)
    {   
        try {
            if(!is_numeric($userName)) {
                $userName = str_ireplace("tpca\\", "", $userName);
                $userName = str_ireplace("common\\", "", $userName);
            }
            //bez TPCA
            $uriData = "id/".$userName."/app/".$this->appName."/method/findUserRolesInApp/code/".sha1($this->appName);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$this->serverName."/webserv/ldap/public/index/".$uriData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);

            $response = curl_exec($ch);
            curl_close($ch);

            return json_decode($response, true);
        }
        catch (Exception $e)
        {
            if(config('app.APP_ENV') != "production") {
                echo $e->getMessage();
            }      
        }
        
    }

    /**
     * vrati seznam vsech uzivatelu aplikace
     * @return ARRAY
     */
    public function getUsersList() 
    {
        try {
            $uriData = "id/a/app/".$this->appName."/method/findAppUsers/code/".sha1($this->appName);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$this->serverName."/webserv/ldap/public/index/".$uriData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);

            $response = curl_exec($ch);
            curl_close($ch);

            return json_decode($response, true);
        }
        catch (Exception $e)
        {
            if(config('app.APP_ENV') != "production") {
                echo $e->getMessage();
            }      
        }
         
    }


    /**
     * Funkce vrati cleny zadanych roli, kteri splnuji zadana kriteria
     * jako parametr roles ocekava pole s nazvy roli (CN), ve kterych chceme hledat ve formatu [role1, role2,...]
     * jako parametr attr ocekava pole atributu, ktere chceme u roli vratit [attr1,attr2,...]
     * jako parametr memberAttr ocekava pole atributy, podle kterych se ma peefiltrovat skupina mamberu
     * ve formatu ["vlastnost" => "hodnota"] nebo ["vlastnost" => [hodnota1, hodnota2],"vlastnost"=>[]]
     * @param array $aRoles
     * @param array $aRolesParams
     * @param array $aMembersParams
     * @return array -> {[0]=>[object user],[1]=>objectUser,...}
     */
    public function getAppMembersWithParams(array $aRoles, array $aRolesParams, array $aMembersParams) {
     
        try {
            $aParams = [
                'app'               =>  $this->appName,
                'method'            =>  'customMemberFind',
                'code'              =>  sha1($this->appName),
                "roles"             =>  Zend_Json::encode($aRoles),
                "attr"              =>  Zend_Json::encode($aRolesParams),
                "memberAttr"        =>  Zend_Json::encode($aMembersParams),
                "id"                =>  1
            ];
            $params = http_build_query($aParams, null, '&');

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$this->serverName."/webserv/ldap/public/index?".$params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);

            $response = curl_exec($ch);
            curl_close($ch);

            return json_decode($response, true);
        }
        catch (Exception $e)
        {
            if(config('app.APP_ENV') != "production") {
                echo $e->getMessage();
            }      
        }
            
    }


    /**
     * Metoda, ktera overi uzivatele
     * @param type $login - OSC nebo samaccountname
     * @param type $password
     * @return false / UserLaravel
     */
    public function authorizeUser($login, $password) {
        
        try {
            $uriData = "id/1/app/".$this->appName."/method/authorizeUser/code/".sha1($this->appName)."/";
            $uriData .= "login/{$login}/pass/{$password}";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$this->serverName."/webserv/ldap/public/index/".$uriData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);

            $response = json_decode(curl_exec($ch), true);
            curl_close($ch);

            if(is_array($response)) {                
                return new UserLaravel(null, $response);
            } else {
                return false;
            }
        }
        catch (Exception $e)
        {
            if(config('app.APP_ENV') != "production") {
                echo $e->getMessage();
            }      
        }
    }
    
        
}

?>
