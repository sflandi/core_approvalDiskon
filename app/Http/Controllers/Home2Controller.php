<?php

namespace App\Http\Controllers;

use App\User;
use App\Query;
use Illuminate\Http\Request;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use DB;
use Auth;

class Home2Controller extends Controller
{
    public function index($query)
    {
        if ( md5('gadingserpong') == $query) {
            $branchSession = 'gading serpong'; //453ddc459e19801689e4a881f5214494
            $data = DB::select('SET NOCOUNT ON exec Irvan_approvaldiskon ?,?', array($branchSession,'11'));
        } elseif (md5('greengarden') == $query) {
            $branchSession = 'green garden'; //84c98605c766e39fe1c25f4bdcf6f55a
        } elseif (md5('bandung') == $query) {
            $branchSession = 'bandung'; //938b4263f09b8b1dae8f027d06681ec9
        } elseif (md5('citeureup') == $query) {
            $branchSession = 'citeureup'; //6acb29721a5eb50e3554878ef4e93191
        } elseif (md5('tendean') == $query) {
            $branchSession = 'tendean'; //d9bdaa51ceb5d425768c1d80e9103244
        } elseif (md5('pemuda') == $query) {
            $branchSession = 'pemuda'; //9fadbc6cae09b4bdd0453762d914b72f
        } elseif (md5('kyaitapa') == $query) {
            $branchSession = 'kyai tapa'; //41e6059f81913f46f79dd56646732d23
        }  else {
            $branchSession = 'not plaza';
        }

        // return $branchSession;
        return view('main/kacab', [
            'data' => $data,
        ]);
    }




    private function broadcastMessageToOperationManager($senderName, $message)
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder  ->setTimeToLive(200)
                        ->setPriority('high')
                        ->setContentAvailable(true);

        $notificationBuilder = new PayloadNotificationBuilder('New Message From '. $senderName);
        $notificationBuilder->setBody($message)
                            ->setSound('default')
                            ->setClickAction('https://approval.plazatoyota.net/approvaldiskon/')
                            // ->setIcon('https://approval.plazatoyota.net/img/ms-icon-310x310.png');
                            ->setIcon('https://approval.plazatoyota.net/approvaldiskon/img/toyota.png');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData([
            'name' => $senderName
        ]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $tokens = DB::table('tblFcmUserApprovalDiskon')-> where('name', '=', 'OM')->pluck('fcm_token')->toArray();
        // dd($tokens);
        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
        // dd($downstreamResponse);

        return $downstreamResponse->numberSuccess();
    }

    private function broadcastMessageToDirektur($senderName, $message)
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder  ->setTimeToLive(200)
                        ->setPriority('high')
                        ->setContentAvailable(true);

        $notificationBuilder = new PayloadNotificationBuilder('New Message From '. $senderName);
        $notificationBuilder->setBody($message)
                            ->setSound('default')
                            ->setClickAction('https://approval.plazatoyota.net/approvaldiskon/')
                            // ->setIcon('https://approval.plazatoyota.net/img/ms-icon-310x310.png');
                            ->setIcon('https://approval.plazatoyota.net/approvaldiskon/img/toyota.png');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData([
            'name' => $senderName
        ]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $tokens = DB::table('tblFcmUserApprovalDiskon')-> where('name', '=', 'direktur1')->pluck('fcm_token')->toArray();
        // dd($tokens);
        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
        // dd($downstreamResponse);

        return $downstreamResponse->numberSuccess();
    }



    public function sendFcm()
    {
        $this->broadcastMessage('User A', 'Setalah Logout');
        // return view('home');
        return redirect('/home');
    }


    private function broadcastMessage($senderName, $message)
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder  ->setTimeToLive(200)
                        ->setPriority('normal')
                        ->setContentAvailable(true);

        $notificationBuilder = new PayloadNotificationBuilder('New Message From '. $senderName);
        $notificationBuilder->setBody($message)
                            ->setSound('default')
                            ->setClickAction('https://approval.plazatoyota.net/approvaldiskon/')
                            // ->setIcon('https://approval.plazatoyota.net/img/ms-icon-310x310.png');
                            ->setIcon('https://approval.plazatoyota.net/approvaldiskon/img/toyota.png');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData([
            'name' => $senderName
        ]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $tokens = User::All()->pluck('fcm_token')->toArray();
        // dd($tokens);
        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
        // dd($downstreamResponse);

        return $downstreamResponse->numberSuccess();
    }
}
