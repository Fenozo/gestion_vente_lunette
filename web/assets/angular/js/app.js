

var myApp = angular.module('myApp', [], function($interpolateProvider)
  {
      $interpolateProvider.startSymbol('<%');
      $interpolateProvider.endSymbol('%>'); 
  });

  myApp.controller('HomeController',function($http,$scope){

    $scope.title = "New Arrivals";

    $scope.produits = [
        {
            image:'product_1.jpg',
            genre: 'men',
            title:'Fujifilm X100T 16 MP Digital Camera (Silver)',
            prix:590.00,
            remise:520.00,
            tag:{class: 'product_bubble product_bubble_right product_bubble_red d-flex flex-column align-items-center',value:-20,signe:"negative"}
        },
        {
            image:'product_2.jpg',
            genre: 'women',
            title:'Samsung CF591 Series Curved 27-Inch FHD Monitor',
            prix:610.00,
            remise:0,
            tag:{class: 'product_bubble product_bubble_left product_bubble_green d-flex flex-column align-items-center',value:'new',signe:"none"}
        },
        {
            image:'product_3.jpg',
            genre: 'women',
            title:'Blue Yeti USB Microphone Blackout Edition',
            prix:120,
            remise:0,
            tag:{class: '',value:'',signe:""}
        },
        {
            image:'women_product_4.jpg',
            genre: 'women',
            title:'DYMO LabelWriter 450 Turbo Thermal Label Printer',
            prix:410,
            remise:0,
            tag:{class: 'product_bubble product_bubble_right product_bubble_red d-flex flex-column align-items-center',value:'sale',signe:""}
        },
        {
            image:'product_5.jpg',
            genre: 'men',
            title:'Pryma Headphones, Rose Gold & Grey',
            prix:180,
            remise:0,
            tag:{class: '',value:'',signe:""}
        },
        {
            image:'product_7.jpg',
            genre: 'women',
            title:'Samsung CF591 Series Curved 27-Inch FHD Monitor',
            prix:610,
            remise:0,
            tag:{class: '',value:'',signe:""}
        },
        {
            image:'children_product_8.jpg',
            genre: 'children',
            title:'Blue Yeti USB Microphone Blackout Edition',
            prix:120,
            remise:0,
            tag:{class: '',value:'',signe:""}
        }
        ,
        {
            image:'children_product_9.jpg',
            genre: 'children',
            title:'DYMO LabelWriter 450 Turbo Thermal Label Printer',
            prix:410,
            remise:0,
            tag:{class: 'product_bubble product_bubble_right product_bubble_red d-flex flex-column align-items-center',value:'sale',signe:""}
        }
        ,
        {
            image:'women_product_10.jpeg',
            genre: 'women',
            title:'Pryma Headphones, Rose Gold & Grey',
            prix:180,
            remise:0,
            tag:{class: '',value:'',signe:""}
        }
        ,
        {
        image:'men_product_6.png',
            genre: 'men',
            title:'Pryma Headphones, Rose Gold & Grey',
            prix:180,
            remise:0,
            tag:{class: '',value:'',signe:""}
        }
        ,
        {
        image:'mixte_product_1.jpg',
            genre: 'mixtes',
            title:'Pryma Headphones, Rose Gold & Grey',
            prix:180,
            remise:0,
            tag:{class: '',value:'',signe:""}
        }
        ,
        {
        image:'mixte_product_2.jpg',
            genre: 'mixtes',
            title:'Pryma Headphones, Rose Gold & Grey',
            prix:180,
            remise:0,
            tag:{class: '',value:'',signe:""}
        }
    ];

    $scope.varFilter ="all";

    $scope.filter_gender = function(argument) {
    $scope.varFilter = argument;
    if (argument == 'all') {
        $scope.all = false;
    } else {
        $scope.all = true;
    }
}

   

  });