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
    public $signup = [
        'name' => [
            'rules' => 'required|special_str',
            'errors' => [
                'required' => 'กรุณาระบุชื่อ',
                'special_str' => 'ชื่อห้ามมีอักขระพิเศษ'
            ]
        ],
        'surname' => [
            'rules' => 'required|special_str',
            'errors' => [
                'required' => 'กรุณาระบุนามสกุล',
                'special_str' => 'ชื่อห้ามมีอักขระพิเศษ'
            ]
        ],
        'telephone' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'กรุณาระบุเบอร์โทรศัพท์'
            ]
        ],
        'email' => [
            'rules' => 'required|valid_email|unique_email[email,role]',
            'errors' => [
                'required' => 'กรุณาระบุอีเมล',
                'valid_email' => 'รูปแบบอีเมลไม่ถูกต้อง',
                'unique_email' => 'อีเมลนี้มีอยู่แล้ว'
            ]
        ],
        'confirmemail' => [
            'rules' => 'required|valid_email|matches[email]',
            'errors' => [
                'required' => 'กรุณายืนยันอีเมล',
                'valid_email' => 'รูปแบบอีเมลไม่ถูกต้อง',                
                'matches' => 'การยืนยันอีเมลไม่ตรงกัน'
            ]
        ],
        'password' => [
            'rules' => 'required|min_length[6]|password_format[password]',
            'errors' => [
                'required' => 'กรุณาระบุรหัสผ่าน',
                'min_length' => 'รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร',
                'password_format' => 'รหัสผ่านต้องมี A-Z, a-z, 0-9'
            ]
        ],
        'confirmpass' => [
            'rules' => 'required|min_length[6]|matches[password]',
            'errors' => [
                'required' => 'กรุณายืนยันรหัสผ่าน',
                'min_length' => 'รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร',
                'matches' => 'การยืนยันรหัสผ่านไม่ตรงกัน'
            ]
        ],

    ];
}
