<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
      <link rel="stylesheet" href="{{asset('app.css')}}">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Poiret+One&family=Quicksand:wght@300;400;500;600&display=swap" rel="stylesheet">
      <title>Admin Panel</title>
   </head>
   <body>
      <nav class="navbar navbar-expand-lg bg-white navbar-dark">
         <div class="container-fluid">
            <div class="navbar-collapse">
               <ul class="navbar-nav">
                  <li class="nav-item dropdown order-last">
                     <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user text-dark"></i>
                     </a>
                     <ul class="dropdown-menu" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="/">Logout</a></li>
                     </ul>
                  </li>
               </ul>
            </div>
         </div>
      </nav>
      <div class="container-fluid">
         <div class="row justify-content-center">
            <div class="col-xl-3 col-md-6">
               <a href="#new">
                  <div class="card bg-secondary text-white">
                     <div class="card-body">
                        <div class="mb-4">
                           <div class="float-left mini-stat-img mr-4">
                              <span class="ti-id-badge" style="font-size: 30px"></span>
                           </div>
                           <h5 class="font-16 text-uppercase mt-0 text-white">Add New<br> Services</h5>
                        </div>
                        <span class="ti-user float-left" style="font-size: 71px"></span>
                     </div>
                  </div>
               </a>
            </div>
            <div class="col-xl-3 col-md-6">
               <a href="/list">
                  <div class="card bg-secondary text-white">
                     <div class="card-body">
                        <div class="mb-4">
                           <div class="float-left mini-stat-img mr-4">
                              <span class="ti-id-badge" style="font-size: 30px"></span>
                           </div>
                           <h5 class="font-16 text-uppercase mt-0 text-white">List All <br> Services</h5>
                        </div>
                        <span class="ti-user float-left" style="font-size: 71px"></span>
                     </div>
                  </div>
               </a>
            </div>
         </div>
         <div class="row justify-content-center" id="new">
            <div class="col col-10 d-flex flex-column justify-content-center align-items-center">
               <form class="w-75 py-5" method="POST" action="addnewproduct" enctype="multipart/form-data">
                  @csrf
                  <h1 class="fw-light">Add New Service</h1>
                  <div class="form-outline mb-4 mt-3">
                     <input type="file" name="image" placeholder="Enter Email Address" id="form1Example1" class="form-control" />
                     <label class="form-label" for="form1Example1">Upload Image</label>
                  </div>
                  <div class="form-outline mb-4 mt-3">
                     <input type="text" name="name" placeholder="Enter Name" id="form1Example1" class="form-control" />
                     <label class="form-label" for="form1Example1">Name</label>
                  </div>
                  <div class="form-outline mb-4 mt-3">
                     <textarea name="description" id="" cols="30" rows="3" id="form1Example1" class="form-control"></textarea>
                     <label class="form-label" for="form1Example1">Description</label>
                  </div>
                  <div class="form-outline mb-4">
                     <input type="number" name="price" placeholder="Enter Price" id="form1Example2" class="form-control" />
                     <label class="form-label" for="form1Example2">Price</label>
                  </div>
                  @if (session('error'))
                  <div class="alert alert-danger error-message text-center" style="padding:1rem ;background: rgb(252, 161, 168); font-size:1rem; margin-top:0.7rem; border:none; color:rgb(237, 73, 86)">{{ session('error') }}</div>
                  @endif
                  @if (session('success'))
                  <div class="alert alert-success success-message text-center" style="padding:1rem;background: rgb(152, 255, 183); font-size:1rem; margin-top:0.7rem; border:none; color:rgb(1, 131, 40)">{{ session('success') }}</div>
                  @endif
                  <button type="submit" class="btn btn-success w-100 btn-block" style="background: #3c6450 !important;">Add Service</button>
               </form>
            </div>
         </div>
      </div>
   </body>
</html>
