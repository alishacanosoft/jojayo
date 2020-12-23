<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Brand;
use App\Models\City;
use App\Models\Color;
use App\Models\Image;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImages;
use App\models\ProductOrder;
use App\Models\ProductSize;
use App\Models\Region;
use App\Models\SensitiveData;
use App\Models\Size;
use App\Models\Commission;
use App\Models\AddressBook;
use App\Models\VendorCommission;
use App\Models\User;
use App\Models\Vendor;
use Barryvdh\DomPDF\Facade as PDF;
use App\Officecategory;
use App\Officevoucher;
use Illuminate\Http\Request;
use Sabberworm\CSS\Value\URL;

class AjaxController extends Controller
{
    //
    public function ajaxRequest()
    {
        return view('ajaxRequest');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function ajaxRequestGet(Request $request)
    {
        if($request->ajax()){
            if(!empty($request->start) && !empty($request->end) && !empty($request->cat))
            {
                //first condition when all three fields are submitted.
                //Reads all the value for datatable
                $draw = $request->get('draw');
                $start = $request->get("start");
                $rowperpage = $request->get("length"); // Rows display per page

                $columnIndex_arr = $request->get('order');
                $columnName_arr = $request->get('columns');
                $order_arr = $request->get('order');
                $search_arr = $request->get('search');

                $columnIndex = $columnIndex_arr[0]['column']; // Column index
                $columnName = $columnName_arr[$columnIndex]['data']; // Column name
                $columnSortOrder = $order_arr[0]['dir']; // asc or desc
                $searchValue = $search_arr['value']; // Search value

                // counts the total records available in the table
                $totalRecords = Officevoucher::select('count(*) as allcount')->count();
                $totalRecordswithFilter = Officevoucher::select('count(*) as allcount')->where('voucherid', 'like', '%' .$searchValue . '%')->count();

                // $data = Officevoucher::whereBetween('created_at', array($request->start, $request->end))
                //->get();

                // getting all the records from the database to load in the table as per the conditions
                $records = Officevoucher::whereBetween('created_at', array($request->start, $request->end))
                    ->where('category_id', $request->cat)
                    ->get();

                //creating an array to add the fetched records
                $data_arr = array();
                $message = "'Are you sure you want to delete this?'";

                foreach($records as $record){
                    $id = $record->id;
                    $myroute = route('office_voucher.destroy', $id);
                    $voucherid = $record->voucherid;
                    $category_id = $record->category_id;
                    $price = $record->price;
                    $description = strip_tags($record->description);
                    $created_at = $record->created_at;

                    $data_arr[] = array(
                        "id" => "<input type='checkbox' class='sorting_disabled' name='delete_items' value= ". $id ."/>",
                        "voucherid" => $voucherid,
                        "category_id" => Officecategory::find($category_id)->name,
                        "price" => $price,
                        "description" => wordwrap($description, 65, "<br />\n"),
                        "created_at" => $created_at,
                        "action" => '<button class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal-default'. $id .'">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <a href="/auth/office_voucher/'. $id .'/edit" class="btn btn-primary btn-xs">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                      <a style="display:inline-block" onclick="return confirm('. $message .')">
                                        <form method="post" action="'. $myroute .'">
                                           '. method_field('DELETE') .'
                                            <input name="_token" type="hidden" value="'. @csrf_token() .'">
                                            <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-trash-o"></i></button>
                                      </form>
                                    </a>
                                     <div class="modal fade" id="modal-default'. $id . '" style="display: none;">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header modal-header-info">
                                              <h4 class="modal-title"> Voucher no <span class="pull-right"> '. $voucherid .' </span></h4>
                                            </div>
                                                 <div class="modal-body">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title" id="corp">
                                                        </h3>
                                                    </div>
                                                    <div>
                                                        <dl class="dl-horizontal">
                                                            <dt>Voucher For</dt>
                                                            <dd id="category"><p>'. Officecategory::find($category_id)->name .'</p></dd>
                                                            <dt>Price</dt>
                                                            <dd id="price"><p>'. $price .'</p></dd>
                                                            <dt>Description</dt>
                                                            <dd id="description"><p>'. wordwrap($description, 50, "<br />\n") .'</p></dd>
                                                            <dt>Narrative</dt>
                                                            <dd id="phone">'.wordwrap( Officevoucher::find($id)->narrative, 50, "<br />\n") .'</dd>
                                                            <dt>Created at</dt>
                                                            <dd id="phone"><p>'. Officevoucher::find($id)->created_at .'</p></dd>
                                                        </dl>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                              <a  href="/auth/ajaxRequest/'. $id .'/pdfExport" target="_blank" class="btn btn-info pull-left"> <i class="fa fa-download"></i> Download</a>
                                            </div>
                                          </div>
                                        </div>
                                    </div>'
                    );
                }

                $response = array(
                    "draw" => intval($draw),
                    "iTotalRecords" => $totalRecords,
                    "iTotalDisplayRecords" => $totalRecordswithFilter,
                    "aaData" => $data_arr
                );

                echo json_encode($response);
                exit;
            }
            else if(!empty($request->start) && !empty($request->end) && empty($request->cat)) {

                //second condition when only dates fields are submitted.
                //Reads all the value for datatable
                $draw = $request->get('draw');
                $start = $request->get("start");
                $rowperpage = $request->get("length"); // Rows display per page

                $columnIndex_arr = $request->get('order');
                $columnName_arr = $request->get('columns');
                $order_arr = $request->get('order');
                $search_arr = $request->get('search');

                $columnIndex = $columnIndex_arr[0]['column']; // Column index
                $columnName = $columnName_arr[$columnIndex]['data']; // Column name
                $columnSortOrder = $order_arr[0]['dir']; // asc or desc
                $searchValue = $search_arr['value']; // Search value

                // counts the total records available in the table
                $totalRecords = Officevoucher::select('count(*) as allcount')->count();
                $totalRecordswithFilter = Officevoucher::select('count(*) as allcount')->where('voucherid', 'like', '%' .$searchValue . '%')->count();

                // $data = Officevoucher::whereBetween('created_at', array($request->start, $request->end))
                //->get();

                // getting all the records from the database to load in the table as per the conditions
                $records = Officevoucher::whereBetween('created_at', array($request->start, $request->end))
                    ->get();

                //creating an array to add the fetched records
                $data_arr = array();
                $message = "'Are you sure you want to delete this?'";
                foreach($records as $record){
                    $id = $record->id;
                    $myroute = route('office_voucher.destroy', $id);
                    $voucherid = $record->voucherid;
                    $category_id = $record->category_id;
                    $price = $record->price;
                    $description = strip_tags($record->description);
                    $created_at = $record->created_at;

                    $data_arr[] = array(
                        "id" => "<input type='checkbox' class='sorting_disabled' name='delete_items' value= ". $id ."/>",
                        "voucherid" => $voucherid,
                        "category_id" => Officecategory::find($category_id)->name,
                        "price" => $price,
                        "description" => wordwrap($description, 65, "<br />\n"),
                        "created_at" => $created_at,
                        "action" => '<button class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal-default'. $id .'">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <a href="/auth/office_voucher/'. $id .'/edit" class="btn btn-primary btn-xs">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                     <a style="display:inline-block" onclick="return confirm('. $message .')">
                                        <form method="post" action="'. $myroute .'">
                                           '. method_field('DELETE') .'
                                            <input name="_token" type="hidden" value="'. @csrf_token() .'">
                                            <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-trash-o"></i></button>
                                      </form>
                                    </a>
                                     <div class="modal fade" id="modal-default'. $id . '" style="display: none;">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header modal-header-info">
                                              <h4 class="modal-title"> Voucher no <span class="pull-right"> '. $voucherid .' </span></h4>
                                            </div>
                                                 <div class="modal-body">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title" id="corp">
                                                        </h3>
                                                    </div>
                                                    <div>
                                                        <dl class="dl-horizontal">
                                                            <dt>Voucher For</dt>
                                                            <dd id="category"><p>'. Officecategory::find($category_id)->name .'</p></dd>
                                                            <dt>Price</dt>
                                                            <dd id="price"><p>'. $price .'</p></dd>
                                                            <dt>Description</dt>
                                                            <dd id="description"><p>'. wordwrap($description, 50, "<br />\n") .'</p></dd>
                                                            <dt>Narrative</dt>
                                                            <dd id="phone">'.wordwrap( Officevoucher::find($id)->narrative, 50, "<br />\n") .'</dd>
                                                            <dt>Created at</dt>
                                                            <dd id="phone"><p>'. Officevoucher::find($id)->created_at .'</p></dd>
                                                        </dl>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                              <a  href="/auth/ajaxRequest/'. $id .'/pdfExport" target="_blank" class="btn btn-info pull-left"> <i class="fa fa-download"></i> Download</a>
                                            </div>
                                          </div>
                                        </div>
                                    </div>'
                    );
                }
                $response = array(
                    "draw" => intval($draw),
                    "iTotalRecords" => $totalRecords,
                    "iTotalDisplayRecords" => $totalRecordswithFilter,
                    "aaData" => $data_arr
                );

                echo json_encode($response);
                exit;
            }
            else{
                //normal condition when fiter is not used and datatables is displayed.
                //Reads all the value for datatable
                $draw = $request->get('draw');
                $start = $request->get("start");
                $rowperpage = $request->get("length"); // Rows display per page

                $columnIndex_arr = $request->get('order');
                $columnName_arr = $request->get('columns');
                $order_arr = $request->get('order');
                $search_arr = $request->get('search');

                $columnIndex = $columnIndex_arr[0]['column']; // Column index
                $columnName = $columnName_arr[$columnIndex]['data']; // Column name
                $columnSortOrder = $order_arr[0]['dir']; // asc or desc
                $searchValue = $search_arr['value']; // Search value

                // Total records
                $totalRecords = Officevoucher::select('count(*) as allcount')->count();
                $totalRecordswithFilter = Officevoucher::select('count(*) as allcount')->where('voucherid', 'like', '%' .$searchValue . '%')->count();

                // Fetch records
                $records = Officevoucher::orderBy($columnName,$columnSortOrder)
                    ->where('offficevoucher.voucherid', 'like', '%' .$searchValue . '%')
                    ->select('offficevoucher.*')
                    ->skip($start)
                    ->take($rowperpage)
                    ->get();

                $data_arr = array();
                $message = "'Are you sure you want to delete this?'";
                foreach($records as $record){
                    $id = $record->id;
                    $voucherid = $record->voucherid;
                    $category_id = $record->category_id;
                    $price = $record->price;
                    $description = strip_tags($record->description);
                    $created_at = $record->created_at;
                    $myroute = route('office_voucher.destroy', $id);
                    $data_arr[] = array(
                        "id" => "<input type='checkbox' class='sorting_disabled' name='delete_items' value= ". $id ."/>",
                        "voucherid" => $voucherid,
                        "category_id" => Officecategory::find($category_id)->name,
                        "price" => $price,
                        "description" => wordwrap($description, 65, "<br />\n"),
                        "created_at" => $created_at,
                        "action" => '<button class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal-default'. $id .'">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <a href="/auth/office_voucher/'. $id .'/edit" class="btn btn-primary btn-xs">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                     <a style="display:inline-block" onclick="return confirm('. $message .')">
                                        <form method="post" action="'. $myroute .'">
                                           '. method_field('DELETE') .'
                                            <input name="_token" type="hidden" value="'. @csrf_token() .'">
                                            <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-trash-o"></i></button>
                                      </form>
                                    </a>
                                     <div class="modal fade" id="modal-default'. $id . '" style="display: none;">
                                        <div class="modal-dialog">
                                          <div class="modal-content">
                                            <div class="modal-header modal-header-info">
                                              <h4 class="modal-title"> Voucher no <span class="pull-right"> '. $voucherid .' </span></h4>
                                            </div>
                                                 <div class="modal-body">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title" id="corp">
                                                        </h3>
                                                    </div>
                                                    <div>
                                                        <dl class="dl-horizontal">
                                                            <dt>Voucher For</dt>
                                                            <dd id="category"><p>'. Officecategory::find($category_id)->name .'</p></dd>
                                                            <dt>Price</dt>
                                                            <dd id="price"><p>'. $price .'</p></dd>
                                                            <dt>Description</dt>
                                                            <dd id="description"><p>'. wordwrap($description, 50, "<br />\n") .'</p></dd>
                                                            <dt>Narrative</dt>
                                                            <dd id="phone">'.wordwrap( Officevoucher::find($id)->narrative, 50, "<br />\n") .'</dd>
                                                            <dt>Created at</dt>
                                                            <dd id="phone"><p>'. Officevoucher::find($id)->created_at .'</p></dd>
                                                        </dl>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                               <a  href="/auth/ajaxRequest/'. $id .'/pdfExport" target="_blank" class="btn btn-info pull-left"> <i class="fa fa-download"></i> Download</a>
                                            </div>
                                          </div>
                                        </div>
                                    </div>'
                    );
                }

                $response = array(
                    "draw" => intval($draw),
                    "iTotalRecords" => $totalRecords,
                    "iTotalDisplayRecords" => $totalRecordswithFilter,
                    "aaData" => $data_arr
                );

                echo json_encode($response);
                exit;
            }

        }
    }

    public function getPdf($id){
        $singleVoucher = Officevoucher::find($id);
        $sitedata = SensitiveData::find(1);
        return view('admin.pages.voucherpdf',compact('singleVoucher','sitedata'));
    }

    public function getmonthPdf(Request $request){
        if(!empty($request->start) && !empty($request->end) && !empty($request->categoryheader_id)){
            $sitedata = SensitiveData::all();
            $voucher = Officevoucher::whereBetween('created_at', array($request->start, $request->end))
                ->where('category_id', $request->categoryheader_id)
                ->get();
            return view('admin.pages.multidate',compact('voucher','sitedata'));

        }elseif (!empty($request->start) && !empty($request->end) && empty($request->categoryheader_id)){
            $sitedata = SensitiveData::all();
            $voucher = Officevoucher::whereBetween('created_at', array($request->start, $request->end))->get();
            if(sizeof($voucher) > 0){
                return view('admin.pages.multidate',compact('voucher','sitedata'));
            }else{
                $notification = array(
                    'alert-type' => 'error',
                    'message' => 'No information was found between these dates'
                );
                return redirect()->back()->with($notification);
            }

        }else{
            $notification = array(
                'alert-type' => 'error',
                'message' => 'Please enter both dates to continue'
            );
            return redirect()->back()->with($notification);

        }
    }

    //function for all tables order that differs from other tables.
    public function ajaxOrdersget(Request $request)
    {
        $currentroles = \Auth::user()->roles;
        $currentid = \Auth::user()->id;
        if ($request->ajax()) {
            //this is for all orders display with two of the filter condition like start and end date
            if(!empty($request->start) && !empty($request->end) && empty($request->orderid)){
                $records = Order::whereBetween('created_at', array($request->start, $request->end))
                    ->get();
                $data_arr = array();
                $dc       = array();

                foreach ($records as $record) {
                    $id = $record->id;
                    if ($currentroles == "admin") {
                        $area_detail = Area::where('id', $record->address_detail->area)->first();
                        if ($record->delivery_type == 'express') {
                            $deliver_charge = $area_detail->express_charge;
                        } else {
                            $deliver_charge = $area_detail->delivery_charge;
                        }
                        $order_no = $record->order_no;
                        $user_id = $record->user_id;
                        $area_id = $record->area_id;
                        $status = $record->status;
                        $delivery_type = $record->delivery_type;
                        $total_amount = $record->total_amount;
                        $created_at = $record->created_at->format('Y-m-d - H:i:s');
                        $useraddress = @$record->address_detail->address;
                        $region = Region::find($record->address_detail->region_id)->name;
                        $city = City::find($record->address_detail->city)->name;
                        $area = Area::find($record->address_detail->area)->name;
                        $colors = Color::all();
                        $size = Size::all();
                        $image_data = ProductImages::all();
                        $images = Image::all();
                        $order_detail = ProductOrder::with('products')->where('order_id', $id)->get();
                        $data_arr[] = array(
                            "order_no" => $order_no,
                            "user_id" => User::find($user_id)->name,
                            "user_address" => $useraddress,
                            "user_d" => $order_detail,
                            "colors" => $colors,
                            "size" => $size,
                            "image_data" => $image_data,
                            "images" => $images,
                            "user_region" => $region,
                            "user_city" => $city,
                            "user_area" => $area,
                            "area_id" => Area::find($area_id)->name,
                            "delivery_type" => $delivery_type,
                            "delivery_charge" => $deliver_charge,
                            "total_amount" => $total_amount,
                            "status" => $status,
                            "created_at" => $created_at,
                            "action" => '<div class="dropdown">
                                              <button class="dropbtn">Action</button>
                                              <div class="dropdown-content">
                                                 <ul>
                                                    <li value="' . $id . '">Verified</li>
                                                    <li value="' . $id . '">Packed</li>
                                                    <li value="' . $id . '">Shipped</li>
                                                    <li value="' . $id . '">Delivered</li>
                                                 </ul>
                                              </div>
                                              </div>'
                        );
                    }else{
                        //this is for all orders display for specific vendor with two filter conditions active
                        //where if the order does not contain any of the vendor's product, it will not show in their orderlist
                        $vendor  = Vendor::where('user_id',$currentid)->first();
                        $vendorid = $vendor->id;
                        $ordervalidation = ProductOrder::with('products')->where('order_id', $id)->get();
                        foreach ($ordervalidation as $op) {
                            $dc[] = $op->products->vendor_id;
                        }
                        if (in_array($vendorid, $dc)) {
                            $area_detail = Area::where('id', $record->address_detail->area)->first();
                            if ($record->delivery_type == 'express') {
                                $deliver_charge = $area_detail->express_charge;
                            } else {
                                $deliver_charge = $area_detail->delivery_charge;
                            }
                            $order_no = $record->order_no;
                            $user_id = $record->user_id;
                            $area_id = $record->area_id;
                            $status = $record->status;
                            $delivery_type = $record->delivery_type;
                            $total_amount = $record->total_amount;
                            $created_at = $record->created_at->format('Y-m-d - H:i:s');
                            $useraddress = @$record->address_detail->address;
                            $region = Region::find($record->address_detail->region_id)->name;
                            $city = City::find($record->address_detail->city)->name;
                            $area = Area::find($record->address_detail->area)->name;
                            $colors = Color::all();
                            $size = Size::all();
                            $image_data = ProductImages::all();
                            $images = Image::all();
                            $order_detail = ProductOrder::with('products')->where('order_id', $id)->get();
                            $data_arr[] = array(
                                "order_no" => $order_no,
                                "user_id" => User::find($user_id)->name,
                                "user_address" => $useraddress,
                                "user_d" => $order_detail,
                                "colors" => $colors,
                                "size" => $size,
                                "image_data" => $image_data,
                                "images" => $images,
                                "user_region" => $region,
                                "user_city" => $city,
                                "user_area" => $area,
                                "area_id" => Area::find($area_id)->name,
                                "delivery_type" => $delivery_type,
                                "delivery_charge" => $deliver_charge,
                                "total_amount" => $total_amount,
                                "status" => $status,
                                "created_at" => $created_at,
                                "action" => '<div class="dropdown">
                                              <button class="dropbtn">Action</button>
                                              <div class="dropdown-content">
                                                 <ul>
                                                    <li value="' . $id . '">Verified</li>
                                                    <li value="' . $id . '">Packed</li>
                                                    <li value="' . $id . '">Shipped</li>
                                                    <li value="' . $id . '">Delivered</li>
                                                 </ul>
                                              </div>
                                              </div>'
                            );
                        }
                        //end of sorting out the vendor specific order for each vendor
                    }
                    //end of checking the user role for admin and vendor
                }
                return response()->json(['data' => $data_arr]);
                //first filter with all start and end date as active condition
            }else if (!empty($request->start) && !empty($request->end) && !empty($request->orderid)){
                //this is for all orders display with all of the filter condition like start and end date
                // with order ID
                $records = Order::whereBetween('created_at', array($request->start, $request->end))
                    ->where('order_no',$request->orderid)
                    ->get();
                $data_arr = array();
                $dc = array();
                foreach ($records as $record) {
                    $id = $record->id;
                    //this is for all filter display for main admin who sees all the data
                    if ($currentroles == "admin") {
                        $area_detail = Area::where('id', $record->address_detail->area)->first();
                        if ($record->delivery_type == 'express') {
                            $deliver_charge = $area_detail->express_charge;
                        } else {
                            $deliver_charge = $area_detail->delivery_charge;
                        }
                        $order_no = $record->order_no;
                        $user_id = $record->user_id;
                        $area_id = $record->area_id;
                        $status = $record->status;
                        $delivery_type = $record->delivery_type;
                        $total_amount = $record->total_amount;
                        $created_at = $record->created_at->format('Y-m-d - H:i:s');
                        $useraddress = @$record->address_detail->address;
                        $region = Region::find($record->address_detail->region_id)->name;
                        $city = City::find($record->address_detail->city)->name;
                        $area = Area::find($record->address_detail->area)->name;
                        $colors = Color::all();
                        $size = Size::all();
                        $image_data = ProductImages::all();
                        $images = Image::all();
                        $order_detail = ProductOrder::with('products')->where('order_id', $id)->get();
                        $data_arr[] = array(
                            "order_no" => $order_no,
                            "user_id" => User::find($user_id)->name,
                            "user_address" => $useraddress,
                            "user_d" => $order_detail,
                            "colors" => $colors,
                            "size" => $size,
                            "image_data" => $image_data,
                            "images" => $images,
                            "user_region" => $region,
                            "user_city" => $city,
                            "user_area" => $area,
                            "area_id" => Area::find($area_id)->name,
                            "delivery_type" => $delivery_type,
                            "delivery_charge" => $deliver_charge,
                            "total_amount" => $total_amount,
                            "status" => $status,
                            "created_at" => $created_at,
                            "action" => '<div class="dropdown">
                                              <button class="dropbtn">Action</button>
                                              <div class="dropdown-content">
                                                 <ul>
                                                    <li value="' . $id . '">Verified</li>
                                                    <li value="' . $id . '">Packed</li>
                                                    <li value="' . $id . '">Shipped</li>
                                                    <li value="' . $id . '">Delivered</li>
                                                 </ul>
                                              </div>
                                              </div>'
                        );
                    }else{
                        //this is for all orders display for specific vendor with all filter conditions active
                        //where if the order does not contain any of the vendor's product, it will not show in their orderlist
                        $vendor  = Vendor::where('user_id',$currentid)->first();
                        $vendorid = $vendor->id;
                        $ordervalidation = ProductOrder::with('products')->where('order_id', $id)->get();
                        foreach ($ordervalidation as $op) {
                            $dc[] = $op->products->vendor_id;
                        }
                        if (in_array($vendorid, $dc)) {
                            $area_detail = Area::where('id', $record->address_detail->area)->first();
                            if ($record->delivery_type == 'express') {
                                $deliver_charge = $area_detail->express_charge;
                            } else {
                                $deliver_charge = $area_detail->delivery_charge;
                            }
                            $order_no = $record->order_no;
                            $user_id = $record->user_id;
                            $area_id = $record->area_id;
                            $status = $record->status;
                            $delivery_type = $record->delivery_type;
                            $total_amount = $record->total_amount;
                            $created_at = $record->created_at->format('Y-m-d - H:i:s');
                            $useraddress = @$record->address_detail->address;
                            $region = Region::find($record->address_detail->region_id)->name;
                            $city = City::find($record->address_detail->city)->name;
                            $area = Area::find($record->address_detail->area)->name;
                            $colors = Color::all();
                            $size = Size::all();
                            $image_data = ProductImages::all();
                            $images = Image::all();
                            $order_detail = ProductOrder::with('products')->where('order_id', $id)->get();
                            $data_arr[] = array(
                                "order_no" => $order_no,
                                "user_id" => User::find($user_id)->name,
                                "user_address" => $useraddress,
                                "user_d" => $order_detail,
                                "colors" => $colors,
                                "size" => $size,
                                "image_data" => $image_data,
                                "images" => $images,
                                "user_region" => $region,
                                "user_city" => $city,
                                "user_area" => $area,
                                "area_id" => Area::find($area_id)->name,
                                "delivery_type" => $delivery_type,
                                "delivery_charge" => $deliver_charge,
                                "total_amount" => $total_amount,
                                "status" => $status,
                                "created_at" => $created_at,
                                "action" => '<div class="dropdown">
                                              <button class="dropbtn">Action</button>
                                              <div class="dropdown-content">
                                                 <ul>
                                                    <li value="' . $id . '">Verified</li>
                                                    <li value="' . $id . '">Packed</li>
                                                    <li value="' . $id . '">Shipped</li>
                                                    <li value="' . $id . '">Delivered</li>
                                                 </ul>
                                              </div>
                                              </div>'
                            );
                        }
                        //end of sorting out the vendor specific order for each vendor
                    }
                    //end of checking the user role for admin and vendor
                }
                return response()->json(['data' => $data_arr]);
                //second filter with all conditions active

            }else{
                //this is for all orders display without any filter condition
                $records = Order::all();
                $data_arr = array();
                $dc       = array();
                $vendor_name       = array();
                foreach ($records as $record) {
                    $id = $record->id;
                    if($currentroles =="admin") {
                        $ordervalidation = ProductOrder::with('products')->where('order_id', $id)->get();
                        foreach ($ordervalidation as $op) {
                            $vendor_name[] = Vendor::find($op->products->vendor_id)->company;
                        }
                        //this is for all orders display for main admin who sees all the data
                        $order_detail = ProductOrder::with('products')->where('order_id', $id)->get();
                        $area_detail = Area::where('id', $record->address_detail->area)->first();
                        if ($record->delivery_type == 'express') {
                            $deliver_charge = $area_detail->express_charge;
                        } else {
                            $deliver_charge = $area_detail->delivery_charge;
                        }
                        $order_no = $record->order_no;
                        $user_id = $record->user_id;
                        $area_id = $record->area_id;
                        $status = $record->status;
                        $delivery_type = $record->delivery_type;
                        $total_amount = $record->total_amount;
                        $created_at = wordwrap($record->created_at->format('Y-m-d - H:i:s'), 11, "<br />\n");
                        $useraddress = @$record->address_detail->address;
                        $region = @Region::find($record->address_detail->region_id)->name;
                        $city = @City::find($record->address_detail->city)->name;
                        $area = @Area::find($record->address_detail->area)->name;
                        $colors = Color::all();
                        $size = Size::all();
                        $image_data = ProductImages::all();
                        $images = Image::all();
                        $data_arr[] = array(
                            "order_no" => $order_no,
                            "user_id" => User::find($user_id)->name,
                            "user_address" => $useraddress,
                            "user_d" => $order_detail,
                            "colors" => $colors,
                            "size" => $size,
                            "image_data" => $image_data,
                            "images" => $images,
                            "user_region" => $region,
                            "vendor_name" => $vendor_name,
                            "user_city" => $city,
                            "user_area" => $area,
                            "area_id" => Area::find($area_id)->name,
                            "delivery_type" => $delivery_type,
                            "delivery_charge" => $deliver_charge,
                            "total_amount" => $total_amount,
                            "status" => $status,
                            "created_at" => $created_at,
                            "action" => '<div class="dropdown">
                                              <button class="dropbtn">Action</button>
                                              <div class="dropdown-content">
                                                 <ul>
                                                    <li value="' . $id . '">Verified</li>
                                                    <li value="' . $id . '">Packed</li>
                                                    <li value="' . $id . '">Shipped</li>
                                                    <li value="' . $id . '">Delivered</li>
                                                 </ul>
                                              </div>
                                              </div>'
                        );
                    }else{
                        //this is for all orders display for specific vendor filter
                        //where if the order does not contain any of the vendor's product, it will not show in their orderlist

                        $vendor  = Vendor::where('user_id',$currentid)->first();
                        $vendorid = $vendor->id;
                        $ordervalidation = ProductOrder::with('products')->where('order_id', $id)->get();
                        foreach($ordervalidation as $op){
                            $dc[]= $op->products->vendor_id;
                            $vendor_name[] = Vendor::find($op->products->vendor_id)->company;
                        }
                        if (in_array($vendorid, $dc)) {
                            $order_detail = ProductOrder::with('products')->where('order_id', $id)->get();
                            $area_detail = Area::where('id', $record->address_detail->area)->first();
                            if ($record->delivery_type == 'express') {
                                $deliver_charge = $area_detail->express_charge;
                            } else {
                                $deliver_charge = $area_detail->delivery_charge;
                            }
                            $order_no = $record->order_no;
                            $user_id = $record->user_id;
                            $area_id = $record->area_id;
                            $status = $record->status;
                            $delivery_type = $record->delivery_type;
                            $total_amount = $record->total_amount;
                            $created_at = wordwrap($record->created_at->format('Y-m-d - H:i:s'), 11, "<br />\n");
                            $useraddress = @$record->address_detail->address;
                            $region = @Region::find($record->address_detail->region_id)->name;
                            $city = @City::find($record->address_detail->city)->name;
                            $area = @Area::find($record->address_detail->area)->name;
                            $colors = Color::all();
                            $size = Size::all();
                            $image_data = ProductImages::all();
                            $images = Image::all();
                            $data_arr[] = array(
                                "order_no" => $order_no,
                                "user_id" => User::find($user_id)->name,
                                "user_address" => $useraddress,
                                "user_d" => $order_detail,
                                "colors" => $colors,
                                "size" => $size,
                                "image_data" => $image_data,
                                "images" => $images,
                                "user_region" => $region,
                                "test" => $dc,
                                "vendor_name" => $vendor_name,
                                "user_city" => $city,
                                "user_area" => $area,
                                "area_id" => Area::find($area_id)->name,
                                "delivery_type" => $delivery_type,
                                "delivery_charge" => $deliver_charge,
                                "total_amount" => $total_amount,
                                "status" => $status,
                                "created_at" => $created_at,
                                "action" => '<div class="dropdown">
                                              <button class="dropbtn">Action</button>
                                              <div class="dropdown-content">
                                                 <ul>
                                                    <li value="' . $id . '">Verified</li>
                                                    <li value="' . $id . '">Packed</li>
                                                    <li value="' . $id . '">Shipped</li>
                                                    <li value="' . $id . '">Delivered</li>
                                                 </ul>
                                              </div>
                                              </div>'
                            );

                        }
                        //end of sorting out the vendor specific order for each vendor
                    }
//                    end of checking the user role for admin and vendor
                }

                return response()->json(['data' => $data_arr]);
            }
        }
        $active_tab = 'manage';
        return view('admin.pages.orders', compact('active_tab'));
    }

    public function ajaxMultiOrdersget(Request $request)
    {
        $currentroles = \Auth::user()->roles;
        $currentid = \Auth::user()->id;

        if ($request->ajax()) {
            $data_arr = array();
            $dc = array();

            if (!empty($request->ret)) {
                if (!empty($request->start) && !empty($request->end) && !empty($request->orderid)) {
                    //all order sorting with all three active conditions
                    $records = Order::whereBetween('created_at', array($request->start, $request->end))
                        ->where('order_no',$request->orderid)
                        ->where('status', $request->ret)->get();
                    foreach ($records as $record) {
                        $id = $record->id;
                        if ($currentroles == 'admin') {
                            //all order sorting for admin with all three active conditions
                            $area_detail = @Area::where('id', $record->address_detail->area)->first();
                            if ($record->delivery_type == 'express') {
                                $deliver_charge = @$area_detail->express_charge;
                            } else {
                                $deliver_charge = @$area_detail->delivery_charge;
                            }
                            $order_no = $record->order_no;
                            $user_id = $record->user_id;
                            $area_id = $record->area_id;
                            $status = $record->status;
                            $verified = wordwrap($record->verified_at, 11, "<br />\n");
                            $packed = wordwrap($record->packed_at, 11, "<br />\n");
                            $delivered = wordwrap($record->delivered_at, 11, "<br />\n");
                            $shipped = wordwrap($record->shipped_at, 11, "<br />\n");
                            $delivery_type = $record->delivery_type;
                            $total_amount = $record->total_amount;
                            $created_at = wordwrap($record->created_at->format('Y-m-d - H:i:s'), 11, "<br />\n");
                            $useraddress = @$record->address_detail->address;
                            $region = @Region::find($record->address_detail->region_id)->name;
                            $city = @City::find($record->address_detail->city)->name;
                            $area = @Area::find($record->address_detail->area)->name;
                            $colors = Color::all();
                            $size = Size::all();
                            $image_data = ProductImages::all();
                            $images = Image::all();
                            $order_detail = ProductOrder::with('products')->where('order_id', $id)->get();
                            if ($status == 'delivered') {
                                $show_data = '<form action="/auth/order-details"><input type="hidden" value="' . $order_no . '" name="order_no"><button class="btn-transparent" type="submit">' . $order_no . '</button></form>';
                            } else {
                                $show_data = $order_no;
                            }
                            $data_arr[] = array(
                                "order_no" => $show_data,
                                "user_id" => User::find($user_id)->name,
                                "user_address" => $useraddress,
                                "user_d" => $order_detail,
                                "colors" => $colors,
                                "size" => $size,
                                "verify" => $verified,
                                "deliver" => $delivered,
                                "pack" => $packed,
                                "ship" => $shipped,
                                "image_data" => $image_data,
                                "images" => $images,
                                "user_region" => $region,
                                "user_city" => $city,
                                "user_area" => $area,
                                "area_id" => @Area::find($area_id)->name,
                                "delivery_type" => $delivery_type,
                                "delivery_charge" => $deliver_charge,
                                "total_amount" => $total_amount,
                                "status" => $status,
                                "created_at" => $created_at,
                                "action" => '<div class="dropdown">
                                      <button class="dropbtn">Action</button>
                                      <div class="dropdown-content">
                                         <ul>
                                            <li value="' . $id . '" class="' . (($status == 'verified') ? 'hidden' : '') . '">Verified</li>
                                            <li value="' . $id . '" class="' . (($status == 'packed') ? 'hidden' : '') . '">Packed</li>
                                            <li value="' . $id . '" class="' . (($status == 'shipped') ? 'hidden' : '') . '">Shipped</li>
                                            <li value="' . $id . '" class="' . (($status == 'delivered') ? 'hidden' : '') . '">Delivered</li>
                                         </ul>
                                      </div>
                                    </div>'

                            );
                        } else {
                            //vendor specific order sorting with all three active conditions
                            $vendor = Vendor::where('user_id', $currentid)->first();
                            $vendorid = $vendor->id;
                            $ordervalidation = ProductOrder::with('products')->where('order_id', $id)->get();
                            foreach ($ordervalidation as $op) {
                                $dc[] = $op->products->vendor_id;
                            }
                            if (in_array($vendorid, $dc)) {
                                $area_detail = @Area::where('id', $record->address_detail->area)->first();
                                if ($record->delivery_type == 'express') {
                                    $deliver_charge = @$area_detail->express_charge;
                                } else {
                                    $deliver_charge = @$area_detail->delivery_charge;
                                }
                                $order_no = $record->order_no;
                                $user_id = $record->user_id;
                                $area_id = $record->area_id;
                                $status = $record->status;
                                $verified = wordwrap($record->verified_at, 11, "<br />\n");
                                $packed = wordwrap($record->packed_at, 11, "<br />\n");
                                $delivered = wordwrap($record->delivered_at, 11, "<br />\n");
                                $shipped = wordwrap($record->shipped_at, 11, "<br />\n");
                                $delivery_type = $record->delivery_type;
                                $total_amount = $record->total_amount;
                                $created_at = wordwrap($record->created_at->format('Y-m-d - H:i:s'), 11, "<br />\n");
                                $useraddress = @$record->address_detail->address;
                                $region = @Region::find($record->address_detail->region_id)->name;
                                $city = @City::find($record->address_detail->city)->name;
                                $area = @Area::find($record->address_detail->area)->name;
                                $colors = Color::all();
                                $size = Size::all();
                                $image_data = ProductImages::all();
                                $images = Image::all();
                                $order_detail = ProductOrder::with('products')->where('order_id', $id)->get();
                                if ($status == 'delivered') {
                                    $show_data = '<form action="/auth/order-details"><input type="hidden" value="' . $order_no . '" name="order_no"><button class="btn-transparent" type="submit">' . $order_no . '</button></form>';
                                } else {
                                    $show_data = $order_no;
                                }
                                $data_arr[] = array(
                                    "order_no" => $show_data,
                                    "user_id" => User::find($user_id)->name,
                                    "user_address" => $useraddress,
                                    "user_d" => $order_detail,
                                    "colors" => $colors,
                                    "size" => $size,
                                    "verify" => $verified,
                                    "deliver" => $delivered,
                                    "pack" => $packed,
                                    "ship" => $shipped,
                                    "image_data" => $image_data,
                                    "images" => $images,
                                    "user_region" => $region,
                                    "user_city" => $city,
                                    "user_area" => $area,
                                    "area_id" => @Area::find($area_id)->name,
                                    "delivery_type" => $delivery_type,
                                    "delivery_charge" => $deliver_charge,
                                    "total_amount" => $total_amount,
                                    "status" => $status,
                                    "created_at" => $created_at,
                                    "action" => '<div class="dropdown">
                                      <button class="dropbtn">Action</button>
                                      <div class="dropdown-content">
                                         <ul>
                                            <li value="' . $id . '" class="' . (($status == 'verified') ? 'hidden' : '') . '">Verified</li>
                                            <li value="' . $id . '" class="' . (($status == 'packed') ? 'hidden' : '') . '">Packed</li>
                                            <li value="' . $id . '" class="' . (($status == 'shipped') ? 'hidden' : '') . '">Shipped</li>
                                            <li value="' . $id . '" class="' . (($status == 'delivered') ? 'hidden' : '') . '">Delivered</li>
                                         </ul>
                                      </div>
                                    </div>'

                                );
                            }
                        }
                    }
                    return response()->json(['data' => $data_arr]);
                }else if(!empty($request->start) && !empty($request->end) && empty($request->orderid)){
                    //two filter conditions for sorting orders in all remaining tables.
                    $records = Order::whereBetween('created_at', array($request->start, $request->end))
                        ->where('status', $request->ret)->get();
                    foreach ($records as $record) {
                        $id = $record->id;
                        if ($currentroles == 'admin') {
                            //listing all the orders for admin with two filter conditions
                            $area_detail = @Area::where('id', $record->address_detail->area)->first();
                            if ($record->delivery_type == 'express') {
                                $deliver_charge = @$area_detail->express_charge;
                            } else {
                                $deliver_charge = @$area_detail->delivery_charge;
                            }
                            $order_no = $record->order_no;
                            $user_id = $record->user_id;
                            $area_id = $record->area_id;
                            $status = $record->status;
                            $verified = wordwrap($record->verified_at, 11, "<br />\n");
                            $packed = wordwrap($record->packed_at, 11, "<br />\n");
                            $delivered = wordwrap($record->delivered_at, 11, "<br />\n");
                            $shipped = wordwrap($record->shipped_at, 11, "<br />\n");
                            $delivery_type = $record->delivery_type;
                            $total_amount = $record->total_amount;
                            $created_at = wordwrap($record->created_at->format('Y-m-d - H:i:s'), 11, "<br />\n");
                            $useraddress = @$record->address_detail->address;
                            $region = @Region::find($record->address_detail->region_id)->name;
                            $city = @City::find($record->address_detail->city)->name;
                            $area = @Area::find($record->address_detail->area)->name;
                            $colors = Color::all();
                            $size = Size::all();
                            $image_data = ProductImages::all();
                            $images = Image::all();
                            $order_detail = ProductOrder::with('products')->where('order_id', $id)->get();
                            if ($status == 'delivered') {
                                $show_data = '<form action="/auth/order-details"><input type="hidden" value="' . $order_no . '" name="order_no"><button class="btn-transparent" type="submit">' . $order_no . '</button></form>';
                            } else {
                                $show_data = $order_no;
                            }
                            $data_arr[] = array(
                                "order_no" => $show_data,
                                "user_id" => User::find($user_id)->name,
                                "user_address" => $useraddress,
                                "user_d" => $order_detail,
                                "colors" => $colors,
                                "size" => $size,
                                "verify" => $verified,
                                "deliver" => $delivered,
                                "pack" => $packed,
                                "ship" => $shipped,
                                "image_data" => $image_data,
                                "images" => $images,
                                "user_region" => $region,
                                "user_city" => $city,
                                "user_area" => $area,
                                "area_id" => @Area::find($area_id)->name,
                                "delivery_type" => $delivery_type,
                                "delivery_charge" => $deliver_charge,
                                "total_amount" => $total_amount,
                                "status" => $status,
                                "created_at" => $created_at,
                                "action" => '<div class="dropdown">
                                      <button class="dropbtn">Action</button>
                                      <div class="dropdown-content">
                                         <ul>
                                            <li value="' . $id . '" class="' . (($status == 'verified') ? 'hidden' : '') . '">Verified</li>
                                            <li value="' . $id . '" class="' . (($status == 'packed') ? 'hidden' : '') . '">Packed</li>
                                            <li value="' . $id . '" class="' . (($status == 'shipped') ? 'hidden' : '') . '">Shipped</li>
                                            <li value="' . $id . '" class="' . (($status == 'delivered') ? 'hidden' : '') . '">Delivered</li>
                                         </ul>
                                      </div>
                                    </div>'

                            );
                        } else {
                            //listing the vendor specific order with two filter conditions
                            $vendor = Vendor::where('user_id', $currentid)->first();
                            $vendorid = $vendor->id;
                            $ordervalidation = ProductOrder::with('products')->where('order_id', $id)->get();
                            foreach ($ordervalidation as $op) {
                                $dc[] = $op->products->vendor_id;
                            }
                            if (in_array($vendorid, $dc)) {
                                $area_detail = @Area::where('id', $record->address_detail->area)->first();
                                if ($record->delivery_type == 'express') {
                                    $deliver_charge = @$area_detail->express_charge;
                                } else {
                                    $deliver_charge = @$area_detail->delivery_charge;
                                }
                                $order_no = $record->order_no;
                                $user_id = $record->user_id;
                                $area_id = $record->area_id;
                                $status = $record->status;
                                $verified = wordwrap($record->verified_at, 11, "<br />\n");
                                $packed = wordwrap($record->packed_at, 11, "<br />\n");
                                $delivered = wordwrap($record->delivered_at, 11, "<br />\n");
                                $shipped = wordwrap($record->shipped_at, 11, "<br />\n");
                                $delivery_type = $record->delivery_type;
                                $total_amount = $record->total_amount;
                                $created_at = wordwrap($record->created_at->format('Y-m-d - H:i:s'), 11, "<br />\n");
                                $useraddress = @$record->address_detail->address;
                                $region = @Region::find($record->address_detail->region_id)->name;
                                $city = @City::find($record->address_detail->city)->name;
                                $area = @Area::find($record->address_detail->area)->name;
                                $colors = Color::all();
                                $size = Size::all();
                                $image_data = ProductImages::all();
                                $images = Image::all();
                                $order_detail = ProductOrder::with('products')->where('order_id', $id)->get();
                                if ($status == 'delivered') {
                                    $show_data = '<form action="/auth/order-details"><input type="hidden" value="' . $order_no . '" name="order_no"><button class="btn-transparent" type="submit">' . $order_no . '</button></form>';
                                } else {
                                    $show_data = $order_no;
                                }
                                $data_arr[] = array(
                                    "order_no" => $show_data,
                                    "user_id" => User::find($user_id)->name,
                                    "user_address" => $useraddress,
                                    "user_d" => $order_detail,
                                    "colors" => $colors,
                                    "size" => $size,
                                    "verify" => $verified,
                                    "deliver" => $delivered,
                                    "pack" => $packed,
                                    "ship" => $shipped,
                                    "image_data" => $image_data,
                                    "images" => $images,
                                    "user_region" => $region,
                                    "user_city" => $city,
                                    "user_area" => $area,
                                    "area_id" => @Area::find($area_id)->name,
                                    "delivery_type" => $delivery_type,
                                    "delivery_charge" => $deliver_charge,
                                    "total_amount" => $total_amount,
                                    "status" => $status,
                                    "created_at" => $created_at,
                                    "action" => '<div class="dropdown">
                                      <button class="dropbtn">Action</button>
                                      <div class="dropdown-content">
                                         <ul>
                                            <li value="' . $id . '" class="' . (($status == 'verified') ? 'hidden' : '') . '">Verified</li>
                                            <li value="' . $id . '" class="' . (($status == 'packed') ? 'hidden' : '') . '">Packed</li>
                                            <li value="' . $id . '" class="' . (($status == 'shipped') ? 'hidden' : '') . '">Shipped</li>
                                            <li value="' . $id . '" class="' . (($status == 'delivered') ? 'hidden' : '') . '">Delivered</li>
                                         </ul>
                                      </div>
                                    </div>'

                                );
                            }
                        }
                    }
                    return response()->json(['data' => $data_arr]);
                    //end of search filter with 2 active filter conditions
                } else{
                    $records = Order::where('status', $request->ret)->get();
                    foreach ($records as $record) {
                        $id = $record->id;
                        if ($currentroles == 'admin') {
                            $area_detail = @Area::where('id', $record->address_detail->area)->first();
                            if ($record->delivery_type == 'express') {
                                $deliver_charge = @$area_detail->express_charge;
                            } else {
                                $deliver_charge = @$area_detail->delivery_charge;
                            }
                            $order_no = $record->order_no;
                            $user_id = $record->user_id;
                            $area_id = $record->area_id;
                            $status = $record->status;
                            $verified = wordwrap($record->verified_at, 11, "<br />\n");
                            $packed = wordwrap($record->packed_at, 11, "<br />\n");
                            $delivered = wordwrap($record->delivered_at, 11, "<br />\n");
                            $shipped = wordwrap($record->shipped_at, 11, "<br />\n");
                            $delivery_type = $record->delivery_type;
                            $total_amount = $record->total_amount;
                            $created_at = wordwrap($record->created_at->format('Y-m-d - H:i:s'), 11, "<br />\n");
                            $useraddress = @$record->address_detail->address;
                            $region = @Region::find($record->address_detail->region_id)->name;
                            $city = @City::find($record->address_detail->city)->name;
                            $area = @Area::find($record->address_detail->area)->name;
                            $colors = Color::all();
                            $size = Size::all();
                            $image_data = ProductImages::all();
                            $images = Image::all();
                            $order_detail = ProductOrder::with('products')->where('order_id', $id)->get();
                            if ($status == 'delivered') {
                                $show_data = '<form action="/auth/order-details"><input type="hidden" value="' . $order_no . '" name="order_no"><button class="btn-transparent" type="submit">' . $order_no . '</button></form>';
                            } else {
                                $show_data = $order_no;
                            }
                            $data_arr[] = array(
                                "order_no" => $show_data,
                                "user_id" => User::find($user_id)->name,
                                "user_address" => $useraddress,
                                "user_d" => $order_detail,
                                "colors" => $colors,
                                "size" => $size,
                                "verify" => $verified,
                                "deliver" => $delivered,
                                "pack" => $packed,
                                "ship" => $shipped,
                                "image_data" => $image_data,
                                "images" => $images,
                                "user_region" => $region,
                                "user_city" => $city,
                                "user_area" => $area,
                                "area_id" => @Area::find($area_id)->name,
                                "delivery_type" => $delivery_type,
                                "delivery_charge" => $deliver_charge,
                                "total_amount" => $total_amount,
                                "status" => $status,
                                "created_at" => $created_at,
                                "action" => '<div class="dropdown">
                                      <button class="dropbtn">Action</button>
                                      <div class="dropdown-content">
                                         <ul>
                                            <li value="' . $id . '" class="' . (($status == 'verified') ? 'hidden' : '') . '">Verified</li>
                                            <li value="' . $id . '" class="' . (($status == 'packed') ? 'hidden' : '') . '">Packed</li>
                                            <li value="' . $id . '" class="' . (($status == 'shipped') ? 'hidden' : '') . '">Shipped</li>
                                            <li value="' . $id . '" class="' . (($status == 'delivered') ? 'hidden' : '') . '">Delivered</li>
                                         </ul>
                                      </div>
                                    </div>'

                            );
                        } else {
                            $vendor = Vendor::where('user_id', $currentid)->first();
                            $vendorid = $vendor->id;
                            $ordervalidation = ProductOrder::with('products')->where('order_id', $id)->get();
                            foreach ($ordervalidation as $op) {
                                $dc[] = $op->products->vendor_id;
                            }
                            if (in_array($vendorid, $dc)) {
                                $area_detail = @Area::where('id', $record->address_detail->area)->first();
                                if ($record->delivery_type == 'express') {
                                    $deliver_charge = @$area_detail->express_charge;
                                } else {
                                    $deliver_charge = @$area_detail->delivery_charge;
                                }
                                $order_no = $record->order_no;
                                $user_id = $record->user_id;
                                $area_id = $record->area_id;
                                $status = $record->status;
                                $verified = wordwrap($record->verified_at, 11, "<br />\n");
                                $packed = wordwrap($record->packed_at, 11, "<br />\n");
                                $delivered = wordwrap($record->delivered_at, 11, "<br />\n");
                                $shipped = wordwrap($record->shipped_at, 11, "<br />\n");
                                $delivery_type = $record->delivery_type;
                                $total_amount = $record->total_amount;
                                $created_at = wordwrap($record->created_at->format('Y-m-d - H:i:s'), 11, "<br />\n");
                                $useraddress = @$record->address_detail->address;
                                $region = @Region::find($record->address_detail->region_id)->name;
                                $city = @City::find($record->address_detail->city)->name;
                                $area = @Area::find($record->address_detail->area)->name;
                                $colors = Color::all();
                                $size = Size::all();
                                $image_data = ProductImages::all();
                                $images = Image::all();
                                $order_detail = ProductOrder::with('products')->where('order_id', $id)->get();
                                if ($status == 'delivered') {
                                    $show_data = '<form action="/auth/order-details"><input type="hidden" value="' . $order_no . '" name="order_no"><button class="btn-transparent" type="submit">' . $order_no . '</button></form>';
                                } else {
                                    $show_data = $order_no;
                                }
                                $data_arr[] = array(
                                    "order_no" => $show_data,
                                    "user_id" => User::find($user_id)->name,
                                    "user_address" => $useraddress,
                                    "user_d" => $order_detail,
                                    "colors" => $colors,
                                    "size" => $size,
                                    "verify" => $verified,
                                    "deliver" => $delivered,
                                    "pack" => $packed,
                                    "ship" => $shipped,
                                    "image_data" => $image_data,
                                    "images" => $images,
                                    "user_region" => $region,
                                    "user_city" => $city,
                                    "user_area" => $area,
                                    "area_id" => @Area::find($area_id)->name,
                                    "delivery_type" => $delivery_type,
                                    "delivery_charge" => $deliver_charge,
                                    "total_amount" => $total_amount,
                                    "status" => $status,
                                    "created_at" => $created_at,
                                    "action" => '<div class="dropdown">
                                      <button class="dropbtn">Action</button>
                                      <div class="dropdown-content">
                                         <ul>
                                            <li value="' . $id . '" class="' . (($status == 'verified') ? 'hidden' : '') . '">Verified</li>
                                            <li value="' . $id . '" class="' . (($status == 'packed') ? 'hidden' : '') . '">Packed</li>
                                            <li value="' . $id . '" class="' . (($status == 'shipped') ? 'hidden' : '') . '">Shipped</li>
                                            <li value="' . $id . '" class="' . (($status == 'delivered') ? 'hidden' : '') . '">Delivered</li>
                                         </ul>
                                      </div>
                                    </div>'

                                );
                            }
                        }
                    }
                    return response()->json(['data' => $data_arr]);
                }
            } else{
                return response()->json(['data' => "gey there"]);
            }
        }
        return view('admin.pages.orders');
    }

    public function ajaxProductsget(Request $request){
        if($request->ajax()){
            $draw = $request->get('draw');
            $rowperpage = $request->get("length");
            $totalRecords = Product::select('count(*) as allcount')->count();
            $totalRecordswithFilter = Product::select('count(*) as allcount')->count();
            $allProducts = Product::orderBy('created_at', 'DESC')->with('sizes')
            ->when(auth()->user()->roles == 'vendor', function ($query) {
                $vendor_data = Vendor::where('user_id', auth()->user()->id)->pluck('id')->first();
                $query->whereHas('product', function ($q) use ($vendor_data) {
                    $q->where('vendor_id', $vendor_data);
                });
            })->take($rowperpage)->get();
            $data_arr = array();
            $message = "'Are you sure you want to delete this?'";
            foreach($allProducts as $productList){
                $id = $productList->id;
                $title = wordwrap($productList->name, 40, "<br />\n");
                $category_id = $productList->category->name;
                $brand_id = @$productList->brand->name;
                $status = $productList->status;
                $sizes = ProductSize::with(['colorInfo','sizeInfo'])->where('product_id', $id)->groupBy('size_id')->get();
                $created_at = $productList->created_at;
                $data_arr[] = array(
                    "id" => "<input type='checkbox' class='sorting_disabled' name='delete_items' value= ". $id .">",
                    "title" => $title,
                    "category_id" => $category_id,
                    "brand" => $brand_id,
                    "sizes" => $sizes,
                    "status" => $status,
                    "created_at" => $created_at->format('Y-m-d - H:i:s'),
                    "action" => '<a href="/auth/products/'. $id .'/edit" class="btn btn-primary btn-xs">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                     <a style="display:inline-block" onclick="return confirm('. $message .')">
                                        <form method="POST" action="'.route('products.destroy', $id).'" accept-charset="UTF-8">
                                            <input name="_method" type="hidden" value="DELETE">
                                            <input name="_token" type="hidden" value="'. @csrf_token() .'">
                                            <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-trash-o"></i></button>
                                      </form>
                                    </a>'
                );
            }

            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordswithFilter,
                "aaData" => $data_arr
            );

            echo json_encode($response);
            exit;
        }
    }

