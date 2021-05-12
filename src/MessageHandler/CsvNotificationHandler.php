<?php
namespace App\MessageHandler;

use App\Message\CsvNotification;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Faker;

class CsvNotificationHandler implements MessageHandlerInterface
{

    public function __construct()
    {

    }

    public function __invoke(CsvNotification $csv)
    {
        $faker = Faker\Factory::create('fr_FR');
        $temp_file = tempnam(sys_get_temp_dir(), 'Tux');
        $handle = fopen($temp_file, "w");


        for($i=0; $i<100000; $i++) {
            fputcsv($handle,
                [
                    $faker->company,
                    $faker->name,
                    $faker->firstName,
                    $faker->lastName,
                ], ";");
        }

        fclose($handle);

        sleep(10);

    }
}
