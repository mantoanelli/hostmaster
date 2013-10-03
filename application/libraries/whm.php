<?PHP 
/**
 * WHM Class - Working with WHM
 * NOTE: Requires PHP version 5 or later
 * @package WHM
 * @author Davood Jafari
 * @copyright 2011 Davood Jafari
 * @version $Id: whm.class.php 1.0.0 2011-02-02 08:53:00$
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */
 
class WHM
{
	private $HOST = '';
	private $USER = '';
	private $PASS = '';
	private $HASH = '';
	
	/*
	* Constructor
	* @param boolean $SSL, if your whm is on ssl ( https ) true else ( http ) false
	* @param string $IP, You whm ip
	* @param string $HASH, if $HASH_IS_PASS is true this is whm password else you must get a hash string from whm and put it on $HASH
	* @param boolean $HASH_IS_PASS
	* RETURN true
	*/
	public function __construct( $SSL , $IP , $USER , $HASH , $HASH_IS_PASS = true )
	{
		$HOST = ( $SSL ) ? ( 'https://' . $IP . ':2087' ) : ( 'http://' . $IP . ':2086' );
		$this->HOST = $HOST;
		$this->USER = $USER;
		
		if( $HASH_IS_PASS  )
		{
			$this->PASS = $HASH;
		} else
		{
			$this->HASH = $HASH;
		}
		return true;
	}
	
