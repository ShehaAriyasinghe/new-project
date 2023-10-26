<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        
         <img class="rounded-circle w-100 h-25" src="<?= SYSTEM_PATH ?>employees/images/<?= !empty($_SESSION['image'])?$_SESSION['image']:'noimage.jpeg' ?>">
        
        <span class="mx-3"><?php echo $_SESSION['firstname']."-". ucwords($_SESSION['userrole'])?></span>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="<?= SYSTEM_PATH; ?>index.php">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">


                <a class="nav-link" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <i class="bi bi-car-front"></i>
                    Item
                </a>
                <div class="collapse" id="collapseExample">

                    <ul  style="list-style-type:none">
                        <li>   
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>inventory/itemcategory.php">
                                <i class="bi bi-car-front-fill"></i>
                                Item Category
                            </a>

                        </li>

                        <li>
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>inventory/itemcategoriescards.php">
                                <i class="bi bi-car-front-fill"></i>
                                Item Catalog
                            </a>
                        </li> 
                        
                        <li>
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>inventory/itemcategoriesstock.php">
                                <i class="bi bi-car-front-fill"></i>
                                Item Stock
                            </a>
                        </li>
                        
                          
                        <li>
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>inventory/receivepurcashingstocks.php">
                                <i class="bi bi-car-front-fill"></i>
                                Received items
                            </a>
                        </li>
                        
                        
                        
                        
                        
                    </ul>    
                </div>

            </li>




            <li class="nav-item">


                <a class="nav-link" data-bs-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="false" aria-controls="collapseExample1">
                    <i class="bi bi-people"></i>
                    Job card items
                </a>
                <div class="collapse" id="collapseExample1">

                    <ul  style="list-style-type:none">
                        <li>   
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>jobcards/issue_itemsjobcard.php">
                                <i class="bi bi-person-workspace"></i>
                                Issue items
                            </a>
                        </li>

                       
                    </ul>
                </div>

            </li>
            

            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH; ?>suppliers/supplier.php">
                    <i class="bi bi-person-plus"></i>
                    Suppliers
                </a>
            </li>

            
            




        </ul>
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
            <span>Saved reports</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
                <span data-feather="plus-circle" class="align-text-bottom"></span>
            </a>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH ?>reports/itemavailablereport.php">
                     <i class="bi bi-credit-card"></i>
                   Stock Report
                </a>
            </li>
           
        </ul>
    </div>
</nav>  
