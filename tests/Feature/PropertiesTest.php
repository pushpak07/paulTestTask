<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Projects;
use App\Properties;
use App\Property_types;
use App\Status;
use App\Country;
use DB;
use Faker\Factory as Faker;
class PropertiesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */


    

    //check insertion 
    public function testHasinsertProjectandProperties()
    {
        //Truncate tables before insertion 
        Projects::truncate();
        Properties::truncate();

        $faker = Faker::create();
        $data = array();
        foreach (range(1,10000) as $index) {
            $singleProject = array();
            $singleProject['name'] = $faker->name;
            $data[] = $singleProject;
        }
        Projects::insert($data);    //Insert 10000 records in project table

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

                // class object for insert records in projects table
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

            Properties::insert($case2Properties);  //insert 2001 records in properties table for There should be 1 project with 2001 properties

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

            Properties::insert($case3Properties); //Insert records in properties table for There should be 3000 properties that are 'Active' - ‘Condo’ -  'For sale: Yes' - '2 bedrooms'
            
          }

        $projects=Projects::all();
         $projects_count= $projects->count();
         $this->assertEquals(10000, $projects_count, "In project table,". $projects_count." records are available instead of 10000"); 


         $this->testHasEnoughProject();
         $this->testHasEnoughProperties();
         $this->testPropertiesHasProject();
        
    }

    //check 10000 entries are there in projects table
    public function testHasEnoughProject()
    {
         
         $projects=Projects::all();
         $projects_count= $projects->count();
         $this->assertEquals(10000, $projects_count, "In project table,". $projects_count." records are available instead of 10000"); 


    }

    //check 100000 entries are there in properties table
    public function testHasEnoughProperties()
    {
        $properties=Properties::all();
        $properties_count= $properties->count();
        $this->assertEquals(100000,$properties_count, "In properties table,". $properties_count." records are available instead of 100000"); 
    }

    //check all properties has projects are available table
    public function testPropertiesHasProject()
    {
        $properties_without_project_count=Properties::where('project_name','=',null)->where('project_name','=','')->count();
        $this->assertEquals(0,$properties_without_project_count,"In properties table ".$properties_without_project_count."  Properties are available without project ");
    }

    // //check only one project has 2001 properties available
    public function testProjecthasproperties()
    {
        $project_info = DB::table('properties')
                 ->select('project_name', DB::raw('count(*) as total'))
                 ->groupBy('project_name')
                 ->get();
          $counter=0;       
          foreach($project_info as $project)
          {
                if($project->total==2001)
                {
                    $counter+=1;
                }
          }

          $this->assertEquals(1,$counter,"Unable to find only one project which has 2001 properties");        
    }

    //There should be 0 property that are ‘Inactive’ - ‘House’ - ‘For rent: Yes’ - ‘Region 4’
    public function testPropertiesHasInActive()   
    {
        $count=Properties::where(['status'=>0,'property_type'=>2,'for_sale'=>'Yes','bedrooms'=>4])->count();
        $this->assertEquals(0,$count,"There is ".$count." properties available which has inactive status, property type is home, available for sale, and has 4 bedroom "); 
    }

    //There should be 3000 properties that are 'Active' - ‘Condo’ -  'For sale: Yes' - '2 bedrooms' 
    public function testPropertiesHasActive()   
    {
        $count=Properties::where(['status'=>1,'property_type'=>1,'for_sale'=>'Yes','bedrooms'=>2])->count();
        $this->assertEquals(3000,$count,"Unable to find 3000 properties which has status is active,2 badroom,type is condo and available for sale. Found ".$count." no of records"); 
    }


    //For get Rendom Id of project
    public function array_random_assoc($arr, $num = 1) 
    {
        $keys = array_keys($arr);
        shuffle($keys);
        $r = array();
        for ($i = 0; $i < $num; $i++) {
            $r = $arr[$keys[$i]];
        }
        return $r;
    }

     //For Temperorty test and save data
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
   

    
}
