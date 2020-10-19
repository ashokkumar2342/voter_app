<?php

namespace App\Console\Commands;

use App\Admin;
use App\Events\SmsEvent;
use App\Helpers\MailHelper;
use App\Jobs\SendSmsJob;
use App\Model\Sms\EmailTemplate;
use App\Model\Sms\SentEmailAttachment;
use App\Model\Sms\SentEmailDetail;
use App\Model\Sms\SentSmsDetail;
use App\Model\VoterImage;
use Illuminate\Console\Command;
class ImageTransfer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:transfer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Image Transfer ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    { 
      $VoterImages =VoterImage::get();
      foreach ($VoterImages as $VoterImage) {
        $image=$VoterImage->image;
        $name =$VoterImage->voter_id;
        $image= \Storage::disk('local')->put("voter_image/".$name.'.jpg', $image); 
      }
      
    }
}
