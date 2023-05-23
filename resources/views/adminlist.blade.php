<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
      <link href="https://fonts.googleapis.com/css2?family=Poiret+One&family=Quicksand:wght@300;400;500;600&display=swap" rel="stylesheet">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
         integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
      <link rel="stylesheet" href="{{asset('app.css')}}">
      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Poiret+One&family=Quicksand:wght@300;400;500;600&display=swap"
         rel="stylesheet">
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
         <div class="row justify-content-center mt-4">
            <div class="col-xl-3 col-md-6 mb-4">
               <a href="/admin">
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
            <div class="col-xl-3 col-md-6 mb-4">
               <a href="#">
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
         <div class="row justify-content-center mt-4">
            <div class="col-10">
               <div class="card">
                  <div class="card-body">
                     <table id="serviceTable" class="table my-4">
                        <thead>
                           <tr>
                              <th>Name</th>
                              <th>Description</th>
                              <th>Price</th>
                              <th>Delete</th>
                              <th>Update</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($collection as $item)
                           <tr>
                              <td>{{$item->name}}</td>
                              <td>{{$item->description}}</td>
                              <td>{{$item->price}}</td>
                              <td><a href="/delete/{{$item->name}}" class="btn btn-danger">Delete</a></td>
                              <td><a href="/update/{{$item->name}}" class="btn btn-primary">Update</a></td>
                           </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <script>
         $(document).ready(function () {
            $('#serviceTable').DataTable({});
         });
      </script>
   </body>
</html>
