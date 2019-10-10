<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Faker\Factory as Faker;
use App\project_names;
use App\Projects;
use App\Property_types;
use App\Status;
use App\Country;
use DB;
use App\Properties;
use DataTables;


class ProjectController extends Controller
{
    public function index(){
        Projects::truncate();
        Properties::truncate();

        $faker = Faker::create();
        $data = array();
        foreach (range(1,10000) as $index) {
            $singleProject = array();
            $singleProject['name'] = $faker->name;
            $data[] = $singleProject;
        }
        Projects::insert($data);

        $this->Properties();
    }

    public function Properties(){
      $faker = Faker::create();
     $pn = Projects::all()->random(1)->first();
    
     $projectId = $pn->id;
     $case1Properties = array();

     $all_property_types =  Property_types::select()->whereNotIn('type', ['House'])->get(); 
     $all_property_types = $all_property_types->toArray();

     $all_status =  Status::select()->whereNotIn('status_type', ['Inactive'])->get();
     $all_status = $all_status->toArray();

     $all_country =  Country::select('id')->whereNotIn('id', [2])->get();
     $all_country = $all_country->toArray();

        foreach (range(1,2001) as $index) {
            if (!empty($all_property_types)) {
                $property_type = $this->array_random_assoc($all_property_types)['id'];
            }
            if (!empty($all_status)) {
                $status = $this->array_random_assoc($all_status)['id'];
            }
            if (!empty($all_country)) {
                $country = $this->array_random_assoc($all_country)['id'];
            }

            // class object for insert in projects table
            $singleProperty = array();
            $project = new Projects;
            $singleProperty['title'] = $faker->title;
            $singleProperty['description'] = $faker->text(100);
            $singleProperty['bedrooms'] = $faker->randomDigit;
            $singleProperty['bathrooms'] = $faker->randomDigit;
            $singleProperty['property_type'] = $property_type;
            $singleProperty['status'] = $status;
            $singleProperty['for_sale'] = "No";
            $singleProperty['for_rent'] = "No";
            $singleProperty['project_name'] = $pn->id;
            $singleProperty['country'] = $country;

            $case1Properties[] = $singleProperty;
        }

        Properties::insert($case1Properties);

        $allProjects = Projects::select('id')->whereNotIn('id', [$pn->id])->get();
        $allProjects = $allProjects->toArray();

        $case2Properties = array();
        $alreadyAssignedProject = array();
        foreach (range(1,3000) as $index) {
            if (!empty($allProjects)) {
                $project_name = $this->array_random_assoc($allProjects)['id'];
            }
            if (!empty($all_status)) {
                $status = $this->array_random_assoc($all_status)['id'];
            }
            if (!empty($all_country)) {
                $country = $this->array_random_assoc($all_country)['id'];
            }

            $singleProperty = array();
            
            $singleProperty['title'] = $faker->title;
            $singleProperty['description'] = $faker->text(100);
            $singleProperty['bedrooms'] = 2;
            $singleProperty['bathrooms'] = $faker->randomDigit;
            $singleProperty['property_type'] = 1;
            $singleProperty['status'] = 1;
            $singleProperty['for_sale'] = "Yes";
            $singleProperty['for_rent'] = "No";
            $singleProperty['project_name'] = $project_name;
            $singleProperty['country'] = $country;
            $case2Properties[] = $singleProperty;
        }

        Properties::insert($case2Properties);
        $count = 0;
        for($i=0;$i<15;$i++){
            if($i==14){
               $range = 3999;
            } else {
               $range = 6500;
            }
           
        $case3Properties = array();
        foreach (range(1,$range) as $index) {
            if (!empty($allProjects)) {
                $project_name = $this->array_random_assoc($allProjects)['id'];
            }
            if (!empty($all_status)) {
                $status = $this->array_random_assoc($all_status)['id'];
            }
            if (!empty($all_country)) {
                $country = $this->array_random_assoc($all_country)['id'];
            }

            $singleProperty = array();
            // class object for insert in projects table
            $singleProperty['title'] = $faker->title;
            $singleProperty['description'] = $faker->text(50);
            $singleProperty['bedrooms'] = 3;
            $singleProperty['bathrooms'] = $faker->randomDigit;
            $singleProperty['property_type'] = 1;
            $singleProperty['status'] = $status;
            $singleProperty['for_sale'] = "Yes";
            $singleProperty['for_rent'] = "No";
            $singleProperty['project_name'] = $project_name;
            $singleProperty['country'] = $country;
            $case3Properties[]=$singleProperty;
          
        }

        Properties::insert($case3Properties);
        
      }
      
      echo 'Success';
    }
    public function saveData() {
        $allProjects = Projects::select('id')->whereNotIn('id', [1])->get();
        $allProjects = $allProjects->toArray();
        echo "<pre>";
        if (!empty($allProjects)) {
                $otherpn = $this->array_random_assoc($allProjects)['id'];
            }
        print_r($otherpn);die;
        print_r($allProjects);die;
    }

    public function array_random_assoc($arr, $num = 1) {
        $keys = array_keys($arr);
        shuffle($keys);
        $r = array();
        for ($i = 0; $i < $num; $i++) {
            $r = $arr[$keys[$i]];
        }
        return $r;
    }
    public function projectsList(Request $request)
    {
         return DataTables()->query(DB::table("properties")
        ->join('property_types as property_types', 'property_types.id', '=', 'properties.property_type')
        ->join('status', 'status.id', '=', 'properties.status')
        ->join('projects', 'projects.id', '=', 'properties.project_name')
        ->join('country', 'country.id', '=', 'properties.country')
        ->select('properties.title','properties.description','properties.bedrooms','properties.bathrooms','properties.for_sale','properties.for_rent','properties.project_name','property_types.type','status.status_type','projects.name','country.id','country.country'))
         ->toJson();
     }
}
