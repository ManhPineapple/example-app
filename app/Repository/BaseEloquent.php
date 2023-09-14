<?php 

namespace App\Repository;

class BaseEloquent implements InterfaceRepository 
{ 
    protected $model; 

    public function __construct ($model) 
    { 
        $this->model = $model; 
    } 

    public function all ($columns = ["*"]) 
    { 
        return $this->model->get ($columns); 
    } 

    public function paginate ($perPage = 15, $columns = ['*']) 
    { 
        return $this->model->paginate ($perPage, $columns); 
    } 

    public function create ($data = []) 
    { 
        return $this->model->create ($data); 
    } 

     public function update($data = [], $id, $attribute = 'id')
     {
         return $this->model->where($attribute, $id)->update($data);
     }

     public function delete($id)
     {
         return $this->model->destroy($id);
     }

     public function find($id, $columns = ['*'])
     {
         return $this->model->find($id, $columns);
     }

     public function findBy($field, $value, $columns = ['*'])
     {
         return $this->model->where($field, $value)->first($columns);
     }
}