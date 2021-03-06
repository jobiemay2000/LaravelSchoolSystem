<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAcadPeriodRequest;
use App\Http\Requests\UpdateAcadPeriodRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\AcadPeriod;
use App\Models\Student;
use App\Models\StudentUpdate;
use Illuminate\Http\Request;
use Flash;
use Response;

class AcadPeriodController extends AppBaseController
{
    /**
     * Display a listing of the AcadPeriod.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
       
        $acadPeriods = AcadPeriod::orderBy('id', 'DESC')->get();
        $currentPeriod = AcadPeriod::latest()->first();
       

        return view('menu_Registrar/acad_periods/index', [
            'acadPeriods' => $acadPeriods,
            'currentPeriod' => $currentPeriod
        ]);
    }

    /**
     * Show the form for creating a new AcadPeriod.
     *
     * @return Response
     */
    public function create()
    {
        return view('menu_Registrar/acad_periods/create');
    }

    /**
     * Store a newly created AcadPeriod in storage.
     *
     */
    public function store(CreateAcadPeriodRequest $request)
    {
        $input = $request->all();

        
        $acadPeriod = AcadPeriod::create($input);
        Student::where('isPass','1')
        ->update(['isPass' => '0' ]);
        Student::where('isEnrolled','1')
        ->update(['isEnrolled' => '0']);

        $s= Student::whereHas('StudentUpdate')->get();
        foreach($s as $s){
            $s->update(['isNew' => '1']);
        }
        Flash::success('New Academic Period.');

        return redirect(route('acadPeriods.index'));
    }

   

    /**
     * Show the form for editing the specified AcadPeriod.
     *
     */
    public function edit($id)
    {
       
        $acadPeriod = AcadPeriod::find($id);

        if (empty($acadPeriod)) {
            Flash::error('Academic Period not found');

            return redirect(route('acadPeriods.index'));
        }

        return view('menu_Registrar/acad_periods/edit')->with('acadPeriod', $acadPeriod);
    }

    /**
     * Update the specified AcadPeriod in storage.
     *
     * @param int $id
     * @param UpdateAcadPeriodRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAcadPeriodRequest $request)
    {
        /** @var AcadPeriod $acadPeriod */
        $acadPeriod = AcadPeriod::find($id);

        if (empty($acadPeriod)) {
            Flash::error('Acad Period not found');

            return redirect(route('acadPeriods.index'));
        }

        $acadPeriod->fill($request->all());
        $acadPeriod->save();

        Flash::success('Academic Period updated successfully.');

        return redirect(route('acadPeriods.index'));
    }

    public function destroy($id){
        $acadPeriod = AcadPeriod::find($id);
        $acadPeriod->delete($id);
        Flash::success('Academic Period deleted successfully.');
        return redirect(route('acadPeriods.index'));
    }

    
}
