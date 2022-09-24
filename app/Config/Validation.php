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

    public $appregister = [
        'step1' => [
            'application_type_id' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'กรุณาเลือกประเภทการประกวด',
                    'numberic' => 'ส่งข้อมูลเป็นตัวเลขเท่านั้น',
                ]
            ],
            'application_type_sub_id' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'กรุณาเลือกสาขารางวัล',
                    'numberic' => 'ส่งข้อมูลเป็นตัวเลขเท่านั้น',
                ]
            ],
            'highlights' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณาเลือกสาขารางวัล',
                ]
            ],
        ],
        'step2' => [
            'attraction_name_th' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกชื่อแหล่งท่องเที่ยว/สถานประกอบการ/รายการนำเที่ยว',
                ]
            ],
            'address_no' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกที่อยู่',
                ]
            ],
            'address_road' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกถนน',
                ]
            ],
            'address_sub_district' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกตำบล/แขวง',
                ]
            ],
            'address_district' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกอำเภอ/เขต',
                ]
            ],
            'address_province' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกจังหวัด',
                ]
            ],
            'address_zipcode' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'กรุณากรอกรหัสไปรษณีย์',
                    'numberic' => 'กรอกข้อมูลเป็นตัวเลขเท่านั้น',
                ]
            ],
        ],
        'step3' => [
            'company_name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกชื่อหน่วยงาน',
                ]
            ],
            'company_addr_no' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกที่อยู่',
                ]
            ],
            'company_addr_road' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกถนน',
                ]
            ],
            'company_addr_sub_district' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกตำบล/แขวง',
                ]
            ],
            'company_addr_district' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกอำเภอ/เขต',
                ]
            ],
            'company_addr_province' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกจังหวัด',
                ]
            ],
            'company_addr_zipcode' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'กรุณากรอกรหัสไปรษณีย์',
                    'numberic' => 'กรอกข้อมูลเป็นตัวเลขเท่านั้น',
                ]
            ],
        ],
        'step4' => [
            'knitter_name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกชื่อผู้ประสานงาน',
                ]
            ],
            'knitter_position' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกตำแหน่ง',
                ]
            ],
            'knitter_tel' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกหมายเลขโทรศีพท์',
                ]
            ],
            'knitter_email' => [
                'rules' => 'required|valid_email|',
                'errors' => [
                    'required' => 'กรุณากรอกอีเมล',
                    'valid_email' => 'รูปแบบอีเมลไม่ถูกต้อง',
                ]
            ],
        ],
        'step5' => [
            'year_open' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'กรุณากรอกปีเปิดให้บริการ',
                    'numberic' => 'กรอกข้อมูลเป็นตัวเลขเท่านั้น',
                ]
            ],
            'year_total' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'กรุณากรอกระยะเวลารวม',
                    'numberic' => 'กรอกข้อมูลเป็นตัวเลขเท่านั้น',
                ]
            ],
        ],
        'finish' => [
            'application_type_id' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'กรุณาเลือกประเภทการประกวด',
                    'numberic' => 'ส่งข้อมูลเป็นตัวเลขเท่านั้น',
                ]
            ],
            'application_type_sub_id' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'กรุณาเลือกสาขารางวัล',
                    'numberic' => 'ส่งข้อมูลเป็นตัวเลขเท่านั้น',
                ]
            ],
            'highlights' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณาเลือกสาขารางวัล',
                ]
            ],
            'attraction_name_th' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกชื่อแหล่งท่องเที่ยว/สถานประกอบการ/รายการนำเที่ยว',
                ]
            ],
            'address_no' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกที่อยู่',
                ]
            ],
            'address_road' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกถนน',
                ]
            ],
            'address_sub_district' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกตำบล/แขวง',
                ]
            ],
            'address_district' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกอำเภอ/เขต',
                ]
            ],
            'address_province' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกจังหวัด',
                ]
            ],
            'address_zipcode' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'กรุณากรอกรหัสไปรษณีย์',
                    'numberic' => 'กรอกข้อมูลเป็นตัวเลขเท่านั้น',
                ]
            ],
            'company_name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกชื่อหน่วยงาน',
                ]
            ],
            'company_addr_no' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกที่อยู่',
                ]
            ],
            'company_addr_road' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกถนน',
                ]
            ],
            'company_addr_sub_district' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกตำบล/แขวง',
                ]
            ],
            'company_addr_district' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกอำเภอ/เขต',
                ]
            ],
            'company_addr_province' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกจังหวัด',
                ]
            ],
            'company_addr_zipcode' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'กรุณากรอกรหัสไปรษณีย์',
                    'numberic' => 'กรอกข้อมูลเป็นตัวเลขเท่านั้น',
                ]
            ],
            'knitter_name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกชื่อผู้ประสานงาน',
                ]
            ],
            'knitter_position' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกตำแหน่ง',
                ]
            ],
            'knitter_tel' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'กรุณากรอกหมายเลขโทรศีพท์',
                ]
            ],
            'knitter_email' => [
                'rules' => 'required|valid_email|',
                'errors' => [
                    'required' => 'กรุณากรอกอีเมล',
                    'valid_email' => 'รูปแบบอีเมลไม่ถูกต้อง',
                ]
            ],
            'year_open' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'กรุณากรอกปีเปิดให้บริการ',
                    'numberic' => 'กรอกข้อมูลเป็นตัวเลขเท่านั้น',
                ]
            ],
            'year_total' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'กรุณากรอกระยะเวลารวม',
                    'numberic' => 'กรอกข้อมูลเป็นตัวเลขเท่านั้น',
                ]
            ],
        ],
    ];
}
