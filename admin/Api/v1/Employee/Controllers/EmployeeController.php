<?php

namespace Api\v1\Employee\Controllers;

use Illuminate\Http\Request;
use Response;
use Illuminate\Http\Response as Res;
use Api\v1\Employee\Requests\EmployeeRequest;
use Api\v1\Employee\Models\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class EmployeeController extends Controller
{
   

    private $employee;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Employee $employee)
    {
       $this->employee = $employee ;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $data = $this->employee->all();
        return Response::json($data,Res::HTTP_OK);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * This Method use for create new Supplier.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request)
    {
        try{
           
            $data = $request->only($this->employee->getFillable());
            $this->employee->fill($data)->save();
            return Response::json($data,Res::HTTP_CREATED);
        }
        catch(ModelNotFoundException $e)
        {
            return Response::json('Sorry, Operation Failed',Res::HTTP_NOT_FOUND);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try
        {
            $data = $this->employee->findOrFail($id);
            return Response::json($data,Res::HTTP_OK);
        }
        catch(ModelNotFoundException $e)
        {
            return Response::json('Sorry the data is not found',Res::HTTP_NOT_FOUND);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        try
        {
            $emaployee =$this->employee->findOrFail($id);
            $data = $request->only($this->employee->getFillable());
            $emaployee->update($data);
            return Response::json($data,Res::HTTP_CREATED);
        }
        catch(ModelNotFoundException $e)
        {
            return Response::json('Sorry, Operation Failed',Res::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $employee = $this->employee->findOrFail($id);
            if($employee->delete()){
                return Response::json([],Res::HTTP_CREATED);
            }else{
                 return Response::json('Sorry, Operation Failed',Res::HTTP_NOT_FOUND);
            }
        }
        catch(ModelNotFoundException $e)
        {
            return Response::json('Sorry, Operation Failed',Res::HTTP_NOT_FOUND);
        }
    }
}
