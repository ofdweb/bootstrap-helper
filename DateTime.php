<?php

namespace razmik\helper;

class DateTime extends \DateTime
{
    protected static function context($dateTime = null)
    {
        if (!$dateTime) { 
            $dateTime = new static();
        } elseif (!$dateTime instanceof \DateTime) {
            $dateTime = new static($dateTime);
        } 
      
        return $dateTime;
    }
    
    public static function view($dateTime = null, $format = 'Y-m-d H:i:s') 
    {
        $dateTime = static::context($dateTime); 
        return $dateTime->format($format);
    }
  
    public static function differenceInDays ($firstDate, $secondDate = null)
    {
        $firstDate = static::context($firstDate); 
        $secondDate = static::context($secondDate);
      
        $firstDateTimeStamp = $firstDate->format("U");
        $secondDateTimeStamp = $secondDate->format("U");
      
        $result = round ((($firstDateTimeStamp - $secondDateTimeStamp)) / 86400);
        return $result;
    }
  
    public static function differenceInDaysText ($dateTime, $format = 'full')
    {
        $days = static::differenceInDays($dateTime);
      
        if ($days == 0) {
          return 'сегодня';
        } elseif ($days < 0) {
          $days = abs($days);
          
          switch ($days) {
            case 1: return 'вчера';
            case 2:
            case 3:
            case 4: return $days . ' дня назад';
            default: return $days . ' дней назад';
          }  
        } elseif ($days > 0) {
          switch ($days) {
            case 1: return 'завтра';
            case 2: return 'послезавтра';
            case 3:
            case 4: return 'через' . $days . ' дня';
            default: return 'через' . $days . ' дней';
          }  
        }
        
        return false;
    }
}