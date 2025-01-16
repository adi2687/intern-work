<?php
// errors(1);

$currentEMail = App::getUser()['email'];

controller("Wedding");
$wedding = new Wedding();


?>

<!-- WhatsApp Floating Button -->
<div>
  <a href="https://wa.me/+919121325466" target="_blank" class="whatsapp-btn">
    <i class="bi bi-whatsapp"></i> 
  </a>
</div>

<div class="ms-3 col-md-9 ms-sm-auto col-lg-10 px-md-4 text-center mt-2" >

      <a class="btn btn-sm btn-primary-outline fs-3 ms-auto d-lg-none collapsed" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu" style="text-decoration: none;">
        <i class="bi bi-list"></i> Menu
      </a>

</div>

<aside id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-primary text-secondary sidebar collapse overflow-auto">
  <div class="position-sticky pt-3">

    <div class="dropdown mt-3 fs-5">
      <strong class="ms-3 me-5">
        <i class="bi bi-person-circle"></i> Hi
        <?= explode(' ', App::getUser()['name'])[0] ?>!
      </strong>
      <a href="#"
        class="dropdown-toggle text-decoration-none text-secondary bi bi-three-dots-vertical dropdownHide fs-5 pe-3 float-end"
        id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false"></a>
      <ul class="dropdown-menu text-small shadow" id="Menu"
        style="z-index: 1000000 !important; transform: translate3d(110px, 30px, 10px) !important;"
        aria-labelledby="dropdownUser2">

        <li><a href="<?php echo route('partner/profile'); ?>" class="dropdown-item">
            <i class="bi bi-person-fill"></i> Profile</a></li>
            
        <li><a class="dropdown-item text-danger fw-bold mt-3" id="logout" href="<?php echo route('logout'); ?>"><i
              class="bi bi-box-arrow-left"></i> Logout</a></li>
      </ul>
    </div>

    <hr>
    <ul class="nav flex-column">

      <li class="nav-item my-2">
        <a class="nav-link dashboard" aria-current="page" href="<?php echo route('dashboard'); ?>">
          <i class="bi bi-house-door"></i>
          Dashboard
        </a>
      </li>

  
       <!--  <li class="nav-item my-2">
        <a class="nav-link smartcards" aria-current="page" href="<?php echo route('smartcards'); ?>">
         <i class="bi bi-envelope-paper-heart-fill"></i>
          Smart Cards
        </a>
      </li>

       <li class="nav-item my-2">
        <a class="nav-link arinvites" aria-current="page" href="<?php echo route('arinvites'); ?>">
          <i class="bi bi-upc-scan"></i>
          AR Invites
        </a>
      </li>
 -->  
      <li class="nav-item my-2">
        <a class="nav-link myorders" aria-current="page" href="<?php echo route('myorders'); ?>">
          <i class="bi bi-bag-check-fill"></i>
          My Orders
        </a>
      </li>

      <li class="nav-item my-2">
        <a class="nav-link users" aria-current="page" href="<?php echo route('users'); ?>">
          <i class="bi bi-people"></i>
          Users
        </a>
      </li>


       <li class="nav-item my-2">
        <a class="nav-link orders" aria-current="page" href="<?php echo route('orders'); ?>">
          <i class="bi bi-bag-check-fill"></i>
          All Orders
        </a>
      </li>


       <li class="nav-item my-2">
        <a class="nav-link offers" aria-current="page" href="<?php echo route('offers'); ?>">
          <i class="bi bi-percent"></i>
          Offers
        </a>
      </li>



    </ul>
  </div>
</aside>


