<?php
declare(strict_types=1);

require_once 'vendor/autoload.php';
require_once 'LabelGenerator.php';

use Commando\Command;

$command = new Command();

$command->argument()->expectsFile();
$filename = current($command->getArgumentValues());
$handle = fopen($filename, 'r');

if($handle === false) {
    echo sprinf('Cannot open file <%s>', $filename);
    exit;
}

$attendees = [];

while (($data = fgetcsv($handle, 1000, ";")) !== false) {
    $attendee = [];
    for ($c = 0; $c < count($data); $c++) {
        switch ($c) {
            case 0:
                $attendee['lastname'] = $data[$c];
                break;
            case 1:
                $attendee['firstname'] = $data[$c];
                break;
            case 2:
                $attendee['title'] = $data[$c];
                break;
            case 3:
                $attendee['code'] = $data[$c];
                break;
        }
    }
    $attendees[] = $attendee;
}

fclose($handle);

$generator = new LabelGenerator($attendees);
$generator->generate();
