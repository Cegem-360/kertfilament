<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Person;
use App\Models\Donation;
use Illuminate\Http\Request;
use App\Imports\PeopleImport;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PersonController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:person-list', ['only' => ['index']]);
        $this->middleware('permission:person-create', ['only' => ['create', 'store', 'import']]);
        $this->middleware('permission:person-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:person-delete', ['only' => ['delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $people = Person::with(['donations'])->paginate(10);

        return view('people.index', ['people' => $people]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $donations = Donation::all();
        $families = Family::all();
        return view('people.add', ['donations' => $donations, 'families' => $families]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'tax_identification_number' => 'required',
            ]);

            /* Person::create(
                [
                    'id' => $request->id,
                    '' => $request->all()
                ]
            );*/
            Person::create($request->all());

            DB::commit();
            return redirect()->route('people.index')->with('success', 'person created successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $person)
    {
        $person = Person::with(['donations'])->whereId($person->id)->first();
        $families = Family::all();
        return view('people.edit', ['person' => $person, 'families' => $families]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $person)
    {
        DB::beginTransaction();
        try {

            // Store Data
            $person = Person::whereId($person->id)->update([
                'full_name' => $request->full_name,
                'birth_name' => $request->birth_name,
                'date_of_birth' => $request->date_of_birth,
                'place_of_birth' => $request->date_of_birth,
                'mobile_number' => $request->mobile_number,
                'postal_code' => $request->postal_code,
                'postal_city' => $request->postal_city,
                'postal_street' => $request->postal_street,
                'tax_identification_number' => $request->tax_identification_number,
                'email' => $request->email,
                'status' => $request->status,
                'account_number' => $request->account_number,
                'company_name' => $request->company_name,
                'family_id' => $request->family_id,
            ]);
            DB::commit();
            return redirect()->route('people.index')->with('success', 'User Updated Successfully.');
        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {

            Person::whereId($id)->delete();

            DB::commit();
            return redirect()->route('people.index')->with('success', 'person deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('people.index')->with('error', $th->getMessage());
        }
    }

    /**
     * Import Users
     * @param Null
     * @return View File
     */
    public function importPeople()
    {
        return view('people.import');
    }

    public function uploadPeople(Request $request)
    {
        Excel::import(new PeopleImport, $request->file);

        return redirect()->route('people.index')->with('success', 'People Imported Successfully');
    }

    public function generatePerson(Request $request, Person $person)
    {
        //$person = Person::find($id);
        $person = Person::whereHas('donations', function ($query) use ($request, $person) {
            $query->whereBetween('donation_date', [$request->from, $request->to])->groupBy('donation_date');
        })->first();
        $pdf = PDF::loadView('people/pdf', ['person' => $person]);
        return $pdf->download("donations.pdf");
    }
    public function generateCompany(Request $request, Person $person)
    {
        $path = public_path() . '/people';
        //$person = Person::find($id);
        $person = Person::whereHas('donations', function ($query) use ($request, $person) {
            $query->whereBetween('donation_date', [$request->from, $request->to])->groupBy('donation_date');
        })->first();
        $pdf = PDF::loadView('people/cegesigazolas', ['person' => $person]);
        // $pdf->save('ceg_igazolas.pdf', 'utf-8');
        //return response()->download('ceg_igazolas.pdf');
        return $pdf->download("ceg_igazolas.pdf");
    }
   
}
