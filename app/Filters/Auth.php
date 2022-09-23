<?php 
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    private $role;
    private $setting;

    public function __construct()
    {
        $this->setting = array(
            'frontend' => array('1','2','3','4'),
            'backend' => array('2','4'),
        );
        
        if(session()->get('isLoggedIn')){
            $this->role = session()->get('role');
        }        
    }

    public function before(RequestInterface $request, $arguments = null)
    {       
        if(!isset($_SESSION['isLoggedIn']) || !session()->get('isLoggedIn')){
            return redirect()->to(base_url('login'));
        } else {
            if(!empty($arguments)){
                if(in_array($arguments[0],array('frontend','backend'))){                     
                    if(!in_array($this->role,$this->setting[$arguments[0]])){  
                        if(count($arguments) == 1)                
                            return redirect()->to(base_url('403'));
                        else {
                            array_shift($arguments);                            
                            if(!in_array($this->role,$arguments))
                                return redirect()->to(base_url('403'));
                        }
                    }     
                } else {
                    if(!in_array($this->role,$arguments))
                        return redirect()->to(base_url('403'));
                }
            }
        }
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}
?>