<!-- Off-canvas Sidebar (for small screens) -->
<div class="offcanvas offcanvas-start bg-primary text-white" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
  <div class="offcanvas-header text-white">
    <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
    <a type="button" class="btn-close text-reset text-white" data-bs-dismiss="offcanvas" aria-label="Close"></a>
  </div>

  <div class="offcanvas-body">
       <div class="dropdown mt-3 fs-5">
      <strong class="ms-3 me-5">
        <i class="bi bi-person-circle"></i> Hi <?= explode(' ', App::getUser()['name'])[0] ?>!
      </strong>
      <a href="#" class="dropdown-toggle text-decoration-none text-secondary bi bi-three-dots-vertical dropdownHide fs-5 pe-3 float-end"
         id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false"></a>
      <ul class="dropdown-menu text-small shadow" id="Menu"
          style="z-index: 1000000 !important; transform: translate3d(110px, 30px, 10px) !important;"
          aria-labelledby="dropdownUser2">
        <li><a href="<?php echo route('user/profile'); ?>" class="dropdown-item"><i class="bi bi-person-fill"></i> Profile</a></li>
        <li><a class="dropdown-item text-danger fw-bold mt-3" id="logout" href="<?php echo route('logout'); ?>"><i class="bi bi-box-arrow-left"></i> Logout</a></li>
      </ul>
    </div>

    <hr>

    <ul class="nav flex-column">
      <li class="nav-item my-2 d-flex align-items-center">
        <a class="nav-link dashboard text-white" href="<?php echo route('dashboard'); ?>">
          <i class="bi bi-house-door"></i> <span class="menu-text ms-2">Dashboard</span>
        </a>

      </li>

    
      <li class="nav-item my-2">
        <a class="nav-link myorders text-white" aria-current="page" href="<?php echo route('myorders'); ?>">
          <i class="bi bi-bag-check-fill"></i>
          My Orders
        </a>
      </li>

        <li class="nav-item my-2">
        <a class="nav-link users text-white" aria-current="page" href="<?php echo route('users'); ?>">
          <i class="bi bi-people"></i> <span class="menu-text ms-2">Users</span>
        </a>
      </li>



     <!--    <li class="nav-item my-2">
        <a class="nav-link smartcards text-white" aria-current="page" href="<?php echo route('smartcards'); ?>">
         <i class="bi bi-envelope-paper-heart-fill"></i>
          Smart Cards
        </a>
      </li>

       <li class="nav-item my-2">
        <a class="nav-link arinvites text-white" aria-current="page" href="<?php echo route('arinvites'); ?>">
          <i class="bi bi-upc-scan"></i>
          AR Invites
        </a>
      </li> -->

       <li class="nav-item my-2">
        <a class="nav-link orders text-white" aria-current="page" href="<?php echo route('orders'); ?>">
          <i class="bi bi-bag-check-fill"></i> <span class="menu-text ms-2">All Orders</span>
        </a>
      </li>



       <li class="nav-item my-2">
        <a class="nav-link offers text-white" aria-current="page" href="<?php echo route('offers'); ?>">
          <i class="bi bi-percent"></i> <span class="menu-text ms-2">Offers</span>
        </a>
      </li>

    </ul>

    </ul>
  </div>
</div>


<!-- Custom CSS for Menu Hover -->
<style>
  
 .whatsapp-btn {
    position: fixed;
    bottom: 30px;
    right: 20px;
    z-index: 99999;
    background-color: #25D366;
    color: white;
    border-radius: 50%;
    padding: 10px 15px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    cursor: pointer;
  }
  .whatsapp-btn:hover {
    background-color: #20bf54;
    color: white;
  }
  .offcanvas-body .nav-link {
    display: flex;
    align-items: center;
    padding: 10px;
    padding: 10px 15px;
    margin: 0;
  }

  .offcanvas-body .nav-link i {
    font-size: 1.5rem;
  }

  .offcanvas {
    width: 250px;
    overflow-x: hidden; 
    overflow-y: auto; 
    max-height: 100vh; 
}



/*@media (max-width: 576px) {
    .offcanvas {
        width: 100%; 
    }
}
*/
</style>


<script type="text/javascript">
  var url = window.location.pathname
  console.log(url)
  switch (url) {
    
      case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . "/dashboard" : "/dashboard" ?>":
      document.querySelector(".dashboard").classList.toggle("active");
      document.querySelector(".offcanvas-body .dashboard").classList.toggle("active");
      break;

      case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . "/myorders" : "/myorders" ?>":
      document.querySelector(".myorders").classList.toggle("active");
      document.querySelector(".offcanvas-body .myorders").classList.toggle("active");
      break;

      case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . "/users" : "/users" ?>":
      document.querySelector(".users").classList.toggle("active");
      document.querySelector(".offcanvas-body .users").classList.toggle("active");
      break;

      case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . "/smartcards" : "/smartcards" ?>":
      document.querySelector(".smartcards").classList.toggle("active");
      document.querySelector(".offcanvas-body .smartcards").classList.toggle("active");
      break;

      case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . "/arinvites" : "/arinvites" ?>":
      document.querySelector(".arinvites").classList.toggle("active");
      document.querySelector(".offcanvas-body .arinvites").classList.toggle("active");
      break;

       case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . "/orders" : "/orders" ?>":
      document.querySelector(".orders").classList.toggle("active");
      document.querySelector(".offcanvas-body .orders").classList.toggle("active");
      break;

      case "<?php echo !empty($config['APP_SLUG']) ? '/' . $config['APP_SLUG'] . "/offers" : "/offers" ?>":
      document.querySelector(".offers").classList.toggle("active");
      document.querySelector(".offcanvas-body .offers").classList.toggle("active");
      break;


  }
</script>