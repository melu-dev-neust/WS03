<?php
$listing=[
    ['id'=>1 ,'title'=>'Software Engineer',
    'description'=>'We are seeking a skilled software engineer to develop a high-quality software solution',
    'salary'=>80000,'location'=>'Singapore',
    'tags'=>['Software Development','Java','Python']
    ],

    ['id'=>2 ,'title'=>'UI Designer',
    'description'=>'We are seeking a skilled UI Designer to develop a high-quality software design',
    'salary'=>70000,'location'=>'Japan',
    'tags'=>['HTML','CSS','JavaScript']
    ],

    ['id'=>3 ,'title'=>'Gumagawa ng Washing Machine',
    'description'=>'We are seeking a skilled technician to fix a high-quality washing machine',
    'salary'=>100000,'location'=>'Sa Baryo Namin',
    'tags'=>['Washing Machine','Technician','Fix']
    ],  

    ['id'=>4 ,'title'=>'Backend Developer',
    'description'=>'We are seeking a skilled Backend Developer to develop a high-quality backend solution',
    'salary'=>50000,'location'=>'Japan',
    'tags'=>[]
    ],

    ['id'=>5 ,'title'=>'Fullstack Developer',
    'description'=>'We are seeking a skilled Full Stack Developer to develop a high-quality website',
    'salary'=>90000,'location'=>'Japan',
    'tags'=>['Full Stack','React','Node']
    ]
];

    // function formatSalary($salary){
    // return '$'.number_format($salary,2);
    // }

    $formatSalary=fn($salary)=>'$'.number_format($salary,2);

// $name="Chisa";
// $greet=function() use($name){
//     echo"Hello".$name;
// };
// $greet();
//     $hello = function(){
//         echo"Helloww";
//     };
//     $hello();



function filterByLocation($listings, $location){
    return array_filter($listings, function($job)use($location){
        return strcasecmp($job['location'],$location)===0;
        });
}
    if(isset($_GET['location'])){
        $location=$_GET['location'];
        $filterlist=filterByLocation($listing,$location);
        var_dump($location);
    }
    else{
        $filteredlists=$listing;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Job Listings</title>
</head>

<body class="bg-gray-100">
    <header class="bg-blue-500 text-white p-4">
        <div class="container mx-auto">
            <h1 class="text-3xl font-semibold tracking-tight">Job Listings</h1>
        </div>
    </header>

    <div class="container mx-auto p-4 mt-4">
        <!-- Output -->
        <?php foreach($filteredlists as $index=>$job): ?>
        <div class="md my-4">

            <div class="<?= $index % 2 === 0 ? 'bg-sky-50 rounded-lg shadow-md border border-sky-500' : 'bg-blue-100 rounded-lg shadow-md' ?>">

                <div class="p-4">
                    <h2 class="text-xl font-semibold"><?= $job['title'] ?></h2>
                    <p class="text-gray-700 text-lg mt-2"><?= $job['description'] ?></p>

                    <ul class="mt-4">
                        <li class="mb-2">
                            <strong>Salary:</strong><?= $formatSalary($job['salary']) ?>
                            

                        </li>
                        <li class="mb-2">
                            <strong>Location:</strong> <?= $job['location'] ?>

                            <?= $job['location']==='Japan'? '<span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-blue-200 text-white border border-blue-600">Remote</span>':
                            '
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full bg-fuchsia-200 text-white border border-fuchsia-950">On Site</span>' ?>
                            
                            
                        
                        </li>
                        <?= !empty($job['tags']) ? '<li class="mb-2"><strong>Tags:</strong> ' . implode(', ', $job['tags']) . '</li>': '' ?>

                    </ul>
                </div>
            </div>
        
        </div>
            <?php endforeach; ?>
    </div>
</body>
</html>