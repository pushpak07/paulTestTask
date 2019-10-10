# paulTestTask

1. To run this project you need to add folder in xampp/wamp 
2. Create Database named fazwaz
3. Open command promp using folder path and run belove commands
	-php artisan migrate 
	-php artisan db:seed
	-php artisan serve
	
4. To insert data into to database use command 
	-php artisan project
	=> Above command will inser below datas.
		Total projects are 10,000
		Total properties are 100,000
		There should be 1 project with 2001 properties
		There should be 3000 properties that are 'Active' - ‘Condo’ -  'For sale: Yes' - '2 bedrooms'
		There should be 0 property that are ‘Inactive’ - ‘House’ - ‘For rent: Yes’ - ‘Region 4’

5. To check test cases use command 
	-phpunit
	=> Above command will check for below things.
		Total projects are 10,000
		Total properties are 100,000
		There should be 1 project with 2001 properties
		There should be 3000 properties that are 'Active' - ‘Condo’ -  'For sale: Yes' - '2 bedrooms'
		There should be 0 property that are ‘Inactive’ - ‘House’ - ‘For rent: Yes’ - ‘Region 4’