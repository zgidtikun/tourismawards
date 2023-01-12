<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;
use App\Validation\CustomRules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        CustomRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    public $signin = [
        'username' => [
            'rules' => 'required|safe_input',
            'errors' => [
                'required' => 'Username require!',
                'safe_input' => 'Programming Found!',
            ]
        ],
        'password' => [
            'rules' => 'required|safe_input',
            'errors' => [
                'required' => 'Username require!',
                'safe_input' => 'Programming Found!',
            ]
        ],
    ];

    public $signup = [
        'name' => [
            'rules' => 'required|special_str|safe_input',
            'errors' => [
                'required' => 'กรุณาระบุชื่อ',
                'special_str' => 'ชื่อห้ามมีอักขระพิเศษ',
                'safe_input' => 'Programming Found!',
            ]
        ],
        'surname' => [
            'rules' => 'required|special_str|safe_input',
            'errors' => [
                'required' => 'กรุณาระบุนามสกุล',
                'special_str' => 'นามสกุลห้ามมีอักขระพิเศษ',
                'safe_input' => 'Programming Found!',
            ]
        ],
        'telephone' => [
            'rules' => 'required|max_length[10]|safe_input',
            'errors' => [
                'required' => 'กรุณาระบุเบอร์โทรศัพท์',
                'max_length' => 'เบอร์โทรศัพท์ต้องไม่เกิน 10 ตัวอักษร',
                'safe_input' => 'Programming Found!',
            ]
        ],
        'email' => [
            'rules' => 'required|valid_email|unique_email[email,role]|safe_input',
            'errors' => [
                'required' => 'กรุณาระบุอีเมล',
                'valid_email' => 'รูปแบบอีเมลไม่ถูกต้อง',
                'unique_email' => 'อีเมลนี้มีอยู่แล้ว',
                'safe_input' => 'Programming Found!',
            ]
        ],
        'confirmemail' => [
            'rules' => 'required|matches[email]|safe_input',
            'errors' => [
                'required' => 'กรุณายืนยันอีเมล',               
                'matches' => 'การยืนยันอีเมลไม่ตรงกัน',
                'safe_input' => 'Programming Found!',
            ]
        ],
        'password' => [
            'rules' => 'required|min_length[6]|password_format[password]|safe_input',
            'errors' => [
                'required' => 'กรุณาระบุรหัสผ่าน',
                'min_length' => 'รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร',
                'password_format' => 'รหัสผ่านต้องมี A-Z, a-z, 0-9',
                'safe_input' => 'Programming Found!',
            ]
        ],
        'confirmpass' => [
            'rules' => 'required|matches[password]|safe_input',
            'errors' => [
                'required' => 'กรุณายืนยันรหัสผ่าน',
                'matches' => 'การยืนยันรหัสผ่านไม่ตรงกัน',
                'safe_input' => 'Programming Found!',
            ]
        ],

    ];

    public $contactus = [        
        'name' => [
            'rules' => 'required|safe_input',
            'errors' => [
                'required' => 'กรุณาระบุชื่อ',
                'safe_input' => 'Programming Found!',
            ]
        ],
        'email' => [
            'rules' => 'required|valid_email|safe_input',
            'errors' => [
                'required' => 'กรุณาระบุอีเมล',
                'valid_email' => 'รูปแบบอีเมลไม่ถูกต้อง',
                'safe_input' => 'Programming Found!',
            ]
        ],    
        'subject' => [
            'rules' => 'required|safe_input',
            'errors' => [
                'required' => 'กรุณาระบุ',
                'safe_input' => 'Programming Found!',
            ]
        ],  
        'message' => [
            'rules' => 'required|safe_input',
            'errors' => [
                'required' => 'กรุณาระบุ',
                'safe_input' => 'Programming Found!',
            ]
        ],
    ];
    
}
