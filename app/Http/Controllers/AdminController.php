<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Participant;
use App\Dependant;
use App\Member;
use App\Staff;

class AdminController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    return view('admin.index');
  }

  public function dependants_ajax($pid)
  {
    $dependants = Participant::withTrashed()->find($pid)->dependants();
    return datatables()->of($dependants)->make(true);
  }
  //===================================PAYMENT START===============================//

  public function payment()
  {
    $count['total'] =  Participant::count();

    //$count['spouse'] = Dependant::whereRelationship('Spouse')->count();
    $count['kids'] = Dependant::family()->kids()->count();
    //including spouse. assuming spouse always adult
    $count['family_adult'] = Dependant::family()->adult()->count();
    $count['infant'] = Dependant::family()->infant()->count();
    $count['adult'] = $count['total'] + $count['family_adult'];

    $count['all'] = $count['adult'] + $count['kids'] + $count['infant'];

    $count['others_adult'] = Dependant::others()->adult()->count();
    $count['others_kids'] = Dependant::others()->kids()->count();
    $count['others_infant'] = Dependant::others()->infant()->count();

    $count['others_total'] = $count['others_adult'] + $count['others_kids'] + $count['others_infant'];

    $payment['pending'] =  Participant::wherePaymentStatus('Pending')->count();
    $payment['paid'] =  Participant::wherePaymentStatus('Paid')->count();

    return view('admin.payment', compact('count', 'payment'));
  }

  public function payment_ajax()
  {
    $p = Participant::with(['payment'])->latest();

    return datatables()->of($p)
      ->removeColumn('member')
      ->addColumn('action', function ($p) {
        $disabled = ($p->payment_status == 'Paid') ? 'disabled' : '';

        $href = '<div class="btn-group btn-group-sm" role="group" aria-label="...">';

        $href .= '<a href="' . route('registration_show', ['slug' => $p->slug()]) . '" data-pid="' . $p->id . '" id="view-' . $p->id . '" class="btn btn-primary btn-view" role="button" target="_blank" title="View registration summary &amp; details"><i class="glyphicon glyphicon-qrcode"></i></a>';
        $href .= '<button type="button" data-pid="' . $p->id . '" id="edit-' . $p->id . '" class="btn btn-primary btn-edit" title="Update payment details" ' . $disabled . '><i class="glyphicon glyphicon-edit"></i></button>';

        $href .= '</div>';
        return $href;
      })
      ->addColumn('details_url', function ($p) {
        return route('admin_dependants_ajax', ['pid' => $p->id]);
      })
      ->setRowClass(function ($p) {
        return $p->member == 1 ? 'member' : '';
      })
      ->make(true);
  }

  public function paymentUpdate(Request $request)
  {
    $p = Participant::find($request->pid);
    $p->payment_status = 'Paid';
    $p->payment_details = $request->details;
    $p->payment_timestamp = now();
    $p->payment_by = auth()->user()->id;
    $p->save();
    return $p->payment_status;
  }

  //===================================PAYMENT END===============================//

  //===================================ATTEND START==============================//
  public function attend()
  {
    $count['total'] =  Participant::wherePaymentStatus('Paid')->count();

    $count['family_adults'] = Dependant::whereHas('participant', function ($query) {
      $query->wherePaymentStatus('Paid');
    })->family()->adult()->count();
    $count['kids'] = Dependant::whereHas('participant', function ($query) {
      $query->wherePaymentStatus('Paid');
    })->family()->kids()->count();
    $count['infant'] = Dependant::whereHas('participant', function ($query) {
      $query->wherePaymentStatus('Paid');
    })->family()->infant()->count();
    $count['others_adult'] = Dependant::whereHas('participant', function ($query) {
      $query->wherePaymentStatus('Paid');
    })->others()->adult()->count();
    $count['others_kids'] = Dependant::whereHas('participant', function ($query) {
      $query->wherePaymentStatus('Paid');
    })->others()->kids()->count();
    $count['others_infant'] = Dependant::whereHas('participant', function ($query) {
      $query->wherePaymentStatus('Paid');
    })->others()->infant()->count();

    $count['adult'] = $count['total'] + $count['family_adults'];
    $count['all'] = $count['adult'] + $count['kids'];

    $count['others_total'] = $count['others_adult'] + $count['others_kids'] + $count['others_infant'];

    $member['yes'] =  Participant::whereMember(true)->wherePaymentStatus('Paid')->count();
    $member['no'] =  Participant::whereMember(false)->wherePaymentStatus('Paid')->count();

    $attendance['yes'] =  Participant::whereAttend(true)->wherePaymentStatus('Paid')->count();
    $attendance['no'] =  Participant::whereAttend(false)->wherePaymentStatus('Paid')->count();

    return view('admin.attend', compact('count', 'attendance', 'member'));
  }

  public function attend_ajax()
  {
    $p = Participant::select(['id', 'name', 'email', 'staff_id', 'member', 'attend'])
      ->wherePaymentStatus('Paid');

    return datatables()->of($p)
      ->removeColumn('member')
      ->addColumn('action', function ($p) {
        $href = '<div class="btn-group btn-group-sm" role="group" aria-label="...">';

        $href .= '<a href="' . route('registration_show', ['slug' => $p->slug()]) . '" data-pid="' . $p->id . '" id="view-' . $p->id . '" class="btn btn-primary btn-view" target="_blank"><i class="glyphicon glyphicon-qrcode"></i></a>';

        return $href;
      })
      ->addColumn('details_url', function ($p) {
        return route('admin_dependants_ajax', ['pid' => $p->id]);
      })
      ->setRowClass(function ($p) {
        if ($p->member == 1 && $p->attend == 1)
          return 'member attend';
        else if ($p->member == 1 && $p->attend == 0)
          return 'member';
        else if ($p->member == 0 && $p->attend == 1)
          return 'attend';
      })
      ->make(true);
  }

  //===================================ATTEND ENDS==============================//

  public function attend_full()
  {
    $count['total'] =  Participant::wherePaymentStatus('Paid')->count();

    $count['family_adults'] = Dependant::whereHas('participant', function ($query) {
      $query->wherePaymentStatus('Paid');
    })->family()->adult()->count();
    $count['kids'] = Dependant::whereHas('participant', function ($query) {
      $query->wherePaymentStatus('Paid');
    })->family()->kids()->count();
    $count['infant'] = Dependant::whereHas('participant', function ($query) {
      $query->wherePaymentStatus('Paid');
    })->family()->infant()->count();
    $count['others_adult'] = Dependant::whereHas('participant', function ($query) {
      $query->wherePaymentStatus('Paid');
    })->others()->adult()->count();
    $count['others_kids'] = Dependant::whereHas('participant', function ($query) {
      $query->wherePaymentStatus('Paid');
    })->others()->kids()->count();
    $count['others_infant'] = Dependant::whereHas('participant', function ($query) {
      $query->wherePaymentStatus('Paid');
    })->others()->infant()->count();

    $count['adult'] = $count['total'] + $count['family_adults'];
    $count['all'] = $count['adult'] + $count['kids'];

    $count['others_total'] = $count['others_adult'] + $count['others_kids'] + $count['others_infant'];

    $member['yes'] =  Participant::whereMember(true)->wherePaymentStatus('Paid')->count();
    $member['no'] =  Participant::whereMember(false)->wherePaymentStatus('Paid')->count();

    $attendance['yes'] =  Participant::whereAttend(true)->wherePaymentStatus('Paid')->count();
    $attendance['no'] =  Participant::whereAttend(false)->wherePaymentStatus('Paid')->count();

    return view('admin.attendFull', compact('count', 'attendance', 'member'));
  }

  public function attend_full_ajax()
  {
    $p = Participant::select(['id', 'name', 'email', 'staff_id', 'member', 'attend'])
      ->latest()
      ->wherePaymentStatus('Paid')
      ->withCount([
        'dependants as spouse' => function ($query) {
          $query->whereRelationship('Spouse');
        },
        'adultsFamily',
        'kidsFamily',
        'infantsFamily',
        'othersAdults',
        'othersKids',
        'othersInfants',
        'adults',
        'kids',
        'infants'
      ]);

    return datatables()->of($p)
      ->removeColumn('member')
      ->addColumn('action', function ($p) {
        $href = '<div class="btn-group btn-group-sm" role="group" aria-label="...">';

        $href .= '<a href="' . route('registration_show', ['slug' => $p->slug()]) . '" data-pid="' . $p->id . '" id="view-' . $p->id . '" class="btn btn-primary btn-view" target="_blank"><i class="glyphicon glyphicon-qrcode"></i></a>';

        return $href;
      })
      ->addColumn('details_url', function ($p) {
        return route('admin_dependants_ajax', ['pid' => $p->id]);
      })
      ->editColumn('adults_family_count', '{{$adults_family_count+1}}')
      ->setRowClass(function ($p) {
        if ($p->member == 1 && $p->attend == 1)
          return 'member attend';
        else if ($p->member == 1 && $p->attend == 0)
          return 'member';
        else if ($p->member == 0 && $p->attend == 1)
          return 'attend';
      })
      ->make(true);
  }

  //===================================ATTEND ENDS==============================//

  //================================REGISTRATIONS START=========================//

  public function user()
  {
    $count['total'] =  Participant::count();

    //$count['spouse'] = Dependant::whereRelationship('Spouse')->count();
    $count['kids'] = Dependant::family()->kids()->count();
    //including spouse. assuming spouse always adult
    $count['family_adult'] = Dependant::family()->adult()->count();
    $count['infant'] = Dependant::family()->infant()->count();
    $count['adult'] = $count['total'] + $count['family_adult'];

    $count['all'] = $count['adult'] + $count['kids'] + $count['infant'];

    $count['others_adult'] = Dependant::others()->adult()->count();
    $count['others_kids'] = Dependant::others()->kids()->count();
    $count['others_infant'] = Dependant::others()->infant()->count();

    $count['others_total'] = $count['others_adult'] + $count['others_kids'] + $count['others_infant'];

    $member['yes'] =  Participant::whereMember(true)->count();
    $member['no'] =  Participant::whereMember(false)->count();

    return view('admin.user', compact('count', 'member'));
  }

  public function user_ajax()
  {
    $p = Participant::select(['id', 'name', 'email', 'staff_id', 'member']);

    return datatables()->of($p)
      ->addColumn('action', function ($p) {
        $href = '<div class="btn-group btn-group-sm" role="group" aria-label="...">';

        $href .= '<a href="' . route('registration_show', ['slug' => $p->slug()]) . '" data-pid="' . $p->id . '" id="view-' . $p->id . '" class="btn btn-primary btn-view" target="_blank" title="View registration summary &amp; details"><i class="glyphicon glyphicon-qrcode"></i></a>';
        $href .= '<button type="button" class="btn btn-primary btn-prompt" data-type="email" data-pid="' . $p->id . '" title="Resend confimation email to the registered email address"><i class="glyphicon glyphicon-envelope"></i></button>';
        $href .= '<button type="button" class="btn btn btn-primary btn-prompt" data-type="delete" data-pid="' . $p->id . '" title="Delete the registration  "><i class="glyphicon glyphicon-trash"></i></button>';

        $href .= '</div>';

        return $href;
      })
      //->editColumn('adults_count','{{$adults_count+1}}')
      //->editColumn('adults_family_count','{{$adults_family_count+1}}')
      ->setRowClass(function ($p) {
        return $p->member == 1 ? 'member' : '';
      })
      ->make(true);
  }

  public function user_deleted()
  {
    $count['total'] =  Participant::onlyTrashed()->count();

    //$count['spouse'] = Dependant::whereRelationship('Spouse')->count();
    $count['kids'] = Dependant::onlyTrashed()->family()->kids()->count();
    //including spouse. assuming spouse always adult
    $count['family_adult'] = Dependant::onlyTrashed()->family()->adult()->count();
    $count['infant'] = Dependant::onlyTrashed()->family()->infant()->count();
    $count['adult'] = $count['total'] + $count['family_adult'];

    $count['all'] = $count['adult'] + $count['kids'] + $count['infant'];

    $count['others_adult'] = Dependant::onlyTrashed()->others()->adult()->count();
    $count['others_kids'] = Dependant::onlyTrashed()->others()->kids()->count();
    $count['others_infant'] = Dependant::onlyTrashed()->others()->infant()->count();

    $count['others_total'] = $count['others_adult'] + $count['others_kids'] + $count['others_infant'];

    $member['yes'] =  Participant::onlyTrashed()->whereMember(true)->count();
    $member['no'] =  Participant::onlyTrashed()->whereMember(false)->count();

    return view('admin.deleted', compact('count', 'member'));
  }

  public function user_deleted_ajax()
  {
    $p = Participant::onlyTrashed()->with('softDeletedBy:id,name');

    return datatables()->of($p)
      ->addColumn('action', function ($p) {
        $href = '<div class="btn-group btn-group-sm" role="group" aria-label="...">';

        $href .= '<a href="' . route('registration_show', ['slug' => $p->slug()]) . '" data-pid="' . $p->id . '" id="view-' . $p->id . '" class="btn btn-primary btn-view" target="_blank" title="View registration summary &amp; details"><i class="glyphicon glyphicon-qrcode"></i></a>';
        if ($p->deleted_at <> NULL) {
          $href .= '<button type="button" class="btn btn-primary btn-prompt" data-type="email" data-pid="' . $p->id . '" title="Resend confimation email to the registered email address"><i class="glyphicon glyphicon-envelope"></i></button>';
          $href .= '<button type="button" class="btn btn btn-primary btn-prompt" data-type="delete" data-pid="' . $p->id . '" title="Delete the registration  "><i class="glyphicon glyphicon-trash"></i></button>';
        }
        $href .= '</div>';
        return $href;
      })
      ->editColumn('soft_deleted_by.name', function ($p) {
        return ucwords(strtolower($p->softDeletedBy->name));
      })
      ->setRowClass(function ($p) {
        return $p->member == 1 ? 'member' : '';
      })
      ->make(true);
  }

  //================================REGISTRATIONS ENDS=========================//

  //================================MEMBER START=========================//

  public function member(Request $request)
  {
    if ($request->ajax()) {
      $m = Member::all();
      return datatables()->of($m)->make(true);
    }
    return view('admin.member');
  }

  //================================MEMBER ENDS=========================//

  //================================STAFF START=========================//

  public function staff(Request $request)
  {
    if ($request->ajax()) {
      $s = Staff::all();
      return datatables()->of($s)->make(true);
    }
    return view('admin.staff');
  }

  //================================STAFF ENDS=========================//

  /**
   * Process datatables ajax request.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function user_ajax_old()
  {
    $p = Participant::select(['id', 'name', 'email', 'staff_id', 'member'])->latest()
      ->withCount([
        'dependants as spouse' => function ($query) {
          $query->where('relationship', 'Spouse');
        },
        'dependants as kids' => function ($query) {
          $query->whereIn('relationship', ['Kids', 'Infant'])
            ->whereBetween('age', [3, 10]);
        },
        'dependants as infant' => function ($query) {
          $query->whereIn('relationship', ['Kids', 'Infant'])
            ->where('age', '<', 3);
        },
        'dependants as others_adult' => function ($query) {
          $query->where('relationship', 'Others')
            ->where('age', '>', 11);
        },
        'dependants as others_kids' => function ($query) {
          $query->where('relationship', 'Others')
            ->whereBetween('age', [3, 10]);
        },
        'dependants as others_infant' => function ($query) {
          $query->where('relationship', 'Others')
            ->where('age', '<', 3);
        },
        'dependants as sum_adult' => function ($query) {
          $query->where('relationship', 'Spouse')
            ->orWhere(function ($query) {
              $query->whereIn('relationship', ['Kids', 'Infant', 'Others'])
                ->where('age', '>=', 11);
            });
        },
        'dependants as sum_kids' => function ($query) {
          $query->whereIn('relationship', ['Kids', 'Infant', 'Others'])
            ->whereBetween('age', [3, 10]);
        },
        'dependants as sum_infant' => function ($query) {
          $query->whereIn('relationship', ['Kids', 'Infant', 'Others'])
            ->where('age', '<', 3);
        },
        'dependants as adult' => function ($query) {
          $query->where('relationship', 'Spouse')
            ->orWhere(function ($query) {
              $query->whereIn('relationship', ['Kids', 'Infant'])
                ->where('age', '>=', 11);
            });
        }
      ])
      ->get();

    return datatables()->of($p)
      ->addColumn('action', function ($p) {
        $href = '<a href="' . route('registration_show', ['slug' => $p->slug()]) . '" data-pid="' . $p->id . '" id="view-' . $p->id . '" class="btn btn-xs btn-primary btn-view" target="_blank" title="View"><i class="glyphicon glyphicon-qrcode"></i> View</a>';
        $href .= ' <a href="#" data-pid="' . $p->id . '" class="btn btn-xs btn-primary btn-email"><i class="glyphicon glyphicon-envelope" title="Resend confimation email."></i> Resend</a>';

        return $href;
      })
      ->editColumn('sum_adult_count', '{{$sum_adult_count+1}}')
      ->setRowClass(function ($p) {
        return $p->member == 1 ? 'member' : '';
      })
      ->make(true);
  }

  /**
   * Process datatables ajax request.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function attend_ajax_old()
  {
    $p = Participant::select(['id', 'name', 'email', 'staff_id', 'attend', 'member'])
      ->where('payment_status', '=', 'Paid')
      ->withCount([
        'dependants as kids' => function ($query) {
          $query->whereIn('relationship', ['Kids']);
        },
        'dependants as infant' => function ($query) {
          $query->whereIn('relationship', ['Infant']);
        },
        'dependants as others_adult' => function ($query) {
          $query->where('relationship', 'Others')
            ->where('age', '>', 11);
        },
        'dependants as others_kids' => function ($query) {
          $query->where('relationship', 'Others')
            ->whereBetween('age', [3, 10]);
        },
        'dependants as others_infant' => function ($query) {
          $query->where('relationship', 'Others')
            ->where('age', '<', 3);
        },
        'dependants as sum_adult' => function ($query) {
          $query->where('relationship', 'Spouse')
            ->orWhere(function ($query) {
              $query->where('relationship', 'Others')
                ->where('age', '>=', 11);
            });
        },
        'dependants as sum_kids' => function ($query) {
          $query->where('relationship', 'Kids')
            ->orWhere(function ($query) {
              $query->where('relationship', 'Others')
                ->whereBetween('age', [3, 10]);
            });
        }
      ])
      ->get();

    return datatables()->of($p)
      ->removeColumn('member')
      ->addColumn('action', function ($p) {
        return '<a href="' . route('registration_show', ['slug' => $p->slug()]) . '" data-pid="' . $p->id . '" id="view-' . $p->id . '" class="btn btn-xs btn-primary btn-view" target="_blank"><i class="glyphicon glyphicon-qrcode"></i> View</a>';
      })
      ->addColumn('details_url', function ($p) {
        return route('admin_dependants_ajax', ['pid' => $p->id]);
      })
      ->editColumn('sum_adult_count', '{{$sum_adult_count+1}}')
      ->setRowClass(function ($p) {
        if ($p->member == 1 && $p->attend == 1)
          return 'member attend';
        else if ($p->member == 1 && $p->attend == 0)
          return 'member';
        else if ($p->member == 0 && $p->attend == 1)
          return 'attend';
      })
      ->make(true);
  }
}
