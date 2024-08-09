<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\City;
use App\Models\Addlisting;
use App\Repositories\Addlisting\AddlistingInterface;
use Illuminate\Support\Facades\Validator;

class AdpostController extends Controller
{    
    protected $addlisting; 

    /**
     * Create a new controller instance.
     *
     * @return void
    */
    public function __construct(AddlistingInterface $addlisting)
    {
        $this->addlisting = $addlisting;
        $this->middleware('auth');
    }

    public function index()
    {        
        return view('admin.index');
    }

    public function form()
    {  
        $user = Auth::user(); 
        $cities = City::select('id', 'name')->get();
        return view('ad-form', compact('cities'));
    }

    public function formProcess(Request $request)
    {  
        $user = Auth::user();

        // $this->validate(request(), [    
        //     'email'      => 'required|unique:users|max:255',
        //     'password'   => 'required|min:8|confirmed',
        //     'name'       => 'required',
        //     'last_name'  => 'required',
        //     'contact_no' => 'required',

        // ]); 

        $data =[
            'user_id'       => $user->id,
            'category_id'   => $request->input('category_id'),
            'city_id'       => $request->input('city_id'),
            'street'        => $request->input('street'),
            'postal'        => $request->input('postal'),  
            'area'          => $request->input('area'),  

            'age'           => $request->input('age'), 
            'title'         => $request->input('title'), 
            'description'   => $request->input('description'), 
            'contact_refer' => $request->input('contact_refer'), 
            'email'         => $request->input('email'),
            'phone'         => $request->input('phone'), 
            'status'        => 1,           
            'slug'          => 1,         
        ]; 

        $ad = $this->addlisting->store($id = null, $data);

        if($ad){

            $photo = request()->file('photo');

            $directory = '../public/files/ads/'.$ad->id;    

            $destinationPath = $directory."/"; 

            if ($photo){                        

              $this->checkDir($directory, $ad->id);

              $extension = $photo->getClientOriginalExtension();

              $fileName = 'main'.$ad->id.'.'.$extension;       

              $photo->move($destinationPath, $fileName);               

              Addlisting::where('id','=',$ad->id)->update(['photo' => $fileName]);                                   
            } 

            return redirect()->route('front.ads.list');
        }
        else{

            return redirect('/');
        }
                
    }

    public function list()
    {        
        return view('list');
    }

    /*
     * check Directory
    */
    public  function checkDir($directory, $id)
    {
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
    }

}

