<?php 

namespace App\Model;

use App\Http\Middleware\CASAuth;

class Ldap
{
	protected $cfg 	= array("ldap_host"=>"aplikasi.bumn.go.id",
				"ldap_baseDN" => "cn=people,dc=bumn,dc=go,dc=id",
				"ldap_manager_user" => "cn=root,dc=bumn,dc=go,dc=id",
				"ldap_manager_pwd" => "admin"
				);
    
    protected $ldapconn;
    
    public function __construct()
    {
        $this->ldapconn = $this->ldapconn();
    }
    
    private function ldapconn()
    {
        $ldapconn 	= ldap_connect($this->cfg['ldap_host']) or die("Could not connect to " . $this->cfg['ldap_host']);
        $root 		= $this->cfg['ldap_manager_user'];
        $rootPwd 	= $this->cfg['ldap_manager_pwd'];
        
        ldap_bind($ldapconn, $root, $rootPwd);
        return $ldapconn;
    }
    
    public function cariUserNonJDIH($keyword)
    {
        if (!empty($keyword)){
            $pid = 'jdih';
            $level = 'us';
//            $user = \Auth::user()->username;
            $user = cas()->user();
    		$ldapFilterAttributes = array();
    		$ldapSortAttributes = array('ou', 'cn');
    		$ouFilter = array('ou');
    		$op = ldap_search($this->ldapconn, $this->cfg['ldap_baseDN'], "cn=$user", $ouFilter);
    		$ouUserId = ldap_get_entries($this->ldapconn, $op);
    		$search ="(&(cn=*$keyword*)(ou=". strtolower($ouUserId[0]['ou'][0]) . ")(employeetype=$level)(!(businessCategory=$pid)))";
            $sr=ldap_search($this->ldapconn, $this->cfg['ldap_baseDN'], $search, $ldapFilterAttributes);
    		foreach ($ldapSortAttributes as $eachSortAttribute) {
    			ldap_sort($this->ldapconn, $sr, $eachSortAttribute);
    		}
    		$info = ldap_get_entries($this->ldapconn, $sr);
            return $info;
        }else{
            return false;
        }
    }
    
    public function cariUserJDIH($keyword)
    {
        if (!empty($keyword)){
            $pid = 'jdih';
            $level = 'us';
//            $user = \Auth::user()->username;
            $user = cas()->user();
    		$ldapFilterAttributes = array();
    		$ldapSortAttributes = array('ou', 'cn');
    		$ouFilter = array('ou');
    		$op = ldap_search($this->ldapconn, $this->cfg['ldap_baseDN'], "cn=$user", $ouFilter);
    		$ouUserId = ldap_get_entries($this->ldapconn, $op);
    		$search ="(&(cn=*$keyword*)(ou=". strtolower($ouUserId[0]['ou'][0]) . ")(employeetype=$level)(businessCategory=$pid))";
            $sr=ldap_search($this->ldapconn, $this->cfg['ldap_baseDN'], $search, $ldapFilterAttributes);
    		foreach ($ldapSortAttributes as $eachSortAttribute) {
    			ldap_sort($this->ldapconn, $sr, $eachSortAttribute);
    		}
    		$info = ldap_get_entries($this->ldapconn, $sr);
            return $info;
        }else{
            return false;
        }
    }
    
    public function addNewUser($username, $password, $level, $portal, $bumn_id, $emp_id, $email, $phone = null, $dp_no = null, $fullname)
    {
        
		$info["cn"] 			= $username;
		$info["businesscategory"] 		= $portal;
		$info["uid"] 		= $username;
		$info["sn"] 		= $fullname;

		$pwd_md5 = base64_encode(pack("H*", md5($password)));

		$info["userpassword"] 	= "{MD5}".$pwd_md5;

		$info["objectclass"] 	= "inetOrgPerson";
		$info["employeetype"]	= $level;	
		$info["ou"] = $bumn_id;
		$info["employeeNumber"] = $emp_id;
		$info["mail"]		= $email;


		//var_dump($info);die();
		if(@ldap_add($this->ldapconn, "cn=$username, ". $this->cfg['ldap_baseDN'] , $info)){
			$status = true;
			$msg	= "Sukses Menambahkan User";
		}else if(ldap_errno($this->ldapconn) == 68){
			$status = false;
			$msg 	= "Username sudah ada";
		}else{
			$status = false;
			$msg = "Error: " . ldap_error($this->ldapconn);
		}
		ldap_close($this->ldapconn);
        return $status;
    }
    
    public function addPortal($username, $portal)
    {
		$justthese  = array();
		$search = "cn=$username";

		$sr=ldap_search($this->ldapconn, $this->cfg['ldap_baseDN'], $search, $justthese  );  
		$info = ldap_get_entries($this->ldapconn, $sr);
        
		$userPortals = $info[0]["businesscategory"];
		$status = false;
		if(!in_array($portal, $userPortals)){
			for($i = 0; $i<$userPortals["count"];$i++){
				if($userPortals[$i] != 'na'){
				$portals["businesscategory"][] = $userPortals[$i];
				}
			}
			$portals["businesscategory"][] = $portal;
				
			if(ldap_modify($this->ldapconn, "cn=$username, ". $this->cfg['ldap_baseDN'], $portals)){
				$status = true;
				$msg	= "Sukses menambah hak akses portal $portal kepada $username";
			}else{
				$status = false;
				$msg	= ldap_error($this->ldapconn);
			}
		}
        return $status;
    }
    
    public function removePortal($username, $portal)
    {
		$justthese  = array();
		$search = "cn=$username";

		$sr=ldap_search($this->ldapconn, $this->cfg['ldap_baseDN'], $search, $justthese  );  
		$info = ldap_get_entries($this->ldapconn, $sr);
        
		$userPortals = $info[0]["businesscategory"];
		$status = false;
		if(in_array($portal, $userPortals)){
			if($info[0]["businesscategory"]["count"] == 1 && $info[0]["businesscategory"][0] == $portal){
				$new["businesscategory"][] = "na";
				$new["userpassword"] = array();
			}else{
				for($i=0;$i<$info[0]["businesscategory"]["count"];$i++){
					if($info[0]["businesscategory"][$i] != $portal){
						$new["businesscategory"][] = $info[0]["businesscategory"][$i];
					}
				}	
			}
				
			if(ldap_modify($this->ldapconn, "cn=$username, ". $this->cfg['ldap_baseDN'], $new)){
				$status = true;
				$msg	= "Sukses menghapus hak akses portal $portal kepada $username";
			}else{
				$status = false;
				$msg	= ldap_error($this->ldapconn);
			}
		}
        return $status;
    }
    
    public function changePassword($username, $newpwd)
    {
		$justthese  = array();
		$search = "cn=$username";

		$sr=ldap_search($this->ldapconn, $this->cfg['ldap_baseDN'], $search, $justthese  );  
		$info = ldap_get_entries($this->ldapconn, $sr);
		$newpwd ="{MD5}".base64_encode(pack("H*", md5($newpwd)));
		$new["userpassword"][] = $newpwd;
				
		if(ldap_modify($this->ldapconn, "cn=$username, ". $this->cfg['ldap_baseDN'], $new)){
			$status = true;
			$msg	= "Sukses ubah password";
		}else{
			$status = false;
			$msg	= ldap_error($this->ldapconn);
		}
        return $status;
    }
}