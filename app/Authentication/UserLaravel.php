<?php
/**
 * Trida, ktera obsahuje veskere informace o uzivateli, ktere se v ADLDS sleduji.
 * 
 * @version 1.0 
 * @author havlas
 * @created 09-10-2012 13:10:51
 *  
 * @example
 * <pre>
 * <code>
 * $user = new User();
 * echo $user->getWholeName();
 * </code></pre>
 */
namespace App\Authentication;
class UserLaravel
{	
    private $name;
    private $surname;
    private $wholeName;
    private $osc;
    private $departments;
    private $position;
    private $phone;
    private $mail;
    private $manager;
    private $memberOf;
    private $dn;
    private $positionDesc;
    private $roles = array();
    private $samaccountname;
        
    
    /*
     * do usera lze jako druh� parametr poslat pole dat, ze kter�ch se m� na��st.
     * To se pou��v� v p��pad�, �e se u�ivatel ov��uje loginem a heslem a tato metoda
     * rovnou vrac� informace o u�ivateli..
     */
    function __construct($role=null,$aData = null) {
               
        $oAdam = new AdamLaravel();
        if(is_null($aData) && !is_array($aData)) 
        {
            if(isset($_SERVER['AUTH_USER']))
            {
                $userName = $_SERVER['AUTH_USER'];    
                $aData = $oAdam->getUser($userName);
            }
        } else {
            $userName = $aData["samaccountname"];
        }             
        
        //pokud je LDSNAME pr�zdn�, nebudou se na��tat u�ivatelsk� role
        if((config('app.LDSNAME') != "")&&(isset($userName))) {
            $aRoles = $oAdam->getUserRoles($userName);
        } else {
            $aRoles = array();
        }

        /* PH: ošetření pro anonymní přístup, kdy uživatel nejde načíst */
        if($aData) {
            $this->name = $aData["name"];
            $this->surname = $aData["surname"];
            $this->wholeName = $aData["wholeName"];
            $this->osc = $aData["empId"];

            //pole departmentů uživatele ve tvaru [kodDept => nazevDept,kodDept => nazevDept,..]
            $deptFinal = array();
            if (isset($aData['department'])) {
                foreach ($aData['department'] as $index => $deptName) {
                    if (isset($aData["deptCode"][$index])) {
                        $deptFinal[$aData["deptCode"][$index]] = $deptName;
                    }
                }
            }
            $this->departments = $deptFinal;
            $this->position = $aData["position"];
            $this->phone = $aData["phone"];
            $this->mail = $aData["mail"];
            $this->manager = $aData["manager"];
            if (isset($aData["memberof"])) {
                $this->memberOf = $aData["memberof"];
            }
            $this->dn = $aData["dn"];
            $this->positionDesc = $aData["positionDesc"];
        }

        if (is_array($aRoles) && count($aRoles) > 0) {
            $this->roles[config('app.LDSNAME')] = $aRoles;
        } else {
            if (isset ($aData["role"]) && !is_null($aData["role"])) {
                $this->roles[config('app.LDSNAME')] = $aData["role"];
            }
        }

        if (isset($userName)) {
            $this->samaccountname = $userName;
        }

        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function getWholeName() {
        return $this->wholeName;
    }

    public function getOsc() {
        return $this->osc;
    }

    public function getDepartments() {
        return $this->departments;
    }

    public function getPosition() {
        return $this->position;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getMail() {
        return $this->mail;
    }

    public function getManager() {
        return $this->manager;
    }

    public function getMemberOf() {
        return $this->memberOf;
    }

    public function getDn() {
        return $this->dn;
    }

    public function getPositionDesc() {
        return $this->positionDesc;
    }
    
    public function getSamaccountname() {
        return $this->samaccountname;
    }

    public function getRoles() {
        
//        return $this->roles;
        if(isset($this->roles[config('app.LDSNAME')])) {
            return $this->roles[config('app.LDSNAME')];
        } 
        
        return null;
        
    }
    
    
    public function setRoles(array $roles) {
        $this->roles[config('app.LDSNAME')] = $roles;
    }
    
    
    public function downRoles() {
        if(config('app.LDSNAME') != "") {
            $user = unserialize($_SESSION["user"]);
            $userName = $user->getSamaccountname();
            $oAdam = new AdamLaravel();
            $aRoles = $oAdam->getUserRoles($userName);
            if(count($aRoles) > 0) {
                $this->roles[config('app.LDSNAME')] = $aRoles;
                return true;
            } 
        }
        return false;
    }

}
?>