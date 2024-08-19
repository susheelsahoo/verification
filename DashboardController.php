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

    public function _group_by($array, $key) {
        $return = array();
        foreach($array as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }


    public function index()
    {
        if (is_null($this->user) || !$this->user->can('dashboard.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view dashboard !');
        }

        $total_roles = count(Role::select('id')->get());
        $total_admins = count(Admin::select('id')->get());
        $total_permissions = count(Permission::select('id')->get());
        $total_Unassigned  = count(casesFiType::select('id')->where('user_id', '0')->get());
        $agentLists = User::where('admin_id',$this->user->id)->get();
        $getCases = Cases::get();

        $userwise=[];
        if($getCases){
            $cases = $getCases->toArray();
            $userwise = $this->_group_by($cases,'created_by');
        }

        $userCount = [];
        $totalSum = [];
        $inprogressTotal = $resolveTotal = $verifiedTotal = $rejectedTotal = 0;
        if($userwise){
            foreach($userwise as $key=> $userData){
                $inprogress = $resolve = $verified = $rejected = 0;
                foreach($userData as $data){
                    switch($data->status){
                        case 0:
                            $inprogress += 1;
                        break;

                        case 1:
                            $resolve += 1;
                        break;

                        case 2:
                            $verified += 1;
                        break;

                        case 3:
                            $rejected += 1;
                        break;

                        default:
                    }
                }
                $userCount[$key]['created_by'] = $key;
                $userCount[$key]['inprogress'] = $inprogress;
                $userCount[$key]['resolve'] = $resolve;
                $userCount[$key]['verified'] = $verified;
                $userCount[$key]['rejected'] = $rejected;
                $inprogressTotal += $inprogress;
                $resolveTotal  += $resolve;
                $verifiedTotal += $verified;
                $rejectedTotal += $rejected;
            }
        }

        $totalSum = ['inprogressTotal'=>$inprogressTotal,'resolveTotal'=>$resolveTotal,'verifiedTotal'=>$verifiedTotal,'rejectedTotal'=>$rejectedTotal];

        return view('backend.pages.dashboard.index', compact('total_admins', 'total_roles', 'total_permissions', 'total_Unassigned','agentLists','userCount','totalSum'));
    }
}
