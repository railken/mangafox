<?php

namespace Railken\Mangafox\Traits;

use DateTime;
use Railken\Mangafox\Exceptions\MangafoxParserDateNotSupportedException;

trait ParseDateTrait
{

    /**
     * Parse data from text (e.g 10 minutes ago) to formatted "Y-m-d H:i:s"
     *
     * @param string $date
     *
     * @return string
    */
    public function parseDate($date)
    {
        $now = new DateTime();

        if (preg_match("/^([0-9]*) ([\w]*) ago$/", $date, $res)) {
            $types = [
                'minutes','minute','seconds','second','hours','hour','days','day'
            ];

            if (in_array($res[2], $types)) {
                return $now->modify("-".$res[1]." ".$res[2])->format('Y-m-d H:i:s');
            } else {
                throw new Exceptions\MangafoxParserDateNotSupportedException($res[2]);
            }
        }

        $today = $now->setTime(00, 00, 00);

        if ($date == 'Today') {
            return $today->format('Y-m-d H:i:s');
        }

        if ($date == 'Yesterday') {
            return $today->modify('-1 days')->format('Y-m-d H:i:s');
        }

        
        return DateTime::createFromFormat('M d, Y', $date)->setTime(00, 00, 00)->format('Y-m-d H:i:s');
    }
}
