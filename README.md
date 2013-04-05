MedWave | Waves for the Future  
==================================

What is MedWave?
----------------

MedWave is a Radiology Information System (RIS).  
It provides users with:
- A method to keep track of radiology records of patients
- A method to associate patients to doctors

Requirements
------------

MedWave is supported on only PHP 5.4 and up.
* Note: PHP will require the PDO extension to be enabled.
  
MedWave requires a MySQL 5.5 or later.

Installation
------------

To install MedWave it is best to follow the step provided below, or for more detailed steps see: [MedWave Installation in-depth][2]

#### Step 1: Create MySQL Database and User
Create a MySQL Database and User for MedWave on your server. Remember the login details as you will need them.

#### Step 2: Get MedWave
Get MedWave either by downloading the zip, or cloning it via command line.

#### Step 3: Edit settings.json
Edit system/settings.json to contain your connection information. *DO NOT EDIT conName, or DB Type*

#### Step 4: Run console install script
Via command line, run `php system/console` to and follow the install commands instructions.

#### Step 5: Create Administrator Account
Via command line again, run `php system/console` and create a user with role a.

#### Step 6: Finished
Celebrate, you have now finished installing MedWave.

Systems Used
------------

* Twitter Bootstrap
* jQuery
* jQuery UI (Date Picker)
* Select2
* Imagine (Image Resizing)

Learn More
----------

For more information about MedWave, please see the wiki by following this link: [MedWave Wiki][1]


License
-------



Copyright (c) 2013 Jeremy Smereka, Amir Salimi

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.


[1]: https://github.com/ekoedmedia/MedWave/wiki
[2]: https://github.com/ekoedmedia/MedWave/wiki/Detailed-Installation
