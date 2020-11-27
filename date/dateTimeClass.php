<?php

/**
 * 
 */
class dateTimeClass
{

	//年周YW 转 周的开始日期Ymd和结束日期Ymd
	private static function yearWeek2Date(int $year,int $weeknum) : array
	{
	    $firstdayofyear=mktime(0,0,0,1,1,$year);
	    $firstweekday=date('N',$firstdayofyear);
	    $firstweenum=date('W',$firstdayofyear);
	    if($firstweenum==1){
	        $day=(1-($firstweekday-1))+7*($weeknum-1);
	        $startdate=date('Y-m-d',mktime(0,0,0,1,$day,$year));
	        $enddate=date('Y-m-d',mktime(0,0,0,1,$day+6,$year));
	    }else{
	        $day=(9-$firstweekday)+7*($weeknum-1);
	        $startdate=date('Y-m-d',mktime(0,0,0,1,$day,$year));
	        $enddate=date('Y-m-d',mktime(0,0,0,1,$day+6,$year));
	    }

	    return array($startdate,$enddate);
	}

	// 与yearWeek2Date 互逆
	public static  function date2YearWeek($tm)
    {
        $m = date('m', $tm);
        $W = date('W', $tm);
        $Y = date('Y', $tm);
        if($m == 1 && $W > 50) {
            $Y = $Y - 1;
        } elseif ($m == 12 && $W < 10) {
            $Y = $Y + 1;
        }
        return ['y'=> $Y,'w'=> $W];
    }


	//开始时间戳+结束时间戳 转 开始时间戳的周一, 结束时间戳的下周一
	public static function getWeekTime(string $sDay, string $eDay): array
	{
	    $currentTime  = strtotime($sDay);
	    $currentWeeks = date("N", $currentTime);
	    $sTime        = $currentTime - ($currentWeeks - 1) * 86400;

	    $lastTime     = strtotime($eDay);
	    $currentWeeks = date("N", $lastTime);
	    $eTime        = $lastTime + (7 - $currentWeeks) * 86400 + 86400;
	    return [$sTime, $eTime];
	}

}
