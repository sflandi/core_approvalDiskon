<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\User;
use App\Query;
use Illuminate\Http\Request;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use DB;
use Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function slash()
    {
        $name = Auth::user()->access;
        // dd($name);
        if ($name == '') {
            return route('login');
        } else {
            if ($name == 'OM') {
                return redirect('/om');
            }elseif ($name == 'kacab') {
                return redirect('/kacab');
            } elseif ($name == 'direktur') {
                return redirect('/direktur');
            }
        }
    }

    public function kacab()
    {
        $getcabang = Auth::user()->cabang;
        $data = DB::select('SET NOCOUNT ON exec Irvan_approvaldiskon ?,?', array($getcabang,'11'));
        // dd($dataAcc);

        $name = Auth::user()->access;
        if ($name == 'OM') {
            return redirect('/om');
        }elseif ($name == 'kacab') {
            return view('main/kacab', [
                'data' => $data,
            ]);
        } elseif ($name == 'direktur') {
            return redirect('/direktur');
        }
    }

    public function om()
    {
        $data = DB::select('SET NOCOUNT ON exec Irvan_approvaldiskon_allCabangnew ?', array('11'));
        // $dataAcc = DB::select('SET NOCOUNT ON exec abi_acc_dan_lain2_rev');
        // dd($data);

        $name = Auth::user()->access;
        if ($name == 'OM') {
            return view('main/om', [
                'data' => $data
                // 'dataAcc' => $dataAcc
            ]);
        }elseif ($name == 'kacab') {
            return redirect('/kacab');
        } elseif ($name == 'direktur') {
            return redirect('/direktur');
        }
    }

    public function direktur()
    {
        $data = DB::select('SET NOCOUNT ON exec Irvan_approvaldiskon_dir ?,?', array('11', 'Direktur'));  
        $data_2 = DB::select('SET NOCOUNT ON exec Irvan_approvaldiskon_dir ?,?', array('11', 'Presdir'));      
        // dd($data_2);

        $name = Auth::user()->access;
        if ($name == 'OM') {
            return redirect('/om');
        }elseif ($name == 'kacab') {
            return redirect('/kacab');
        } elseif ($name == 'direktur') {
            return view('main/direktur', [
                'data' => $data,
                'data_2' => $data_2
            ]);
        }
    }


    public function storeApprovalKacab(Request $request, $query)
    {
        $now = date('Y-m-d H:i:s');
        $getKacab = Auth::user()->name;
        $status = $request->status;
        if ($status == "12") {
            DB::table('Xts_vehicleorderformExtensionBase')
                ->where('Xts_vehicleorderformcode', $query)
                ->update([
                    'xts_approvename' => 'kacab',
                    'Xts_status' => $request->status,
                    'xts_approvaldiscount'=>3,
                    'xts_appdistime' => $now
                ]);

            // dd($now);
            return redirect()->back()->with('status', 'Data berhasil diupdate');
        }elseif ($status == "13"){
            DB::table('Xts_vehicleorderformExtensionBase')
                ->where('Xts_vehicleorderformcode', $query)
                ->update([
                    'xts_approvename' => 'kacab',
                    'Xts_status' => $request->status,
                    'xts_approvaldiscount'=>4,
                    'xts_appdistime' => $now
                ]);

            // dd($now);
            return redirect()->back()->with('status', 'Data berhasil diupdate');
        } elseif ($status == "1"){
            DB::table('Xts_vehicleorderformExtensionBase')
                ->where('Xts_vehicleorderformcode', $query)
                ->update([
                    'xts_approvename' => 'kacab',
                ]);

            $this->broadcastMessageToOperationManager($getKacab, 'Kacab PassOn Approval');
            dd('Data dikirim ke OM dengan notif pass on');
        }
        
        // dd($now);
        return redirect()->back()->with('status', 'Data berhasil diupdate');
    }

    public function storeApprovalOm(Request $request, $query)
    {
        $now = date('Y-m-d H:i:s');
        $getSPK = DB::table('Xts_vehicleorderformExtensionBase')
            ->select('Xts_vehicleorderformExtensionBase.Xts_vehicleorderformcode')
            ->where('Xts_vehicleorderformcode', $query)
            ->pluck('Xts_vehicleorderformcode');
        $strSPK = substr($getSPK, 2, 2);
        if ($strSPK == 'BD') {
            $strNama = 'kacabbd';
        }elseif ($strSPK == 'CT') {
            $strNama = 'kacabct';
        }elseif ($strSPK == 'GS') {
            $strNama = 'kacabgs';
        }elseif ($strSPK == 'GG') {
            $strNama = 'kacabgg';
        }elseif ($strSPK == 'PD') {
            $strNama = 'kacabpd';
        }elseif ($strSPK == 'TD') {
            $strNama = 'kacabtd';
        } else {
            $strNama = 'kacabkt';
        }
        
        $status = $request->status;
        if ($status == "12") {
            DB::table('Xts_vehicleorderformExtensionBase')
                ->where('Xts_vehicleorderformcode', $query)
                ->update([
                    'xts_approvename' => 'OM',
                    'Xts_status' => $request->status,
                    'xts_approvaldiscount'=>3,
                    'xts_appdistime' => $now
                ]);

            $this->broadcastMessageToKacab('OM', 'OM Approved Approval', $strNama);
            // dd('Data dikirim ke kacab dengan notif Approve');
        }elseif ($status == "13"){
            DB::table('Xts_vehicleorderformExtensionBase')
                ->where('Xts_vehicleorderformcode', $query)
                ->update([
                    'xts_approvename' => 'OM',
                    'Xts_status' => $request->status,
                    'xts_approvaldiscount'=>4,
                    'xts_appdistime' => $now
                ]);
                
            $this->broadcastMessageToKacab('OM', 'OM Rejected Approval', $strNama);
            // dd('Data dikirim ke kacab dengan notif Reject');
        } elseif ($status == "1"){
            DB::table('Xts_vehicleorderformExtensionBase')
                ->where('Xts_vehicleorderformcode', $query)
                ->update([
                    'xts_approvename' => 'OM',
                ]);
            
            $this->broadcastMessageToDirektur('OM', 'OM PassOn Approval');
            // dd('Data Dikirim ke Direktur');
        }
        
        // dd($now);
        return redirect()->back()->with('status', 'Data berhasil diupdate');
    }

    public function storeApprovalDirektur(Request $request, $query)
    {
        $now = date('Y-m-d H:i:s');
        $getSPK = DB::table('Xts_vehicleorderformExtensionBase')
            ->select('Xts_vehicleorderformExtensionBase.Xts_vehicleorderformcode')
            ->where('Xts_vehicleorderformcode', $query)
            ->pluck('Xts_vehicleorderformcode');
        $strSPK = substr($getSPK, 2, 2);
        if ($strSPK == 'BD') {
            $strNama = 'kacabbd';
        }elseif ($strSPK == 'CT') {
            $strNama = 'kacabct';
        }elseif ($strSPK == 'GS') {
            $strNama = 'kacabgs';
        }elseif ($strSPK == 'GG') {
            $strNama = 'kacabgg';
        }elseif ($strSPK == 'PD') {
            $strNama = 'kacabpd';
        }elseif ($strSPK == 'TD') {
            $strNama = 'kacabtd';
        } else {
            $strNama = 'kacabkt';
        }
        $status = $request->status;
        if ($status == "12") {
            DB::table('Xts_vehicleorderformExtensionBase')
                ->where('Xts_vehicleorderformcode', $query)
                ->update([
                    'xts_approvename' => 'Direktur',
                    'Xts_status' => $request->status,
                    'xts_approvaldiscount'=>3,
                    'xts_appdistime' => $now
                ]);

            // dd($now);
            return redirect()->back()->with('status', 'Data berhasil diupdate');
        }elseif ($status == "13"){
            DB::table('Xts_vehicleorderformExtensionBase')
                ->where('Xts_vehicleorderformcode', $query)
                ->update([
                    'xts_approvename' => 'Direktur',
                    'Xts_status' => $request->status,
                    'xts_approvaldiscount'=>4,
                    'xts_appdistime' => $now
                ]);

            $this->broadcastMessageToKacab('Direktur', 'Direktur Rejected Approval', $strNama);
            $this->broadcastMessageToOperationManager('Direktur', 'Direktur Reject Approval');
            // dd('data dikirim ke Kacab dan OM dengan notif Reject');
        } elseif ($status == "1"){
            DB::table('Xts_vehicleorderformExtensionBase')
                ->where('Xts_vehicleorderformcode', $query)
                ->update([
                    'xts_approvename' => 'Direktur',
                ]);

            // dd($now);
        }
        
        // dd($now);
        return redirect()->back()->with('status', 'Data berhasil diupdate');
    }

    private function broadcastMessageToKacab($senderName, $message, $toName)
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

        $tokens = DB::table('tblFcmUserApprovalDiskon')-> where('name', '=', $toName)->pluck('fcm_token')->toArray();
        // dd($tokens);
        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
        // dd($downstreamResponse);

        return $downstreamResponse->numberSuccess();
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
        
        $registrationIds = array('cF-WRMo7Wmc8wsLwLeM-G8:APA91bGvI2C-ZEnuVsloFmLpR5f0BHGBt0sh1Ktq3kyp4rWGWpjFcsk0EuPruNiCF8J2ke3L4os_WDkI_apJOCmNH6MQ_yZs7Si7k1A0Y31vcPWzW_e6ALFn4Zz9WJafZgW5SFoi2Esf', 'ewgtOSgIf0dKXnqkRarWO_:APA91bEAbk0z8tKSSv31Eyt9Eh8afyLSGHrr_RV4d5kVKCaMrKsMZD2DddCShfL4DbuzT2UU3gtUjqPOIBdXd0tCvWoyKfjQbjE6zUEIIQP3lgoH6m4FXwT8r3RdplvdoXpMD13HJh7A'); //Laptop andi dan ikram
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
