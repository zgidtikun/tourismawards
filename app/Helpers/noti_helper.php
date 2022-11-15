<?php 

function instance_db()
{
    $db = \Config\Database::connect();
    return $db;
}

function instance_noti()
{
    $obj = new \App\Models\Notification();
    return $obj;
}

function get_app_id($id)
{
    $obj = new \App\Models\ApplicationForm();
    $app = $obj->where('created_by',$id)
        ->select('id')
        ->first();
    return $app->id;
}

function get_receive_noti($id)
{
    $obj = new \App\Models\Committees();
    $data = $obj->where('users_id',$id)
        ->select('admin_id_tourism, admin_id_supporting, admin_id_responsibility')
        ->first();

    $tourism = json_decode($data->admin_id_tourism,true);
    $support = json_decode($data->admin_id_supporting,true);
    $respons = json_decode($data->admin_id_responsibility,true);
    $result = array_unique(array_merge($tourism,$support,$respons));
    $result = json_decode(json_encode($result),false);
    return $result;
}

function set_noti($target,$data)
{
    try {
        $noti = instance_noti();
        $us_noti = $noti->where(['user_id' => $target->user_id, 'target' => $target->bank])
            ->select('id, pack_noti')->first();

        if(empty($us_noti)){
            $noti->insert([
                'user_id' => $target->user_id,
                'target' => $target->bank,
                'pack_noti' => json_encode([$data])
            ]);
        } else {
            if(!empty($us_noti->pack_noti)){
                $temp = json_decode(json_encode($data),true) + json_decode($us_noti->pack_noti,true);
            } else {
                $temp = $data;
            }

            $noti->where('id',$us_noti->id)
            ->set(['pack_noti' => json_encode($temp)])
            ->update();
        }

        return ['result' => true];
    } catch(Exception $e){
        return ['result' => false, 'message' => $e->getMessage()];
    }
}

function set_multi_noti($receive,$target,$data)
{
    try{
        foreach($receive as $val){
            set_noti((object)[
                'user_id' => $val,
                'bank' => $target->bank
            ],
            $data);
        }

        return ['result' => true];
    } catch(Exception $e){
        return ['result' => false, 'message' => $e->getMessage()];
    }
}

function get_noti($target,$max = 5)
{
    try {
        $noti = instance_noti();
        $us_noti = $noti->where([
                'user_id' => $target->user_id, 
                'target' => $target->bank
            ])
            ->select("'0' num,  id, pack_noti")
            ->first();

        $temp = [];
        $counter = 0;
        
        if(!empty($us_noti->pack_noti)){            
            $list = json_decode($us_noti->pack_noti,true);
            
            if($max != 'all') {                
                while($counter < $max &&  $counter < count($list)){
                    array_push($temp,$list[$counter]);
                    $counter++;
                }
            } else {            
                $temp = $list;
            }
        }

        return [
            'result' => 'success',
            'id' => !empty($us_noti->id) ? $us_noti->id : null,
            'noti' => $temp
        ];
    } catch(Exception $e) {
        return [
            'result' => 'error',
            'message' => $e->getMessage(),
            'id' => null,
            'noti' => []
        ];
    }
}

?>