	/*
	* open
	* @param string $page, url of function of json whm api
	* RETURN string, Result of function if successfull, else boolean false
	*/
	private function open( $page )
	{
		$curl = curl_init();
		$url = $this->HOST . '/json-api/' . $page;
		curl_setopt( $curl , CURLOPT_SSL_VERIFYHOST , 0 ); 
		curl_setopt( $curl , CURLOPT_SSL_VERIFYPEER , 0 );
		curl_setopt( $curl , CURLOPT_RETURNTRANSFER , 1 );  
		if( empty( $this->HASH ) )
		{
			$header[0] = 'Authorization: Basic ' . base64_encode( $this->USER . ':' . $this->PASS );
		} else
		{
			$header[0] = 'Authorization: WHM ' . $this->USER . ":" . $this->HASH;
		}
		curl_setopt( $curl , CURLOPT_URL , $url );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER , 1 );
		curl_setopt( $curl, CURLOPT_HTTPHEADER , $header );
		$data = curl_exec( $curl ); 
		if( $data  == false )
		{
			return false;
		}
		return $data;
	}
	
	/*
	* get_size : convert megabyte integer to another format
	* @param integer $mbytes
	* RETURN string Formated size
	*/
	private function get_size( $mbytes )
	{
		if( is_numeric( $mbytes ) )
		{
			if( $mbytes >= 10485764 )
			{
				$size = round( $mbytes / 10485764 , 2 ) . ' TB';
			} else
			if( $mbytes >= 1024 )
			{
				$size = round( $mbytes / 1024 , 2 ) . ' GB';
			} else
			{
				$size = $mbytes . ' MB';
			}
		} else
		{
			$size = 'Unknown';
		}
		return $size;
	}
	
	/*
	* getResult : analyse result of open function when a result index exist in rersult
	* @param string $data
	* RETURN array string object of result
	*/
	public function getResult( $data )
	{
		$object = json_decode( $data );
		return $object->result[0];
	}
	
	/*
	* getResult2 : analyse result of open function
	* @param string $data
	* RETURN array string object of result
	*/
	public function getResult2( $data )
	{
		return json_decode( $data );
	}
	
	/*
	* make_random_password : Make random password
	* @param integer $length
	* RETURN string
	*/
	private function make_random_password( $length = 12 )
	{
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890!$()|';
		$chars_length = ( strlen( $chars ) - 1 );
		$string = $chars{ mt_rand( 0 , $chars_length ) };
	   
		for( $i = 1; $i < $length; $i = strlen( $string ) )
		{
			$r = $chars{ mt_rand( 0 , $chars_length ) };
			if( $r != $string{ $i - 1 } ) $string .= $r;
		}
		return $string;
	}
	
	/*
	* create_account : Create new account
	* @param string $domain : account domain
	* @param string $username : account username
	* @param string $password : account password can be empty, if empty create a random password
	* @param string $email : account email
	* @param string $package : account package
	* RETURN : if account successfully created return array string of created account info, else return string of error
	*/
	public function create_account( $domain , $username , $password , $email , $package )
	{
		$password = ( empty( $password ) ? $this->make_random_password() : $password );
		
		$d = $this->open( 'createacct?domain=' . $domain . '&username=' . $username . '&useregns=0&reseller=0&ip=n&contactemail=' . $email . '&plan=' . $package . '&password=' . $password );
		$res = $this->getResult( $d );
		
		if( $res->status == 0 )
		{
			return $res->statusmsg;
		} else
		{
			$accinfo = '';
			if( preg_match_all( '/<pre>(.*)<\/pre>/siU' , $res->rawout , $n ) )
			{
				$accinfo = $n[0][1];
			}
			$result = array();
			$result['domain'] = $domain;
			$result['username'] = $username;
			$result['password'] = $password;
			$result['package'] = $package;
			$result['nameserver1'] = $res->options->nameserver;
			$result['nameserver2'] = $res->options->nameserver2;
			$result['nameserver3'] = $res->options->nameserver3;
			$result['nameserver4'] = $res->options->nameserver4;
			$result['account_info'] = $accinfo;
			return $result;
		}
	}
	
	/*
	* delete_account : Delete existing account
	* @param string $username : account username that you want deleted
	* RETURN array sting that index 0 is ture is successfull, else false and index 1 is error or successfull message
	*/
	public function delete_account( $username )
	{
		$d = $this->open( 'removeacct?user=' . $username );
		$res = $this->getResult( $d );
		
		$out = array();
		if( $res->status == 0 )
		{
			$out[0] = false;
			$out[1] = $res->statusmsg;
		} else
		{
			$out[0] = true;
			$out[1] = $res->statusmsg;
		}
		return $out;
	}
	
	/*
	* suspend_account : Suspend existing account
	* @param string $username : account username that you want suspened
	* @param string $reson : suspened reson that can be empty
	* RETURN array sting that index 0 is ture is successfull, else false and index 1 is error or successfull message
	*/
	public function suspend_account( $username , $reson = '' )
	{
		$d = $this->open( 'suspendacct?user=' . $username . '&reson=' . $reson );
		$res = $this->getResult( $d );
		
		$out = array();
		if( $res->status == 0 )
		{
			$out[0] = false;
			$out[1] = $res->statusmsg;
		} else
		{
			$out[0] = true;
			$out[1] = $res->statusmsg;
		}
		return $out;
	}
	
	/*
	* unsuspend_account : Unsuspend suspened account
	* @param string $username : account username that you want unsuspened
	* RETURN array sting that index 0 is ture is successfull, else false and index 1 is error or successfull message
	*/
	public function unsuspend_account( $username )
	{
		$d = $this->open( 'unsuspendacct?user=' . $username );
		$res = $this->getResult( $d );
		
		$out = array();
		if( $res->status == 0 )
		{
			$out[0] = false;
			$out[1] = $res->statusmsg;
		} else
		{
			$out[0] = true;
			$out[1] = $res->statusmsg;
		}
		return $out;
	}
	
	/*
	* change_password_account : Unsuspend suspened account
	* @param string $username : account username that you want changed password
	* @param string $username : new password can be empty, if empty create a random password
	* RETURN array sting that index 0 is ture is successfull, else false and index 1 is error or successfull message, index 2 is your password or random password
	*/
	public function change_password_account( $username , $password = '' )
	{
		$password = ( empty( $password ) ? $this->make_random_password() : $password );
		
		$d = $this->open( 'passwd?user=' . $username . '&pass=' . $password );
		$res = $this->getResult2( $d );
		$res = $res->passwd[0];
                //debug($res);
		$out = array();
		if( $res->status == 0 )
		{
			$out['status'] = 0;
			$out['statusmsg'] = $res->statusmsg;
			$out['pass'] = '';
		} else
		{
			$out['status'] = 1;
			$out['statusmsg'] = $res->statusmsg;
			$out['pass'] = $password;
		}
		return $out;
	}
	
	/*
	* list_accounts : List all your created account
	* @param string $search_type : seatch type of search in accounts, can be a one of ( domain | user | ip | package ), can be empty to list all
	* @param string $search_word : search keyword, can be empty to list all
	* RETURN array sting that is information of searched in account lists
	*/
	public function list_accounts( $search_type = '' , $search_word = '' )
	{
		$allow_search_type = array( 'domain' , 'user' , 'ip' , 'package' );
		
		if( ( $search_type != '' ) && ( in_array( $search_type , $allow_search_type ) ) )
		{
			$url = 'listaccts?searchtype=' . $search_type . '&search=' . $search_word;
		} else
		{
			$url = 'listaccts';
		}
		
		$d = $this->open( $url );
		
		$res = $this->getResult2( $d );
		$acc = $res->acct;
		if(count($acc) > 0)
                    return $acc;
                else 
                    return false;
                
	}
	
	/*
	* search_account_by_package : Search account by package
	* @param string $package : Package keyword that you want find accounts that package equal it
	* RETURN array sting that is information of searched in account lists
	*/
	public function search_account_by_package( $package )
	{
		return $this->list_accounts( 'package' , $package );
	}
	
	/*
	* search_account_by_domain : Search account by domain
	* @param string $domain : Domain keyword that you want find accounts that domain equal it
	* RETURN array sting that is information of searched in account lists
	*/
	public function search_account_by_domain( $domain )
	{
		return $this->list_accounts( 'domain' , $domain );
	}
	
	/*
	* search_account_by_ip : Search account by ip
	* @param string $ip : IP keyword that you want find accounts that ip equal it
	* RETURN array sting that is information of searched in account lists
	*/
	public function search_account_by_ip( $ip )
	{
		return $this->list_accounts( 'ip' , $ip );
	}
	
	/*
	* search_account_by_user : Search account by user
	* @param string $ip : user keyword that you want find accounts that user equal it
	* RETURN array sting that is information of searched in account lists
	*/
	public function search_account_by_user( $user )
	{
		return $this->list_accounts( 'user' , $user );
	}
	
	/*
	* limit_user_bandwidth : Change limit of user bandwidth
	* @param string $username : account username that you want change bandwith limit
	* @param integer $new_bandwidth : enter new bandwith limit ( to megabyte )
	* RETURN array sting that is information of searched in account lists
	*/
	public function limit_user_bandwidth( $username , $new_bandwidth )
	{
		$d = $this->open( 'limitbw?user=' . $username . '&bwlimit=' . $new_bandwidth );
		$res = $this->getResult( $d );
		
		$out = array();
		if( $res->status == 0 )
		{
			$out[0] = false;
			$out[1] = $res->statusmsg;
			$out[2] = '';
		} else
		{
			$out[0] = true;
			$out[1] = $res->statusmsg;
			$out[2] = $res->bwlimit->human_bwused;
		}
		return $out;
	}
	
	/*
	* list_packages : List all aded package
	* RETURN array sting that is information of all packages
	*/
	public function list_packages()
	{
		$d = $this->open( 'listpkgs' );
		$res = $this->getResult2( $d );
		$pkg = $res->package;
		
		$out = array();
		$i = 0;
		foreach( $pkg as $pk )
		{
			$out[$i]['name'] = $pk->name;
			$out[$i]['bandwidth'] = ( $pk->BWLIMIT == 'unlimited' ) ? 'unlimited' : $this->get_size( $pk->BWLIMIT );
			$out[$i]['quota'] = ( $pk->QUOTA == 'unlimited' ) ? 'unlimited' : $this->get_size( $pk->QUOTA );
			$out[$i]['sql'] = $pk->MAXSQL;
			$out[$i]['sub'] = $pk->MAXSUB;
			$out[$i]['park'] = $pk->MAXPARK;
			$out[$i]['addon'] = $pk->MAXADDON;
			$out[$i]['ftp'] = $pk->MAXFTP;
			$out[$i]['pop'] = $pk->MAXPOP;
			$out[$i]['list'] = $pk->MAXLST;
			$out[$i]['ip'] = $pk->IP;
			
			$i++;
		}
		return $out;
	}
	
	/*
	* add_package : Add new package
	* @param string $name : package name
	* @param integer $quota : package disk quota limit to kilobyte
	* @param integer $bandwidth : package bandwidth limit to kilobyte
	* @param integer $subdomain : package subdomain limit
	* @param integer $park : package park limit
	* @param integer $addon : package addon domain limit
	* @param integer $ftp : package ftp account limit
	* @param integer $pop : package pop3 email account limit
	* @param integer $list : package email list limit
	* @param integer $sql : package sql database
	* @param string $feature : package feturelist name
	* @param boolean $ip : package had dedicated ip or no
	* @param boolean $cgi : package eanbled cgi or no
	* @param boolean $fronpage : package eanbled fronpage or no
	* @param string $lang : package language, default value is "en" and can be empty
	* @param string $theme : package theme, default value is "x3" and can be empty
	* @param boolean $shell : package access to shell or no
	* RETURN array sting that index 0 is ture is successfull, else false and index 1 is error or successfull message
	*/
	public function add_package( $name , $quota , $bandwidth , $subdomain , $park , $addon , $ftp , $pop , $list , $sql , $feature = 'default' , $ip = 0 , $cgi = 0 , $fronpage = 0 , $lang = 'en' , $theme = 'x3' , $shell = 0 )
	{
		$d = $this->open( 'addpkg?name=' . $name . '&quota=' . $quota . '&bwlimit=' . $bandwidth . '&maxpark=' . $park . '&maxsub=' . $subdomain . '&maxaddon=' . $addon . '&maxpop=' . $pop . '&maxftp=' . $ftp . '&maxlists=' . $list . '&maxsql=' . $sql . '&featurelist=' . $feature . '&ip=' . $ip . '&cgi=' . $cgi . '&frontpage=' . $fronpage . '&language=' . $lang . '&cpmod=' . $theme . '&hasshell=' . $shell );
		$res = $this->getResult( $d );
		
		$out = array();
		if( $res->status == 0 )
		{
			$out[0] = false;
			$out[1] = $res->statusmsg;
		} else
		{
			$out[0] = true;
			$out[1] = $res->statusmsg;
		}
		return $out;
	}
	
	/*
	* add_package : Edit package
	* @param string $name : package name that you want edit it
	* @param integer $quota : package disk quota limit to kilobyte
	* @param integer $bandwidth : package bandwidth limit to kilobyte
	* @param integer $subdomain : package subdomain limit
	* @param integer $park : package park limit
	* @param integer $addon : package addon domain limit
	* @param integer $ftp : package ftp account limit
	* @param integer $pop : package pop3 email account limit
	* @param integer $list : package email list limit
	* @param integer $sql : package sql database
	* @param string $feature : package feturelist name
	* @param boolean $ip : package had dedicated ip or no
	* @param boolean $cgi : package eanbled cgi or no
	* @param boolean $fronpage : package eanbled fronpage or no
	* @param string $lang : package language, default value is "en" and can be empty
	* @param string $theme : package theme, default value is "x3" and can be empty
	* @param boolean $shell : package access to shell or no
	* RETURN array sting that index 0 is ture is successfull, else false and index 1 is error or successfull message
	*/
	public function edit_package( $name , $quota , $bandwidth , $subdomain , $park , $addon , $ftp , $pop , $list , $sql , $feature = 'default' , $ip = 0 , $cgi = 0 , $fronpage = 0 , $lang = 'en' , $theme = 'x3' , $shell = 0 )
	{
		$d = $this->open( 'editpkg?name=' . $name . '&quota=' . $quota . '&bwlimit=' . $bandwidth . '&maxpark=' . $park . '&maxsub=' . $subdomain . '&maxaddon=' . $addon . '&maxpop=' . $pop . '&maxftp=' . $ftp . '&maxlists=' . $list . '&maxsql=' . $sql . '&featurelist=' . $feature . '&ip=' . $ip . '&cgi=' . $cgi . '&frontpage=' . $fronpage . '&language=' . $lang . '&cpmod=' . $theme . '&hasshell=' . $shell );
		$res = $this->getResult( $d );
		
		$out = array();
		if( $res->status == 0 )
		{
			$out[0] = false;
			$out[1] = $res->statusmsg;
		} else
		{
			$out[0] = true;
			$out[1] = $res->statusmsg;
		}
		return $out;
	}
	
	/*
	* delete_package : Edit package
	* @param string $name : package name that you want delete it
	* RETURN array sting that index 0 is ture is successfull, else false and index 1 is error or successfull message
	*/
	public function delete_package( $name )
	{
		$d = $this->open( 'killpkg?pkg=' . $name );
		$res = $this->getResult( $d );
		
		$out = array();
		if( $res->status == 0 )
		{
			$out[0] = false;
			$out[1] = $res->statusmsg;
		} else
		{
			$out[0] = true;
			$out[1] = $res->statusmsg;
		}
		return $out;
	}
	
	/*
	* show_load_avg : Show load average
	* RETURN array sting, 0 : now load avg, 1 : 5 min ago, 2 : 15 min ago
	*/
	public function show_load_avg()
	{
		$d = $this->open( 'loadavg' );
		$res = $this->getResult2( $d );
		
		$out = array();
		$out['now'] = $res->one;
		$out['5min'] = $res->five;
		$out['15min'] = $res->fifteen;
		return $out;
	}
	
	/*
	* get_host_name : Get host name
	* RETURN sting
	*/
	public function get_host_name()
	{
		$d = $this->open( 'gethostname' );
		$res = $this->getResult2( $d );
		return $res->hostname;
	}
        
        public function change_package ($user,$plan){;
            $d = $this->open( 'changepackage?user='.$user.'&pkg=' . $plan );
            $res = $this->getResult2($d);
            return $res;
        }
}
?>