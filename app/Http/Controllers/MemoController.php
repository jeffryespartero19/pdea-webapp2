<?php

namespace App\Http\Controllers;

use Auth;
use App\Audit;
use App\Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class MemoController extends Controller
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

    public function index()
    {
        $data = Memo::all();

        return view('memo.memo_list', compact('data'));
    }

    public function add()
    {
        return view('memo.memo_add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|unique:memo'
        ]);

        date_default_timezone_set('Asia/Manila');
        $date = Carbon::now();

        foreach ($request->file('fileattach') as $file) {
            $filename = $file->getClientOriginalName();
            // $filename = pathinfo($fileinfo, PATHINFO_FILENAME);
            $filePath = public_path() . '/files/uploads/memo/';
            $file->move($filePath, $filename);

            $file_data = array(
                'name' => $request->name,
                'filenames' => $filename,
                'status' => $request->has('status') ? true : false,
            );
            DB::table('memo')->insert($file_data);
        }

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Memo Setup',
            'activity' => 'Add',
            'description' => 'Added ' . $request->name . ' on memo setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully added new memo!');
    }

    public function edit($id)
    {
        $memo = DB::table('memo')->where('id', $id)->get();

        return view('memo.memo_edit', compact('memo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:3'
        ]);
        if ($request->hasfile('fileattach')) {
            if ($request->pfile == null) {
                unlink(public_path('/files/uploads/memo/' . $request->pfile));
            }

            foreach ($request->file('fileattach') as $file) {
                $filename = $file->getClientOriginalName();
                // $filename = pathinfo($fileinfo, PATHINFO_FILENAME);
                $filePath = public_path() . '/files/uploads/memo/';
                $file->move($filePath, $filename);

                $file_data = array(
                    'name' => $request->name,
                    'filenames' => $filename,
                    'status' => $request->has('status') ? true : false,
                );
                DB::table('memo')->where('id', $id)->update($file_data);
            }
        } else {
            $file_data = array(
                'name' => $request->name,
                'status' => $request->has('status') ? true : false,
            );
            DB::table('memo')->where('id', $id)->update($file_data);
        }

        //Save audit trail
        $data_audit = array(
            'user_id' => Auth::user()->id,
            'module'  => 'Control Panel',
            'menu'    => 'Memo Setup',
            'activity' => 'Update',
            'description' => 'Updated ' . $request->name . ' on memo setup.',
        );

        Audit::create($data_audit);

        return back()->with('success', 'You have successfully updated memo!');
    }
}
