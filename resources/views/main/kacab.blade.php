@extends('layouts.app')

@section('content')
<div class="container">
    <h5 >Dashboard Kacab
        {{-- @if (Auth::user()->cabang != NULL)
            {{Auth::user()->cabang}}
        @else
            kacab
        @endif  --}}
        {{Auth::user()->cabang}}
    </h5>
    @if (session('status'))
        <div class="card">
            <div class="card-header">
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert">×</button>
                </div>
            </div>
        </div>
    @endif
    <div class="table-with-scrollbar">
        <table cellspacing="0" class="table table-striped table-bordered table-hover">
            <thead>
                <tr style='color:white; background: rgba(0, 123, 255, 0.7)' >
                    <th style="min-width: 120px !important; border-radius: 15px 0 0 0;">Nomor SPK/ Tanggal</th>
                    <th>Nama Customer</th>
                    <th>Nama Wiraniaga</th>
                    <th>Tipe Kendaraan</th>
                    <th>Warna</th>
                    <th>Cara Pembelian</th>
                    <th>Discount Unit</th>
                    <th>Discount Aksesories</th>
                    <th>Discount Mediator</th>
                    <th>Nama Mediator</th>
                    <th>Discount Total</th>
                    <th>Status Approval</th>
                    <th style="border-radius: 0 15px 0 0;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $datas)
                    <!-- KOMEN INI JANGAN DIHAPUS  -->
                    <!-- {{$alasanDiscount = strtoupper($datas->AlasanDiscount)}} -->
                    <!-- {{$prodName = strtoupper($datas->ProdName)}} -->
                    <!-- {{$warnaMobil = strtoupper($datas->WarnaMobil)}} -->
                    <!-- {{$tipeBayar = strtoupper($datas->tipebayar)}} -->
                    <!-- {{$discountUnit = number_format((int)$datas->DiscountUnit)}} -->
                    <!-- {{$discountAcc = number_format((int)$datas->DiscountAcc)}} -->
                    <!-- {{$Acc = strtoupper($datas->Acc)}} -->
                    <!-- {{$discountMediator = number_format((int)$datas->DiscountMediator)}} -->
                    <!-- {{$total = number_format((int)$datas->DiscountUnit + (int)$datas->DiscountAcc + (int)$datas->DiscountMediator)}} -->
                    <!-- {{$selisih = number_format((int)$datas->selisih)}} -->

                    
                    <!-- {{$approve = ($datas->nama)}} -->
                    <!-- {{$cekapprove = ($datas->approvalperson)}} -->
                    @if (($approve == "kacab" && $cekapprove=="Direktur") || ($approve == "kacab" && $cekapprove == "OM approval VSO"))
                    <form action="{{ url('/approveKacab') }}/{{ $datas->NoSPK }}" method="post">
                        @csrf
                        <tr style='background:rgba(255, 71, 87, 1); color:white;'>
                            <td style="width: ">{{ $datas->NoSPK }} <br> {{ $datas->TanggalSPK }} <br>
                                <a tabindex="0" class="btn btn-sm btn-outline-warning" role="button" data-toggle="popover" data-trigger="focus" title="Alasan Diskon" data-content="{{ $alasanDiscount }}"> Alasan</a>
                            </td>
                            <td>{{ $datas->CustName }}</td>
                            <td>{{ $datas->SalesCode }}</td>
                            <td>{{ $prodName }}</td>
                            <td>{{ $warnaMobil }}</td>
                            @if ($tipeBayar == 'CREDIT')
                                <td>{{ $datas->tipebayar }} / {{ $datas->leasing }}</td>
                            @else
                                <td>{{ $datas->tipebayar }}</td>
                            @endif
                            <td>Rp.{{ $discountUnit }}</td>
                            <td>Rp.{{ $discountAcc }}
                                @if ( $Acc == '')
                                    <div>{{ $Acc }}</div>
                                @else
                                    <div class="btn btn-outline-light btn-sm">{{ $Acc }}</div>
                                @endif
                            </td>
                            <td>Rp.{{ $discountMediator }}</td>
                            <td>{{ $datas->NamaMediator }} {{ $datas->NamaMediator2 }}</td>
                            <td>Rp.{{ $total }}
                                @if ($selisih == 0)
                                    <div></div>
                                @else
                                    <div class='bg-primary' style='font-weight:bold !important;'><i>{{ $selisih }}</i></div>
                                @endif
                            </td>
                            <td>Waiting OM</td>
                            <td></td>
                        </tr>
                    </form>
                    @elseif ($approve == "OM" && $cekapprove == "Direktur")
                    <form action="{{ url('/approveKacab') }}/{{ $datas->NoSPK }}" method="post">
                        @csrf
                        <tr style='background:rgba(255, 71, 87, 1); color:white;'>
                            <td style="width: ">{{ $datas->NoSPK }} <br> {{ $datas->TanggalSPK }} <br>
                                <a tabindex="0" class="btn btn-sm btn-outline-warning" role="button" data-toggle="popover" data-trigger="focus" title="Alasan Diskon" data-content="{{ $alasanDiscount }}"> Alasan</a>
                            </td>
                            <td>{{ $datas->CustName }}</td>
                            <td>{{ $datas->SalesCode }}</td>
                            <td>{{ $prodName }}</td>
                            <td>{{ $warnaMobil }}</td>
                            @if ($tipeBayar == 'CREDIT')
                                <td>{{ $datas->tipebayar }} / {{ $datas->leasing }}</td>
                            @else
                                <td>{{ $datas->tipebayar }}</td>
                            @endif
                            <td>Rp.{{ $discountUnit }}</td>
                            <td>Rp.{{ $discountAcc }}
                                @if ( $Acc == '')
                                    <div>{{ $Acc }}</div>
                                @else
                                    <div class="btn btn-outline-light btn-sm">{{ $Acc }}</div>
                                @endif
                            </td>
                            <td>Rp.{{ $discountMediator }}</td>
                            <td>{{ $datas->NamaMediator }} {{ $datas->NamaMediator2 }}</td>
                            <td>Rp.{{ $total }}
                                @if ($selisih == 0)
                                    <div></div>
                                @else
                                    <div class='bg-primary' style='font-weight:bold !important;'><i>{{ $selisih }}</i></div>
                                @endif
                            </td>
                            <td>Waiting OD</td>
                            <td></td>
                        </tr>
                    </form>
                    @elseif ($approve=="Direktur" && $cekapprove=="Presdir")
                    <form action="{{ url('/approveKacab') }}/{{ $datas->NoSPK }}" method="post">
                        @csrf
                        <tr style='background:#38c172; color:white;'>
                            <td style="width: ">{{ $datas->NoSPK }} <br> {{ $datas->TanggalSPK }} <br>
                                <a tabindex="0" class="btn btn-sm btn-outline-warning" role="button" data-toggle="popover" data-trigger="focus" title="Alasan Diskon" data-content="{{ $alasanDiscount }}"> Alasan</a>
                            </td>
                            <td>{{ $datas->CustName }}</td>
                            <td>{{ $datas->SalesCode }}</td>
                            <td>{{ $prodName }}</td>
                            <td>{{ $warnaMobil }}</td>
                            @if ($tipeBayar == 'CREDIT')
                                <td>{{ $datas->tipebayar }} / {{ $datas->leasing }}</td>
                            @else
                                <td>{{ $datas->tipebayar }}</td>
                            @endif
                            <td>Rp.{{ $discountUnit }}</td>
                            <td>Rp.{{ $discountAcc }}
                                @if ( $Acc == '')
                                    <div>{{ $Acc }}</div>
                                @else
                                    <div class="btn btn-outline-light btn-sm">{{ $Acc }}</div>
                                @endif
                            </td>
                            <td>Rp.{{ $discountMediator }}</td>
                            <td>{{ $datas->NamaMediator }} {{ $datas->NamaMediator2 }}</td>
                            <td>Rp.{{ $total }}
                                @if ($selisih == 0)
                                    <div></div>
                                @else
                                    <div class='bg-primary' style='font-weight:bold !important;'><i>{{ $selisih }}</i></div>
                                @endif
                            </td>
                            <td>Waiting OD</td>
                            <td></td>
                        </tr>
                    </form>
                    @elseif (($cekapprove == "Direktur" || $cekapprove == "Presdir") && $approve==0)
                    <form action="{{ url('/approveKacab') }}/{{ $datas->NoSPK }}" method="post">
                        @csrf
                        <tr>
                            <td style="width: ">{{ $datas->NoSPK }} <br> {{ $datas->TanggalSPK }} <br>
                                <a tabindex="0" class="btn btn-sm btn-warning" role="button" data-toggle="popover" data-trigger="focus" title="Alasan Diskon" data-content="{{ $alasanDiscount }}"> Alasan</a>
                            </td>
                            <td>{{ $datas->CustName }}</td>
                            <td>{{ $datas->SalesCode }}</td>
                            <td>{{ $prodName }}</td>
                            <td>{{ $warnaMobil }}</td>
                            @if ($tipeBayar == 'CREDIT')
                                <td>{{ $datas->tipebayar }} / {{ $datas->leasing }}</td>
                            @else
                                <td>{{ $datas->tipebayar }}</td>
                            @endif
                            <td>Rp.{{ $discountUnit }}</td>
                            <td>Rp.{{ $discountAcc }}
                                @if ( $Acc == '')
                                    <div>{{ $Acc }}</div>
                                @else
                                    <div class="btn-primary btn-sm">{{ $Acc }}</div>
                                @endif
                            </td>
                            <td>Rp.{{ $discountMediator }}</td>
                            <td>{{ $datas->NamaMediator }} {{ $datas->NamaMediator2 }}</td>
                            <td>Rp.{{ $total }}
                                @if ($selisih == 0)
                                    <div></div>
                                @else
                                    <div class='bg-primary' style='font-weight:bold !important;'><i>{{ $selisih }}</i></div>
                                @endif
                            </td>
                            <td style="min-width: 170px !important;">
                                <select name="status" id="" class="form-control">
                                    <option value="11">Need Approval</option>
                                    <option value="1">PassOn OM</option>
                                    <option value="13">Rejected</option>
                                </select>
                            </td>
                            <td>
                                <input type="submit" class="btn btn-primary" value="Submit" />
                            </td>
                        </tr>
                    </form>
                    @elseif ($cekapprove == "OM approval VSO" && $approve == 0)
                    <form action="{{ url('/approveKacab') }}/{{ $datas->NoSPK }}" method="post">
                        @csrf
                        <tr>
                            <td style="width: ">{{ $datas->NoSPK }} <br> {{ $datas->TanggalSPK }} <br>
                                <a tabindex="0" class="btn btn-sm btn-warning" role="button" data-toggle="popover" data-trigger="focus" title="Alasan Diskon" data-content="{{ $alasanDiscount }}"> Alasan</a>
                            </td>
                            <td>{{ $datas->CustName }}</td>
                            <td>{{ $datas->SalesCode }}</td>
                            <td>{{ $prodName }}</td>
                            <td>{{ $warnaMobil }}</td>
                            @if ($tipeBayar == 'CREDIT')
                                <td>{{ $datas->tipebayar }} / {{ $datas->leasing }}</td>
                            @else
                                <td>{{ $datas->tipebayar }}</td>
                            @endif
                            <td>Rp.{{ $discountUnit }}</td>
                            <td>Rp.{{ $discountAcc }}
                                @if ( $Acc == '')
                                    <div>{{ $Acc }}</div>
                                @else
                                    <div class="btn-primary btn-sm">{{ $Acc }}</div>
                                @endif
                            </td>
                            <td>Rp.{{ $discountMediator }}</td>
                            <td>{{ $datas->NamaMediator }} {{ $datas->NamaMediator2 }}</td>
                            <td>Rp.{{ $total }}
                                @if ($selisih == 0)
                                    <div></div>
                                @else
                                    <div class='bg-primary' style='font-weight:bold !important;'><i>{{ $selisih }}</i></div>
                                @endif
                            </td>
                            <td style="min-width: 170px !important;">
                                <select name="status" id="" class="form-control">
                                    <option value="11">Need Approval</option>
                                    <option value="1">PassOn OM</option>
                                    <option value="13">Rejected</option>
                                </select>
                            </td>
                            <td>
                                <input type="submit" class="btn btn-primary" value="Submit" />
                            </td>
                        </tr>
                    </form>
                    @elseif ($cekapprove == "Marketing Professional" || $approve == 0)
                    <form action="{{ url('/approveKacab') }}/{{ $datas->NoSPK }}" method="post">
                        @csrf
                        <tr>
                            <td style="width: ">{{ $datas->NoSPK }} <br> {{ $datas->TanggalSPK }} <br>
                                <a tabindex="0" class="btn btn-sm btn-warning" role="button" data-toggle="popover" data-trigger="focus" title="Alasan Diskon" data-content="{{ $alasanDiscount }}"> Alasan</a>
                            </td>
                            <td>{{ $datas->CustName }}</td>
                            <td>{{ $datas->SalesCode }}</td>
                            <td>{{ $prodName }}</td>
                            <td>{{ $warnaMobil }}</td>
                            @if ($tipeBayar == 'CREDIT')
                                <td>{{ $datas->tipebayar }} / {{ $datas->leasing }}</td>
                            @else
                                <td>{{ $datas->tipebayar }}</td>
                            @endif
                            <td>Rp.{{ $discountUnit }}</td>
                            <td>Rp.{{ $discountAcc }}
                                @if ( $Acc == '')
                                    <div>{{ $Acc }}</div>
                                @else
                                    <div class="btn-primary btn-sm">{{ $Acc }}</div>
                                @endif
                            </td>
                            <td>Rp.{{ $discountMediator }}</td>
                            <td>{{ $datas->NamaMediator }} {{ $datas->NamaMediator2 }}</td>
                            <td>Rp.{{ $total }}
                                @if ($selisih == 0)
                                    <div></div>
                                @else
                                    <div class='bg-primary' style='font-weight:bold !important;'><i>{{ $selisih }}</i></div>
                                @endif
                            </td>
                            <td style="min-width: 170px !important;">
                                <select name="status" id="" class="form-control">
                                    <option value="11">Need Approval</option>
                                    <option value="12">Approved</option>
                                    <option value="13">Rejected</option>
                                </select>
                            </td>
                            <td>
                                <input type="submit" class="btn btn-primary" value="Submit" />
                            </td>
                        </tr>
                    </form>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const messaging = firebase.messaging();
    let vapidkey = '{{env('vapid')}}'
    // Add the public key generated from the console here.
    messaging.getToken({vapidKey: vapidkey});
    function sendTokenToServer(token){
        const user_id = 'kacab'//'{{Auth::user()->id}}';
        const name = 'kacab'//'{{Auth::user()->name}}';
        // console.log(user_id)
        // console.log(token)
        axios.post('/approvaldiskon/api/save_token', {
            token: token,
            user_id: user_id,
            name: name
        })
        .then((response) => {
            console.log(response);
            console.log(token);
        }, (error) => {
            console.log(error);
        })
        // axios.post('/api/save_token', {
        //     token, user_id
        // }).then(res => {
        //     console.log(res);
        // });
    }
    // Get registration token. Initially this makes a network call, once retrieved
    // subsequent calls to getToken will return from cache.
    messaging.getToken({vapidKey: vapidkey}).then((currentToken) => {
    if (currentToken) {
        sendTokenToServer(currentToken);
        // updateUIForPushEnabled(currentToken);
    } else {
        // Show permission request.
        // console.log('No registration token available. Request permission to generate one.');
        // Show permission UI.
        // updateUIForPushPermissionRequired();
        // setTokenSentToServer(false);
    }
    }).catch((err) => {
    console.log('An error occurred while retrieving token. ', err);
    // showToken('Error retrieving registration token. ', err);
    // setTokenSentToServer(false);
    });
</script>
@endsection

