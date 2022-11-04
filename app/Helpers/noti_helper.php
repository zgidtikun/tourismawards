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
                $us_noti->pack_noti = json_decode($us_noti->pack_noti);
                $temp = array_unshift($temp,$data);
            } else {
                $temp = $data;
            }

            $noti->where('id',$us_noti->id)->set(['pack_noti' => json_encode($temp)]);
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
        $us_noti = $noti->where(['user_id' => $target->user_id, 'target' => $target->bank])
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