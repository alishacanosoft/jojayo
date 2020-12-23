<?php

namespace App\Http\Controllers;

use App\Mail\CustomerVerification;
use App\Models\CategoryPermitted;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Commission;
use App\Models\VendorCommission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    protected $user = null;
    protected $customer = null;
    protected $category = null;
    protected $vendor = null;
    protected $employee = null;
    protected $category_permitted = null;
    protected $commission = null;
    protected $vendor_commission = null;

    public function __construct(User $user,Customer $customer,ProductCategory $category,Vendor $vendor,Employee $employee,CategoryPermitted $category_permitted, Commission $commission, VendorCommission $vendor_commission)
    {
        $this->user = $user;
        $this->customer = $customer;
        $this->category = $category;
        $this->vendor = $vendor;
        $this->employee = $employee;
        $this->category_permitted = $category_permitted;
        $this->commission = $commission;
        $this->vendor_commission = $vendor_commission;
        //$this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $active_tab = "manage";
        $allCategories = $this->category->get();

        // dd($this->user->where('roles','vendor')->get());
        $allUsers = $this->user->admin()->get();
        $customers = $this->user->customer()->get();
        $vendors = $this->user->where('roles','vendor')->get();
        return view('admin.pages.users', compact('allUsers', 'customers','vendors', 'active_tab', 'allCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $active_tab = "create";
        $allCategories = $this->category->get();
        $allUsers = $this->user->where('roles', '!=', 'customers')->get();
        return view('admin.pages.users', compact('allUsers', 'active_tab', 'allCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = $this->user->getRules();
        $request->validate($rules);
        $data = $request->all();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['contact'] = $request->contact;
        if($request->hasFile('image')){
            $pro_image = uploadImage($request->image, 'users', '400x400');
            $data['image'] = $pro_image;
        }
        $data['roles'] = $request->roles;
        $this->user->fill($data);
        $status = $this->user->save();
        $user_id = $this->user->id;
        if($data['roles'] == 'vendor'){
            $vendor_data['user_id'] = $user_id;
            $vendor_data['company'] = $request->company;
            $vendor_data['company_address'] = $request->company_address;
            $vendor_data['pan'] = $request->pan;
            $vendor_data['vendor_address'] = $request->vendor_address ? $request->vendor_address : $request->company_address;
            $vendor_data['status'] = $request->status ? $request->status : 'unverified';
            $this->vendor->fill($vendor_data);
            $vendor_data = $this->vendor->save();
            $vendor_id = $this->vendor->id;
            if($vendor_data){
                if(!empty($request->categories)){
                    foreach($request->categories as $cat_permitted){
                        CategoryPermitted::create([
                            'vendor_id' => $vendor_id,
                            'category_id' => $cat_permitted
                        ]);
                    }
                }
            }
        }
        if($data['roles'] == 'employee'){
            $employee_data['user_id'] = $user_id;
            $employee_data['DOB'] = $request->DOB;
            $employee_data['address'] = $request->address;
            $employee_data['salary'] = $request->salary;
            $employee_data['status'] = $request->status;
            $this->employee->fill($employee_data);
            $this->employee->save();
        }
        if($data['roles'] == 'customer'){
            $customer_data['user_id'] = $user_id;
            $customer_data['billing_address'] = $request->billing_address;
            $customer_data['shipping_address'] = $request->shipping_address;
            $customer_data['token'] = sha1(time());
            $customer_data['status'] = $request->status;
            $this->customer->fill($customer_data);
            $this->customer->save();
            Mail::to($data['email'])->send(new CustomerVerification($customer_data));
            return redirect('/customer/dashboard');
        }
        
        if($request->roles == 'vendor'){
            if($status){
                $notification = array(
                    'alert-type' => 'success',
                    'message' => 'Congratulations! You are registered as a vendor now! You should receive a call soon.'
                );
            } else {
                $notification = array(
                    'alert-type' => 'error',
                    'message' => 'Registration failed.'
                );
            }
            return redirect()->route('vendorLogin')->with($notification);           
        } else {
            if($status){
                $notification = array(
                    'alert-type' => 'success',
                    'message' => 'User added successfully'
                );
            } else {
                $notification = array(
                    'alert-type' => 'error',
                    'message' => 'Problem creating user.'
                );
            }
            return redirect()->route('users.index')->with($notification);
        }
    }

    public function customerSignUp(Request $request){
      $rules = $this->user->getRules();
      $request->validate($rules);
      $data = $request->all();
      $data['name'] = $request->name;
      $data['email'] = $request->email;
      $password = $request->password;
      $confirm = $request->confirm;
      if($password != $confirm){
        $errors = new MessageBag(['confirm' => ['Password confirmation did not matched!']]);
        return redirect()->back()->withErrors($errors)->withInput($request->all());
      }
      $data['password'] = Hash::make($request->password);
      $data['contact'] = $request->contact;
     
      $data['roles'] = 'customers';
      $this->user->fill($data);
      $customer_data = array();
      $user_id = $this->user->save();
      $customer_data['token'] = sha1(time());
      $customer_data['email'] = $request->email;
      Mail::to($data['email'])->send(new CustomerVerification($customer_data));
      request()->session()->flash('success', 'Please open your email and click on the confirmation link to verify your email address.');
    //   return redirect()->route('signinform');
      $findUser = $this->user->where('email', $data['email'])->first();
      if($findUser){
         Auth::login($findUser);
         return redirect()->back(); 
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
        $all_categories = $this->category->orderBy('created_at', 'desc')->get();
        $data = $this->user->find($id);
        return view('admin.pages.update', compact('data', 'all_countries'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->user->find($id);
        if(!$data) {
            request()->session()->flash('error','User not found');
            return redirect()->back();
        }
        $allCategories = $this->category->get();
        $vendor_data = '';
        $employee_data = '';
        $permitted = '';
        if($data->roles == 'vendor'){
            $vendor_data = $this->vendor->where('user_id', $id)->first();
            $permitted = $this->category_permitted->where('vendor_id', $vendor_data->id)->get();
        } elseif($data->roles ==  'employee'){
            $employee_data = $this->employee->where('user_id', $id)->first();
        }
        $active_tab = 'create';
        $allUsers = $this->user->where('roles', '!=', 'customers')->get();
        return view('admin.pages.users', compact('allUsers', 'allCategories','data', 'permitted', 'employee_data', 'vendor_data', 'active_tab'));
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
        $request['user_id'] = $id;
        $this->user = $this->user->find($id);
        if(!$this->user) {
            request()->session()->flash('error','User not found');
            return redirect()->back();
        }
        if($request->password == null){
            $request['password'] = $this->user->password;
        } else {
            $request['password'] = Hash::make($request->password);
        }
        $rules = $this->user->getRules('update');
        $request->validate($rules);
        $data = $request->all();
        if($request->hasFile('image')){
            $user_image = uploadImage($request->image, 'users', '730x480');
            $data['image'] = $user_image;
            if(file_exists(public_path().'/uploads/users/'.$this->user->image))
            {
                unlink(public_path().'/uploads/users/'.$this->user->image);
                unlink(public_path().'/uploads/users/Thumb-'.$this->user->image);
            }
        } else {
            $data['image'] = $this->user->image;
        }
        $this->user->fill($data);
        $user_status = $this->user->save();
        if($user_status){
            if(!empty($data['roles']) && $data['roles'] == 'vendor'){
                $this->vendor = $this->vendor->where('user_id', $id)->first();
                $vendor_data['user_id'] = $id;
                $vendor_data['company'] = $request->company;
                $vendor_data['company_address'] = $request->company_address;
                $vendor_data['vendor_address'] = $request->vendor_address;
                $vendor_data['status'] = $request->status;
                $this->vendor->fill($vendor_data);
                $vendor_data = $this->vendor->save();
                $vendor_id = $this->vendor->id;
                if($vendor_data){
                    $users_to_delete = $this->category_permitted->where('vendor_id', $vendor_id)->get()->toArray();
                    $ids_to_delete = array_map(function($item){ return $item['id']; }, $users_to_delete);
                    DB::table('category_permitteds')->whereIn('id', $ids_to_delete)->delete();
                    if(!empty($request->categories)){
                        foreach($request->categories as $cat_permitted){
                            CategoryPermitted::create([
                                'vendor_id' => $vendor_id,
                                'category_id' => $cat_permitted
                            ]);
                        }
                    }
                }
            }
            if(!empty($data['roles']) && $data['roles'] == 'employee'){
                $this->employee = $this->employee->where('user_id', $id)->first();
                $employee_data['user_id'] = $id;
                $employee_data['DOB'] = $request->DOB;
                $employee_data['address'] = $request->address;
                $employee_data['salary'] = $request->salary;
                $employee_data['status'] = $request->status;
                $this->employee->fill($employee_data);
                $this->employee->save();
            }
        }
        if($request['page'] == 'update_profile'){
            $notification = array(
                'message' => 'Profile updated successfully.',
                'alert-type' => 'success'
            );
            return redirect()->route('users.show', \Auth::user()->id)->with($notification);
        } else {
            $notification = array(
                'message' => 'User updated successfully.',
                'alert-type' => 'success'
            );
            return redirect()->route('users.index')->with($notification);
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
        $this->user = $this->user->find($id);
        if(!$this->user){
            request()->session()->flash('error','User Not found');
            return redirect()->route('users.index');
        }

        $success = $this->user->delete();
        if($success){
            request()->session()->flash('success','User deleted successfully.');
        } else {
            request()->session()->flash('error','Sorry! User could not be deleted at this moment.');
        }
        return redirect()->route('users.index');
    }

    public function login(Request $request){
        $user = User::where('email', '=', $request->input('email'))->first();
        if ($user === null) {
            $errors = new MessageBag(['email' => ['User not found in database.']]);
            return redirect()->back()->withErrors($errors)->withInput($request->all());
        }
        $password = Hash::check($request->input('password'), $user->password);
         if(!$password){
             $errors = new MessageBag(['password' => ['password mismatched!']]);
             return redirect()->back()->withErrors($errors)->withInput($request->all());
        }

        if($user->roles == 'customers'){
          $errors = new MessageBag(['email' => ['You cannot login to '.$user->roles.' dashboard with this email.']]);
          return redirect()->back()->withErrors($errors)->withInput($request->all());
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            if($user->roles == 'admin'){
                return redirect('/auth/dashboard');
            } elseif($user->roles == 'vendor'){
                return redirect('/auth/dashboard');
            } elseif($user->roles == 'employee'){
                return redirect('/auth/dashboard');
            }

        }
    }

    public function CustomerLogin(Request $request){
        $user = User::where('email', '=', $request->input('email'))->first();
        if ($user === null) {
          request()->session()->flash('email','Email not found in our database.');
          return back();
        }
        $password = Hash::check($request->input('password'), $user->password);
         if(!$password){
           request()->session()->flash('password','Password mismatched!');
           return back();
        }
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            if(Auth::user()->roles == 'customers'){
                //return redirect('/dashboard');
                return back();
            }  else {
              request()->session()->flash('warning','You cannot login to '.Auth::user()->roles.' dashboard from this form!');
              return back();
            }

        }
    }

    // public function redirectToProvider()
    // {
    //     return Socialite::driver('facebook')->redirect();
    // }

    public function redirectToProvider($service) {
        return Socialite::driver ( $service )->redirect ();
    }

    public function handleProviderCallback($service)
    {
        $user = Socialite::driver($service)->user();
        $userExists = User::where('email', '=', $user->getEmail())->first();
        if ($userExists) {
            $usersRole = $userExists->roles;
            if($usersRole !== 'customers'){
                request()->session()->flash('warning','You cannot log in to customers dashboard with this Facebook account!');
              return back();
            }
          Auth::login($userExists);
          return redirect('dashboard');
        }
        $password = $user->getId().'password'.$user->getNickname();
        $data['name'] = $user->getName();
        $data['email'] = $user->getEmail();
        $data['password'] = Hash::make($password);
        $data['image'] = $user->getAvatar();
        $data['roles'] = 'customers';
        $this->user->fill($data);
        $status = $this->user->save();
        $userNew = User::where('email', '=', $user->getEmail())->first();
        Auth::login($userNew);
        return redirect('dashboard');
    }

    public function UpdateUser(Request $request, $id){
      $user_data = $this->user->find($id);
      $oldimage=$user_data->image;
      $user_data->name=$request->input('name');
      $user_data->email=$request->input('email');
      $user_data->contact=$request->input('contact');
 
      if(!$user_data) {
          request()->session()->flash('error','User not found');
          return redirect()->back();
      }
      if($request->input('change_password') == null){
          $request['password'] = $user_data->password;
          $user_data->password = $user_data->password;
      }

      if($request->input('change_password') == "on"){
        
        if(Hash::check($request->old_password, $user_data->password)){
            // $request['password'] = Hash::make($request->password);
            $user_data->password = Hash::make($request->input('password'));

        }else{
           //   $errors = new MessageBag(['old_password' => ['The old password you entered did not matched!']]);
           Session::flash('error',  'The old password you entered did not matched!');
           return redirect()->back();

        }
      }


      
      if(!empty($request->file('image'))){
        $image = $request->file('image');
        $path=base_path().'/public/uploads/users';
        $name= uniqid().'_'.$image->getClientOriginalName();
        if($image->move($path,$name)){
            $user_data->image=$name;
            if (!empty($oldimage) && file_exists(public_path().'/uploads/users/'.$oldimage)){
                unlink(public_path().'/uploads/users/'.$oldimage);
                unlink(public_path().'/uploads/users/Thumb-'.$old_image);
            }
        }

    }
     
    
      $rules = $this->user->getRules('update');
    //   $user_data->validate($rules);
      $status=$user_data->update();

    //   $data = $request->all();
    //   dd($request->validate($rules));

    //   $this->user->fill($data);
     
    //   $user_status = $this->user->save();

    if($status){

        Session::flash('success','Profile updated successfully');
    }
    else{

        Session::flash('error','Failed to update details');
    }
    return redirect()->back();
    }

    public function password(Request $request){
        $id = \Auth::user()->id;
        $logged_in_user = $this->user->find($id);
        $current_password = $request->current_password;
        $validator = Validator::make($request->all(), [
          'current_password' => ['required', function ($attribute, $current_password, $fail) use ($logged_in_user) {
              if (!\Hash::check($current_password, $logged_in_user->password)) {
                  return $fail(__('The current password is incorrect.'));
              }
          }],
          'password' => 'sometimes|required|string|min:6',
          'confirm_password' => 'sometimes|required_with:password|same:password'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $password = Hash::make($request->password);
        $this->user->password = $password;
        $status = $this->user->where('id', $id)->update(array('password' => $password));
        if($status){
          $notification = array(
            'message' => 'Password updated successfully.',
            'alert-type' => 'success'
          );
          return redirect()->route('users.show', \Auth::user()->id)->with($notification);
        }
    }

    public function userInfo($user_id)
    {
        $user = $this->user->find($user_id);
        $view = $user->roles;
        return view('admin.pages.user.'.$view,compact('user'));
    }

    public function percent(Request $request, $id){
        $all_commission = $this->commission->get();
        $vendor_id = $this->vendor->where('user_id', $id)->first();
        $percent_list = $this->vendor_commission->where('vendor_id', $vendor_id->id)->get();
        $active_tab = 'manage';
        return view('admin.pages.user.percent',compact('all_commission','percent_list','active_tab'));
    }

    public function storePercent(Request $request)
    {
        //dd($request);
        $vendor_id = $this->vendor->where('user_id', $request->vendor_id)->first();
        $data['commission_id'] = $request->commission_id;
        $data['vendor_id'] = $vendor_id->id;
        $data['percent'] = $request->percent;
        $this->vendor_commission->fill($data);
        $status = $this->vendor_commission->save();
        if($status){
            $notification = array(
                'alert-type' => 'success',
                'message' => 'Commission data added successfully.'
            );
        } else {
            $notification = array(
                'alert-type' => 'error',
                'message' => 'Problem while adding commission data.'
            );
        }
        return redirect()->route('vendors.percent', $request->vendor_id)->with($notification);
    }
    public function percentEdit($id)
    {
        $data = $this->vendor_commission->find($id);
        $vendor_id = $this->vendor->where('id', $data->vendor_id)->first();
        if(!$data) {
            request()->session()->flash('error','Vendor commission not found');
            return redirect()->back();
        }    
        $active_tab = 'create';
        $all_commission = $this->commission->get();
        $percent_list = $this->vendor_commission->where('vendor_id', $vendor_id->id)->get();
        return view('admin.pages.user.percent', compact('data','active_tab','all_commission','percent_list'));
    }
}

