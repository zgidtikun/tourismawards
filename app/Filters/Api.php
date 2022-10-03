<?php 
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Api implements FilterInterface
{
    private $role;
    private $setting;

    public function __construct()
    {
        $this->setting = array(
            'frontend' => array('1','3'),
            'backend' => array('2','4'),
        );
        
        if(session()->get('isLoggedIn')){
            $this->role = session()->get('role');
        }        
    }

    public function before(RequestInterface $request, $arguments = null)
    {
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {       
        if(!session()->has('isLoggedIn') || !session()->get('isLoggedIn')){
            return $response->setJSON(['stats' => 'error', 'result' => 'error_login', 'title' => 'เข้าสู่ระบบผิดพลาด', 'text' => 'เวลาในการเข้าสู่ระบบหมดแล้วกรุณาเข้าสู่ระบบอีกครั้ง']);
        } else {
            if(!empty($arguments)){
                if(in_array($arguments[0],array('frontend','backend'))){                     
                    if(!in_array($this->role,$this->setting[$arguments[0]])){  
                        if(count($arguments) == 1)                
                            return $response->setJSON(['stats' => 'error', 'result' => 'Access_Denied']);
                        else {
                            array_shift($arguments);                            
                            if(!in_array($this->role,$arguments))
                                return $response->setJSON(['stats' => 'error', 'result' => 'Access_Denied']);
                        }
                    }     
                } else {
                    if(!in_array($this->role,$arguments))
                        return $response->setJSON(['stats' => 'error', 'result' => 'Access_Denied']);
                }
            }
        }
        
    }
}
