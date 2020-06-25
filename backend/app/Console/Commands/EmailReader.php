<?php
/**
 * Created by IntelliJ IDEA.
 * User: alexburov
 * Date: 08.05.18
 * Time: 17:49
 */

namespace App\Console\Commands;
use App\FileStatus;
use App\FileType;
use Illuminate\Support\Facades\File;

use League\Csv\Reader;
use League\Csv\Statement;
use PhpImap\Mailbox;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\FileLog;
use Illuminate\Console\Command;

class EmailReader extends Command
{

    /**
     * Имя и аргументы консольной команды.
     *
     * @var string
     */
    protected $signature = 'cron:emailreader';

    /**
     * Описание консольной команды.
     *
     * @var string
     */
    protected $description = 'Parse Email cron task';

    /**
     * Служба "капельных" e-mail сообщений.
     *
     * @var DripEmailer
     */


    /**
     * Создание нового экземпляра команды.
     *
     * @param  DripEmailer  $drip
     * @return void
     */

    /**
     * Выполнение консольной команды.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->email_reader();
    }

    // читаем почту
    public function email_reader()
    {
        echo "email_reader start <br/>";

        $server = "{imap.yandex.ru:993/imap/ssl}";
        $login = 'xiaomi@webinnovations.ru';
        $password = 'xiaomi123@';
        $file_status_id = FileStatus::with('fileLogs')->where(['code'=>'Ready'])->first()->id;
        $file_type_id = FileType::where(['code'=>'Visit'])->first()->id;

        $mailbox = new Mailbox($server, $login , $password, 'storage/app/upload');

        // read all messaged into an array
        $mailsIds = $mailbox->searchMailbox('UNSEEN');
        $maiCount = count($mailsIds);
        if(!$mailsIds) {
            echo 'Mailbox is empty <br/>';
        }
        else{

            for($i = 0 ;  $i < $maiCount; $i++) {
                $mail = $mailbox->getMail($mailsIds[$i]);
                $attachments = $mail->getAttachments();
                foreach ($attachments as $item) {
                    $file = new \SplFileInfo($item->filePath);
                    $basenamefile = substr($file->getFilename(), strripos($file->getFilename(), '_') + 1);

                    // var_dump($basenamefile);

                    $path = stristr($file->getPath() . '/' . $file->getFilename(), 'storage');
                    $date = date("Y-d-m H:i:s");
                    // var_dump($date);

                    if ($file->getExtension() == 'csv') {
                        try{
                            $filelog = FileLog::create(
                                [
                                    'file_name' => $file->getFilename(),
                                    'original_file_name' => $basenamefile,
                                    'path' => $path,
                                    'file_status_id' => $file_status_id,
                                    'file_type_id' => $file_type_id,
//                                    'upload_date' => $date,
                                    'content' => file_get_contents($file)
                                ]
                            );
                        }catch (Exception $e) {
                            
                            var_dump([
                                    'file_name' => $file->getFilename(),
                                    'original_file_name' => $basenamefile,
                                    'path' => $path,
                                    'file_status_id' => $file_status_id,
                                    'file_type_id' => $file_type_id,
                                    'upload_date' => $date,
                                    'content' => file_get_contents($file)
                                ]);
                            echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
                            
                        }

                    }
                }
            }

            echo 'File is read <br/>';
        }
        echo "email_reader and <br/>";
    }


}