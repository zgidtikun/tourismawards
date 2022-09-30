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
            'frontend' => array('1','3'),
            'backend' => array('2','4')
        );
        
        if(session()->get('isLoggedIn')){
            $this->role = session()->get('role');
        }        
    }

    public function before(RequestInterface $request, $arguments = null)
    {       
        if(!session()->has('isLoggedIn') || !session()->get('isLoggedIn')){
            return redirect()->to($this->getUrl($arguments));
        } else {
            if(!empty($arguments)){
                if(in_array($arguments[0],array('frontend','backend'))){                     
                    if(!in_array($this->role,$this->setting[$arguments[0]])){  
                        if(count($arguments) == 1)                
                            return redirect()->to($this->getUrl('403'));
                        else {
                            array_shift($arguments);                            
                            if(!in_array($this->role,$arguments))
                                return redirect()->to($this->getUrl('403'));
                        }
                    }     
                } else {
                    if(!in_array($this->role,$arguments))
                        return redirect()->to($this->getUrl('403'));
                }
            }
        }
    }

    private function getUrl($arg)
    {
        if(!empty($arg)){
            if(is_array($arg)){
                if(in_array($arg[0],array('frontend','1','3')))
                    return base_url('login/forntend');
                elseif(in_array($arg[0],array('backend','2','4')))
                    return base_url('backend/login');
                else return base_url('login');
            } else return base_url($arg);
        } else return base_url('login');
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}
