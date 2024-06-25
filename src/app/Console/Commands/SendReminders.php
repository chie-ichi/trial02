<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\Restaurant;
use App\Models\Reservation;

class SendReminders extends Command
{
    /**
     * The name and signature of the console command.
     *php 
     * @var string
     */
    protected $signature = 'command:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails for reservations to the users';

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
     * @return int
     */
    public function handle()
    {
        $reservations = Reservation::whereDate('date', Carbon::today())->get();

        foreach($reservations as $reservation) {
            $restaurant = Restaurant::find($reservation->restaurant_id);
            $owner = $restaurant->getOwner();
            $from_mail = $owner->email;
            $from_name = $restaurant->name;

            $to_mail = $reservation->getUserEmail();
            $to_name = $reservation->getUser() . '様';

            $body = <<<EOT
{$to_name}

この度は、{$from_name}にご予約いただき誠にありがとうございます。
ご予約日当日になりましたため、お知らせいたします。
{$to_name}のご予約内容は以下のとおりです。

-------------------------------------
店名：{$from_name}
日時：{$reservation->date}　{$reservation->time}
人数：{$reservation->number}名様
-------------------------------------
※お支払いには、現金・クレジットカード・電子マネーのいずれかをご利用いただけます。

スタッフ一同、{$to_name}のご来店をお待ちしております。


-------------------------------------
{$from_name} <{$from_mail}>

EOT;

            Mail::raw($body, function ($message) use ($from_mail, $to_mail, $from_name, $to_name) {
                $message->from($from_mail, $from_name)
                        ->to($to_mail, $to_name)
                        ->subject('【' . $from_name . '】ご予約確認');
            });
        }
    }
}
