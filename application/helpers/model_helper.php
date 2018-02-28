<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



   /**
    *
    * Allow models to use other models
    *
    * This is a substitute for the inability to load models
    * inside of other models in CodeIgniter.  Call it like
    * this:
    *
    * $salaries = model_load_model('salary');
    * ...
    * $salary = $salaries->get_salary($employee_id);
    *
    * @param string $model_name The name of the model that is to be loaded
    *
    * @return object The requested model object
    *
    */
   function model_load_model($model_name)
   {
      $CI =& get_instance();
      $CI->load->model($model_name);
      $temp = explode('/',$model_name);
      $model_name = $temp[count($temp)-1];
      return $CI->$model_name;
   }
   
   function load_basic_model($tablename){
       $CI =& get_instance();
       $basicModel = model_load_model('basic_model');
       $basicModel->tablename = $tablename;
       return $basicModel;
   }