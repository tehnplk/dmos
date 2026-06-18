<?php

namespace app\components;

use yii\base\Component;
use DateTime;
use IntlDateFormatter;
class MyDate extends Component {

    public static function toTh($mysqlDate) {
// Check if the date is valid
        if (!$mysqlDate) {
            return '-';
        }

// Create a DateTime object from the MySQL date
        $date = new DateTime($mysqlDate);

// Set the formatter to the Thai locale
        $formatter = new IntlDateFormatter('th-TH@calendar=buddhist',
                IntlDateFormatter::LONG,
                IntlDateFormatter::NONE);

// Format the date to the Thai Buddhist calendar
        return $formatter->format($date);
    }

}
