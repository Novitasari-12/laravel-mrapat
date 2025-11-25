<?php 
namespace App\MyLibraries\Crud;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class GenerateCrud extends Controller {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $model ;

    public function getModel(){
        return $this->model ;
    }

    /**
     * return [ 
     *      'field' => $request->get('field', $model->field), 
     *       ..., 
     *      'fieldN' => $request->get('fieldN', $model->fieldN) 
     * ]
     */
    public function myRequestValue($request, $model){
        return [];
    }

    private function myRequestData($request, $model = []){
        $model = $model != null ? $model : $request;
        return $this->myRequestValue($request, $model);
    }

    /**
     * return [
     *      'field' => ['required', 'numeric', ..., 'max:12']
     * ]
     */
    public function validateStore(){
        return [];
    }

    public function setStore($request, $model){
        return response($model, 200);
    }

    public function store(Request $request){
        $this->validate($request, $this->validateStore());
        $data = $this->myRequestData($request);
        $model = $this->getModel()->create($data);
        return $this->setStore($model, $request);
    }

    public function setShow($model, $id){
        return response($model, 200) ;
    }

    public function show($id){
        switch ($id) {
            case 'all':
                $model = $this->getModel()->all();
                break;
            default:
                $model = $this->getModel()->find($id);
                break;
        }
        return $this->setShow($model, $id);
    }

    public function setUpdate($request, $model, $id){
        return response($model, 200);
    }

    public function validateUpdate(){
        return [] ;
    }

    public function setUpdateValidate(Request $request){
        $this->validate($request, $this->validateUpdate());
    }

    public function update(Request $request, $id){
        $this->setUpdateValidate($request);
        $model = $this->getModel()->find($id) ;
        $data = $this->myRequestData($request, $model);
        $model->update($data);
        return $this->setUpdate($request, $model, $id);
    }

    public function destroy($id){
        $model = $this->getModel()->find($id);
        $model->delete();
        return $model ;
    }

    /**
     * return view('resource')
     */
    public function setCreateIndex(){
        // return view index create data 
    }

    public function create(){
        return $this->setCreateIndex();
    }

    /**
     * return view('resource')
     */
    public function setUpdateIndex($id){
        // return view update data
    }
    
    public function edit($id){
        return $this->setUpdateIndex($id);
    }

    /**
     * return view('resource')
     */
    public function setIndex(){
        // return view index data 
    }

    public function index(){
        return $this->setIndex();
    }
} 