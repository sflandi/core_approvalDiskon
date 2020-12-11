<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\User;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function sendFcm()
    {
        $this->broadcastMessage('User A', 'Setalah Logout');
        // return view('home');
        return redirect('/home');
    }

    private function broadcastMessage($senderName, $message){
        $optionBuilder = new OptionsBuilder();
        $optionBuilder  ->setTimeToLive(200)
                        ->setPriority('normal')
                        ->setContentAvailable(true);

        $notificationBuilder = new PayloadNotificationBuilder('New Message From '. $senderName);
        $notificationBuilder->setBody($message)
                            ->setSound('default')
                            ->setClickAction('https://www.google.co.id/search?safe=strict&source=hp&ei=rc3SX_WyAoWo9QPoyYzQAw&q=plazatoyota&oq=plazatoyota&gs_lcp=CgZwc3ktYWIQAzIOCC4QxwEQrwEQyQMQkwIyCgguEMcBEK8BEAoyCgguEMcBEK8BEAoyCgguEMcBEK8BEAoyBAgAEAoyCgguEMcBEK8BEAoyCgguEMcBEK8BEAoyBAgAEAoyCgguEMcBEK8BEAoyBAgAEAo6CAgAELEDEMkDOggIABCxAxCDAToCCAA6BQguELEDOgUIABCxAzoICC4QsQMQgwE6CwguELEDEMcBEK8BOg4ILhCxAxCDARDHARCvAToRCC4QsQMQxwEQrwEQyQMQkwI6CAguEMcBEK8BUNILWMEcYLUeaABwAHgAgAGBAYgBtwiSAQM1LjaYAQCgAQGqAQdnd3Mtd2l6&sclient=psy-ab&ved=0ahUKEwi1vfbW5cTtAhUFVH0KHegkAzoQ4dUDCAc&uact=5')
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

    // public function sendNotification()
    // {
    //     // $token = "cm8BpLPobEs:APA91bEO8tTq-ejMiHHC-Yy4396Sg0LhzJmRbnRpq9trZLfDH2pW1xssp2wCYsFPNRs4RvcCtxP5pA3H6S8xDYzblYkD5hD9JCtOXZ6_1wB3KNIhIY6y-E4mSTRSwjEe5AmGJu4H2s7i"; //Laptop Andi
        
    //     $token = "cF-WRMo7Wmc8wsLwLeM-G8:APA91bGvI2C-ZEnuVsloFmLpR5f0BHGBt0sh1Ktq3kyp4rWGWpjFcsk0EuPruNiCF8J2ke3L4os_WDkI_apJOCmNH6MQ_yZs7Si7k1A0Y31vcPWzW_e6ALFn4Zz9WJafZgW5SFoi2Esf"; //Laptop Andi
    //     $from = "AAAAY7guQuM:APA91bHhLqQk4FfpFCUfbEbCDnLv4I5VVfZFrHj3vuv6-DjcE5f2Q5t3LYZ4Q9xDVl_7mCjZhNtMcC4znkM0tI2jiCpt3hYRnaWalHALAKajV9ZSPLdwbHX44_0OPjz659f1MheCvYyJ";
    //     $msg = array
    //           (
    //             'title' => "Approval . Plaza Toyota",
    //             'body'  => "New Approval Needed",
    //             'subtitle'  => 'This is a subtitle. subtitle',
    //             'receiver' => 'erw',
    //             'icon'  => "https://approval.plazatoyota.net/img/ms-icon-310x310.png",/*Default Icon*/
    //             'sound' => 'mySound'/*Default sound*/
    //           );

    //     $fields = array
    //             (
    //                 'registration_ids'        => $token,
    //                 'notification'  => $msg
    //             );

    //     $headers = array
    //             (
    //                 'Authorization: key=' . $from,
    //                 'Content-Type: application/json'
    //             );
    //     //#Send Reponse To FireBase Server 
    //     $ch = curl_init();
    //     curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    //     curl_setopt( $ch,CURLOPT_POST, true );
    //     curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    //     curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    //     curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    //     curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    //     $result = curl_exec($ch );
    //     // dd($result);
    //     //Close request
    //     // if ($response === FALSE) {
    //     //     die('FCM Send Error: ' . curl_error($ch));
    //     // }
    //     curl_close( $ch );

    //     return redirect('/home');
    // }
    
    public function sendArrayNotification()
    {   
        // $registrationIds = array('cm8BpLPobEs:APA91bEO8tTq-ejMiHHC-Yy4396Sg0LhzJmRbnRpq9trZLfDH2pW1xssp2wCYsFPNRs4RvcCtxP5pA3H6S8xDYzblYkD5hD9JCtOXZ6_1wB3KNIhIY6y-E4mSTRSwjEe5AmGJu4H2s7i',
        // 'dqD2baG5Wvg:APA91bGRhKSAOpbFaPHKjGCiLsoQX0J9HG3M_Jq6b3jrpG2Lf0_io4m_2RJk-JsRaAKTQ-udsedqp3oSgZe-ljIMszAKOP00RjQHm_Bpjp5ypGO3nhcCJCOvYpYBVEixlLoUcrhkp_cQ'); //Laptop andi dan ikram
        
        $registrationIds = array('dEsCg9boKLY6YPFblgUrp9:APA91bHAwinbPUCbnp_7cqlo_z5Z4tmUckr31jkBQberyiz3cqZzRyiZKDIR54FYvtwDzCIz4xG_Npz0C2-EhC3a9rDVYsKi_F24zfssEbQ7tBAlXJ6QUP7ey26dbQmJspblVbfNKQYf','ewgtOSgIf0dKXnqkRarWO_:APA91bEAbk0z8tKSSv31Eyt9Eh8afyLSGHrr_RV4d5kVKCaMrKsMZD2DddCShfL4DbuzT2UU3gtUjqPOIBdXd0tCvWoyKfjQbjE6zUEIIQP3lgoH6m4FXwT8r3RdplvdoXpMD13HJh7A', 'cF-WRMo7Wmc8wsLwLeM-G8:APA91bGvI2C-ZEnuVsloFmLpR5f0BHGBt0sh1Ktq3kyp4rWGWpjFcsk0EuPruNiCF8J2ke3L4os_WDkI_apJOCmNH6MQ_yZs7Si7k1A0Y31vcPWzW_e6ALFn4Zz9WJafZgW5SFoi2Esf', 'fck2mpSg1gxDSWHXutbBQ9:APA91bGzH1iHcwPe2sIB-Jb6cIJdIFSt9SyCyWos_VVbKk2w24fAeQ15b9C17LuXbkro7V9XNa3Yu4SacsolzAIUyFkBmtv82xDX17zvMJpBUKUwB2FtNH48PYy8gqUG1Ocg3VBe5yy5', 'f5dvGGcY4lPGM4HQAYUDlP:APA91bETqUZXqWo6QR9sYv26GMkNjQ2n8POhpcK3q_AaycFn1v21ftqkSpgLJXwDCMv3RlbCW6LmrE8RoEpP78SnJJqVIiKS8kOhQ5oNB4qw005I0CQU5cZ-plPByhIOqpLnE-CQzlLN'); //Laptop andi dan ikram
        $from = "AAAAY7guQuM:APA91bHhLqQk4FfpFCUfbEbCDnLv4I5VVfZFrHj3vuv6-DjcE5f2Q5t3LYZ4Q9xDVl_7mCjZhNtMcC4znkM0tI2jiCpt3hYRnaWalHALAKajV9ZSPLdwbHX44_0OPjz659f1MheCvYyJ"; //FCM Andi
        // prep the bundle
        $msg = array
        (
            'title' => "Approval . Plaza Toyota",
            'body'  => "New Approval Needed",
            'subtitle'	=> 'This is a subtitle. subtitle',
            'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
            'vibrate'	=> 'default',
            'sound'		=> 'default',
            'icon'  => "https://approval.plazatoyota.net/img/ms-icon-310x310.png",/*Default Icon*/
        );
        $fields = array
        (
            'registration_ids' 	=> $registrationIds,
            'notification' => $msg,
        );
        $headers = array
        (
            'Authorization: key='.$from,
            'Content-Type: application/json'
        ); //FCM Andi
        
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        // dd($result);
        curl_close( $ch );
        // echo $result;

        return redirect('/home');
    }
}
