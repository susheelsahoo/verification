<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\casesFiType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Cases;
use DateTime;

class DashboardController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    public function _group_by($array, $key)
    {
        $return = array();
        foreach ($array as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }


    public function index()
    {
        if (is_null($this->user) || !$this->user->can('dashboard.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view dashboard !');
        }

        $total_roles        = count(Role::select('id')->get());
        $total_admins       = count(Admin::select('id')->get());
        $total_permissions  = count(Permission::select('id')->get());
        $total_Unassigned   = count(casesFiType::select('id')->where('user_id', '0')->where('status', '0')->get());
        $total_dedup        = count(casesFiType::select('id')->where('status', '8')->get());
        $agentLists         = User::where('admin_id', $this->user->id)->get();
        $getCases           = casesFiType::with('getuser')->where('user_id', '!=', '0')->get();


        $userwise = [];
        if ($getCases) {
            $cases = $getCases->toArray();
            $userwise = $this->_group_by($cases, 'user_id');
        }

        $userCount = [];
        $totalSum = [];
        $total = $inprogressTotal = $positive_resolvedTotal = $negative_resolvedTotal = $positive_verifiedTotal = $negative_verifiedTotal = $holdTotal = 0;
        if ($userwise) {
            foreach ($userwise as $key => $userData) {
                $inprogress = $positive_resolved = $negative_resolved = $positive_verified = $negative_verified = $hold = $close = 0;
                $agentName  = $userData['0']['getuser']['name'];
                $agentid    = $userData['0']['getuser']['id'];
                $today = new DateTime();
                foreach ($userData as $data) {
                    $updatedAt = new DateTime($data['updated_at']);

                    switch ($data['status']) {
                        case 1:
                            $inprogress += 1;
                            break;

                        case 2:
                            if ($updatedAt->format('Y-m-d') === $today->format('Y-m-d')) {
                                $positive_resolved += 1;
                            }
                            break;

                        case 3:
                            if ($updatedAt->format('Y-m-d') === $today->format('Y-m-d')) {
                                $negative_resolved += 1;
                            }
                            break;

                        case 4:
                            if ($updatedAt->format('Y-m-d') === $today->format('Y-m-d')) {
                                $positive_verified += 1;
                            }
                            break;
                        case 5:
                            if ($updatedAt->format('Y-m-d') === $today->format('Y-m-d')) {
                                $negative_verified += 1;
                            }
                            break;
                        case 6:
                            $hold += 1;
                            break;
                        case 7:
                            if ($updatedAt->format('Y-m-d') === $today->format('Y-m-d')) {
                                $close += 1;
                            }
                            break;
                        default:
                    }
                }
                $userCount[$key]['created_by']          = $key;
                $userCount[$key]['agentid']             = $agentid;
                $userCount[$key]['agentName']           = $agentName;
                $userCount[$key]['inprogress']          = $inprogress;
                $userCount[$key]['positive_resolved']   = $positive_resolved;
                $userCount[$key]['negative_resolved']   = $negative_resolved;
                $userCount[$key]['positive_verified']   = $positive_verified;
                $userCount[$key]['negative_verified']   = $negative_verified;
                $userCount[$key]['hold']                = $hold;
                $userCount[$key]['total']               = $inprogress + $positive_resolved + $negative_resolved + $positive_verified + $negative_verified + $hold;

                $total += $inprogress + $positive_resolved + $negative_resolved + $positive_verified + $negative_verified + $hold;
                $inprogressTotal        += $inprogress;
                $positive_resolvedTotal += $positive_resolved;
                $negative_resolvedTotal += $negative_resolved;
                $positive_verifiedTotal += $positive_verified;
                $negative_verifiedTotal += $negative_verified;
                $holdTotal              += $hold;
            }
        }

        $totalSum = ['total' => $total, 'inprogressTotal' => $inprogressTotal, 'positive_resolvedTotal' => $positive_resolvedTotal, 'negative_resolvedTotal' => $negative_resolvedTotal, 'positive_verifiedTotal' => $positive_verifiedTotal, 'negative_verifiedTotal' => $negative_verifiedTotal, 'holdTotal' => $holdTotal];


        return view('backend.pages.dashboard.index', compact('totalSum', 'userCount', 'agentLists', 'total_Unassigned', 'total_dedup'));
    }
}
