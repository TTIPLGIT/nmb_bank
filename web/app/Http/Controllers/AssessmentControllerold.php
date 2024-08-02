<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AssessmentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $menus = $this->FillMenu();

        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        
        return view("Assessment.index" , compact('user_id','menus','screens','modules')  );
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $menus = $this->FillMenu();

        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view("Assessment.create" , compact('user_id','menus','screens','modules')  );
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $menus = $this->FillMenu();

        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view("Assessment.show" , compact('user_id','menus','screens','modules')  );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $menus = $this->FillMenu();

        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view("Assessment.edit" , compact('user_id','menus','screens','modules')  );
    }

    public function completedasmnt(Request $request)
    {
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $menus = $this->FillMenu();

        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view("Assessment.completedasmntindex" , compact('user_id','menus','screens','modules')  );
    }
    public function Approved1(Request $request)
    {
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $menus = $this->FillMenu();

        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view("Assessment.approved1" , compact('user_id','menus','screens','modules')  );
    }
    public function Approved2(Request $request)
    {
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $menus = $this->FillMenu();

        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view("Assessment.approved2" , compact('user_id','menus','screens','modules')  );
    }

    public function completeddecision(Request $request)
    {
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $menus = $this->FillMenu();

        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view("Assessment.completeddecision" , compact('user_id','menus','screens','modules')  );
    }
    public function Approved1decision(Request $request)
    {
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $menus = $this->FillMenu();

        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view("Assessment.approve1decision" , compact('user_id','menus','screens','modules')  );
    }
    public function Approved2decision(Request $request)
    {
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $menus = $this->FillMenu();

        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view("Assessment.approve2decision" , compact('user_id','menus','screens','modules')  );
    }
    public function submittedrequestindex(Request $request)
    {
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $menus = $this->FillMenu();

        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view("Assessment.submittedindex" , compact('user_id','menus','screens','modules')  );
    }
    public function pendingvaluationindex(Request $request)
    {
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $menus = $this->FillMenu();

        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view("Assessment.approve1decision" , compact('user_id','menus','screens','modules')  );
    }
    public function rejectedrequestindex(Request $request)
    {
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $menus = $this->FillMenu();

        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view("Assessment.rejectedindex" , compact('user_id','menus','screens','modules')  );
    }
    public function duediligenceindex(Request $request)
    {
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $menus = $this->FillMenu();

        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view("Assessment.duediligenceindex" , compact('user_id','menus','screens','modules')  );
    }
    public function duediligence(Request $request)
    {
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $menus = $this->FillMenu();

        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view("Assessment.duediligence" , compact('user_id','menus','screens','modules')  );
    }
    public function vrallocation(Request $request)
    {
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $menus = $this->FillMenu();

        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view("Assessment.vrallocation" , compact('user_id','menus','screens','modules')  );
    }

    public function Inspectionindex(Request $request)
    {
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $menus = $this->FillMenu();

        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view("Assessment.inspectionindex" , compact('user_id','menus','screens','modules')  );
    }
    public function inspect(Request $request)
    {
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $menus = $this->FillMenu();

        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view("Assessment.inspect" , compact('user_id','menus','screens','modules')  );
    }
    public function Evaluationindex(Request $request)
    {
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $menus = $this->FillMenu();

        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view("Assessment.Evaluationindex" , compact('user_id','menus','screens','modules')  );
    }

    public function evaluate(Request $request)
    {
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $menus = $this->FillMenu();

        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view("Assessment.evaluate" , compact('user_id','menus','screens','modules')  );
    }
    public function valuationreportindex(Request $request)
    {
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $menus = $this->FillMenu();

        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view("Assessment.valuationreportindex" , compact('user_id','menus','screens','modules')  );
    }
    public function ValuationReport(Request $request)
    {
        //
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $menus = $this->FillMenu();

        if($menus=="401"){
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view("Assessment.ValuationReport" , compact('user_id','menus','screens','modules')  );
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