    public function ajaxOrderDetail(Request $request)
    {
        if ($request->ajax()) {
            $data_arr = array();
            if (!empty($request->order_no)) {
                $order_id = Order::where('order_no', $request->order_no)->first();
                if(auth()->user()->roles == 'vendor'){
                    $vendor_id = \App\Models\Vendor::where('user_id', auth()->user()->id)->pluck('id')->first();
                    $records = \App\Models\Order::with(['order_products' => function($query) use ($vendor_id) {
                            $query->whereHas('products', function ($query) use ($vendor_id) {
                                $query->where('vendor_id', $vendor_id);
                            });
                    }])->where('order_no',$request->order_no)->get();
                    foreach ($records as $record) {
                        foreach($record->order_products as $recorded){
                            $id = $record->id;

                            $order_detail = ProductSize::with('product')->where('product_id', $recorded->product_id)->first();
                            $user_detail = Order::where('id',1)->first();
                            $address_book_data = AddressBook::where('id', $user_detail->address_book_id)->first();
                            $area_detail = @Area::where('id', $address_book_data->area)->first();
                            if ($user_detail->delivery_type == 'express') {
                                $deliver_charge = @$area_detail->express_charge;
                            } else {
                                $deliver_charge = @$area_detail->delivery_charge;
                            }
                            $seller_sku = $order_detail->product->sku;
                            $jojayo_sku = $order_detail->product->jojayo_sku;
                            $product_name = $order_detail->product->name;
                            $price = $order_detail->selling_price;
                            $deliver_charge = @$deliver_charge;
                            $commission_data = Commission::where('max_range', '<=' ,$price)->first();
                            $vendor_commission = VendorCommission::where('commission_id', $commission_data->id)->where('vendor_id', $order_detail->product->vendor_id)->first();
                            if(date('d', strtotime($user_detail->created_at)) > 7 && date('d', strtotime($user_detail->created_at)) <= 14){
                            $account_statement = date('d F Y',strtotime($user_detail->created_at)).' - '.date('14 F Y',strtotime($user_detail->created_at));
                            } elseif(date('d', strtotime($user_detail->created_at)) > 14 && date('d', strtotime($user_detail->created_at)) <= 21) {
                                $account_statement = date('d F Y',strtotime($user_detail->created_at)).' - '.date('21 F Y',strtotime($user_detail->created_at));
                            } elseif(date('d', strtotime($user_detail->created_at)) > 21 && date('d', strtotime($user_detail->created_at)) <= 28) {
                                $account_statement = date('d F Y',strtotime($user_detail->created_at)).' - '.date('28 F Y',strtotime($user_detail->created_at));
                            } elseif(date('d', strtotime($user_detail->created_at)) <= 7) {
                                $account_statement = date('d F Y',strtotime($user_detail->created_at)).' - '.date('7 F Y',strtotime($user_detail->created_at));
                            }
                            $data_arr[] = array(
                                "seller_sku" => $seller_sku,
                                "jojayo_sku" => $jojayo_sku,
                                "product" => $product_name,
                                "price" => $price,
                                "delivery_type" => ucfirst($user_detail->delivery_type),
                                "shipping" => $deliver_charge,
                                "status" => ucfirst($user_detail->status),
                                "commission" => ($vendor_commission->percent / 100) * $price,
                                "created_at" => date('Y-m-d H:i:s',strtotime($user_detail->created_at)),
                                "transaction" => $account_statement
                            );
                        }
                    }
                } else {
                    $records = ProductOrder::where('order_id', $order_id->id)->get();
                    foreach ($records as $record) {
                        $id = $record->id;
                        // if(auth()->user()->roles == 'vendor'){
                        //     $order_detail = ProductSize::with('product')->where('product_id', $record['order_products'][0]->product_id)->first();
                        // } else {
                        // $order_detail = ProductSize::with('product')->where('product_id', $record->product_id)->first();
                        // }
                        $order_detail = ProductSize::with('product')->where('product_id', $record->product_id)->first();
                        $user_detail = Order::where('id',1)->first();
                        $address_book_data = AddressBook::where('id', $user_detail->address_book_id)->first();
                        $area_detail = @Area::where('id', $address_book_data->area)->first();
                        if ($user_detail->delivery_type == 'express') {
                            $deliver_charge = @$area_detail->express_charge;
                        } else {
                            $deliver_charge = @$area_detail->delivery_charge;
                        }
                        $seller_sku = $order_detail->product->sku;
                        $jojayo_sku = $order_detail->product->jojayo_sku;
                        $product_name = $order_detail->product->name;
                        $price = $order_detail->selling_price;
                        $deliver_charge = @$deliver_charge;
                        $commission_data = Commission::where('max_range', '<=' ,$price)->first();
                        $vendor_commission = VendorCommission::where('commission_id', $commission_data->id)->where('vendor_id', $order_detail->product->vendor_id)->first();
                        if(date('d', strtotime($user_detail->created_at)) > 7 && date('d', strtotime($user_detail->created_at)) <= 14){
                          $account_statement = date('d F Y',strtotime($user_detail->created_at)).' - '.date('14 F Y',strtotime($user_detail->created_at));
                        } elseif(date('d', strtotime($user_detail->created_at)) > 14 && date('d', strtotime($user_detail->created_at)) <= 21) {
                            $account_statement = date('d F Y',strtotime($user_detail->created_at)).' - '.date('21 F Y',strtotime($user_detail->created_at));
                        } elseif(date('d', strtotime($user_detail->created_at)) > 21 && date('d', strtotime($user_detail->created_at)) <= 28) {
                            $account_statement = date('d F Y',strtotime($user_detail->created_at)).' - '.date('28 F Y',strtotime($user_detail->created_at));
                        } elseif(date('d', strtotime($user_detail->created_at)) <= 7) {
                            $account_statement = date('d F Y',strtotime($user_detail->created_at)).' - '.date('7 F Y',strtotime($user_detail->created_at));
                        }
                        $data_arr[] = array(
                            "seller_sku" => $seller_sku,
                            "jojayo_sku" => $jojayo_sku,
                            "product" => $product_name,
                            "price" => $price,
                            "delivery_type" => ucfirst($user_detail->delivery_type),
                            "shipping" => $deliver_charge,
                            "status" => ucfirst($user_detail->status),
                            "commission" => ($vendor_commission->percent / 100) * $price,
                            "created_at" => date('Y-m-d H:i:s',strtotime($user_detail->created_at)),
                            "transaction" => $account_statement
                        );
                    }
                }

                return response()->json(['data' => $data_arr]);
            } else{
                return response()->json(['data' => "gey there"]);
            }
        }
        return view('admin.pages.order_detail');
    }

//    getting the order_id for the autocomplete in search filter
  public function orderid(Request $request){
      $search = $request->search;

      if($search == ''){
          $employees = Order::orderby('order_no','asc')->select('order_no','order_no')->limit(8)->get();
      }else{
          $employees = Order::orderby('order_no','asc')->select('order_no','order_no')->where('order_no', 'like', '%' .$search . '%')->limit(8)->get();
      }

      $response = array();
      foreach($employees as $employee){
          $response[] = array("value"=>$employee->order_no,"label"=>$employee->order_no);
      }

      return response()->json($response);
  }

}
