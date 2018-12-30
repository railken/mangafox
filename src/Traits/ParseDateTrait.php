<?php

namespace Railken\Mangafox\Traits;

use DateTime;

trait ParseDateTrait
{
    /**
     * Parse data from text (e.g 10 minutes ago) to formatted "Y-m-d H:i:s".
     *
     * @param string $original
     *
     * @return string
     */
    public function parseDate($original)
    {
        $now = new DateTime();

        if (preg_match("/^([0-9]*) ([\w]*) ago$/", $original, $res)) {
            $types = [
                'minutes', 'minute', 'seconds', 'second', 'hours', 'hour', 'days', 'day',
            ];

            if (in_array($res[2], $types)) {
                return $now->modify('-'.$res[1].' '.$res[2])->format('Y-m-d H:i:s');
            } else {
                throw new Exceptions\MangafoxParserDateNotSupportedException($res[2]);
            }
        }

        $today = $now->setTime(00, 00, 00);

        if ($original == 'Today') {
            return $today->format('Y-m-d H:i:s');
        }

        if ($original == 'Yesterday') {
            return $today->modify('-1 days')->format('Y-m-d H:i:s');
        }

        $date = DateTime::createFromFormat('M d,Y', $original);

        if (!$date) {
            throw new \Exception(sprintf('Cannot convert: %s', $original));
        }

        return $date->setTime(00, 00, 00)->format('Y-m-d H:i:s');
    }
}
