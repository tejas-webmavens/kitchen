<?
class Core_BP_Components_Date {
	function gettimeago($time) {
        $now = date_create(date('Y-m-d H:i:s'));
        $past_date = date_create($time);
        $diff = date_diff($now, $past_date);
        if($diff->y!=0){
        	return $diff->y." years";
        }
        elseif($diff->m!=0){
        	return $diff->m." month";
        }
        elseif($diff->d!=0){
        	return $diff->d." days";
        }
        elseif($diff->h!=0){
        	return $diff->h." hrs";
        }
        elseif($diff->i!=0){
        	return $diff->i." mins";
        }
        elseif($diff->s!=0){
        	return $diff->s." sec";
        }
	}

    function getmsgreceivedtimeformat($time){
        $now = date('Y-m-d H:i:s');
        $past_date = $time;
        $days = Core_BP_Date::count_days($now, $past_date);

        if($days==0){
            return Core_BP_Date::gettimeformat($time);
        }
        else{
            return Core_BP_Date::getdateformat($time);
        }
    }

    function addDays($date, $days = 0){
        $new_date = date('Y-m-d', strtotime($date.' + '.$days.' days'));
        return $new_date;
    }
}