<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">

        <img class="rounded-circle w-100 h-25" src="<?= SYSTEM_PATH ?>employees/images/<?= !empty($_SESSION['image']) ? $_SESSION['image'] : 'noimage.jpeg' ?>">

        <span class="mx-3"><?php echo $_SESSION['firstname'] . "-" . ucwords($_SESSION['userrole']) ?></span>
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
                    Services
                </a>
                <div class="collapse" id="collapseExample">

                    <ul  style="list-style-type:none">



                        <li>   
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>services/service.php">
                                <i class="bi bi-car-front-fill"></i>
                                Services types
                            </a>

                        </li>

                        <li>
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>services/subservice.php">
                                <i class="bi bi-car-front-fill"></i>
                                Sub Services types
                            </a>
                        </li>    
                    </ul>    
                </div>

            </li>




            <li class="nav-item">


                <a class="nav-link" data-bs-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="false" aria-controls="collapseExample1">
                    <i class="bi bi-people"></i>
                    Employees
                </a>
                <div class="collapse" id="collapseExample1">

                    <ul  style="list-style-type:none">
                        <li>   
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>useraccounts/user.php">
                                <i class="bi bi-person-workspace"></i>
                                Create user account
                            </a>
                        </li>

                        <li>
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>employees/employee.php">
                                <span data-feather="users" class="align-text-bottom"></span>
                                Employee Registration
                            </a>
                        </li>
                    </ul>
                </div>

            </li>

            <li class="nav-item">


                <a class="nav-link" data-bs-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample2">
                    <i class="bi bi-truck-front-fill"></i>
                    Vehicles
                </a>
                <div class="collapse" id="collapseExample2">

                    <ul  style="list-style-type:none">
                        <li>   
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>vehicles/vehiclebrandcards.php">
                                <i class="bi bi-car-front-fill"></i>
                                Vehicles
                            </a>

                        </li>




                        <li>   
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>vehicles/brand.php">
                                <i class="bi bi-truck-front"></i>
                                Brands
                            </a>
                        </li>

                        <li>
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>vehicles/model.php">
                                <i class="bi bi-truck-front"></i>
                                Models
                            </a>
                        </li>
                    </ul>
                </div>

            </li>





            <li class="nav-item">


                <a class="nav-link" data-bs-toggle="collapse" href="#collapseExample6" role="button" aria-expanded="false" aria-controls="collapseExample6">
                    <i class="bi bi-box-seam"></i>
                   Items
                </a>
                <div class="collapse" id="collapseExample6">

                    <ul  style="list-style-type:none">
                        <li>   

                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>inventory/add_itemcategory.php">
                                <i class="bi bi-journal-richtext"></i>
                                Item Category
                            </a>

                        </li>

                        <li>   
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>inventory/itemcategoriescards.php">
                                <i class="bi bi-journal-richtext"></i>
                                Item catalog
                            </a>
                        </li>

                       
                    </ul>
                </div>

            </li>


            <li class="nav-item">


                <a class="nav-link" data-bs-toggle="collapse" href="#collapseExample4" role="button" aria-expanded="false" aria-controls="collapseExample4">
                    <i class="bi bi-journal-richtext"></i>
                    Purchasing order
                </a>
                <div class="collapse" id="collapseExample4">

                    <ul  style="list-style-type:none">

                        <li>   
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>inventory/viewreorderitems.php">
                                <i class="bi bi-journal-richtext"></i>
                                Reorder items
                            </a>

                        </li>

                        <li>
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>inventory/itemcategoriescards.php">
                                <i class="bi bi-journal-richtext"></i>
                                All items
                            </a>
                        </li>


                        <li>
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>inventory/purchaseorders.php">
                                <i class="bi bi-journal-richtext"></i>
                                View purchased orders
                            </a>
                        </li>
                        
                         <li>
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>reports/itemavailablereport.php">
                                <i class="bi bi-journal-richtext"></i>
                                Stock report
                            </a>
                        </li>




                    </ul>    
                </div>

            </li>



            <li class="nav-item">


                <a class="nav-link" data-bs-toggle="collapse" href="#collapseExample5" role="button" aria-expanded="false" aria-controls="collapseExample5">
                    <i class="bi bi-person-plus"></i>
                    Supplier
                </a>
                <div class="collapse" id="collapseExample5">

                    <ul  style="list-style-type:none">

                        <li>   
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>suppliers/supplier.php">
                                <i class="bi bi-person-plus"></i>
                                Suppliers
                            </a>

                        </li>

                        <li>
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>suppliers/supplierpayments.php">
                                <i class="bi bi-journal-richtext"></i>
                                Supplier payments
                            </a>
                        </li>
                        
                        <li>
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>reports/supplierpaymentreport.php">
                                <i class="bi bi-journal-richtext"></i>
                                Supplier payments Reports
                            </a>
                        </li>
                        

 

                    </ul>    
                </div>

            </li>



            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH; ?>attendance/technicianattendance.php">
                    <span data-feather="users" class="align-text-bottom"></span>
                    Technician Attendance
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH; ?>vehicles/allvehicles.php">
                    <i class="bi bi-car-front-fill"></i>
                    vehicles history
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH; ?>voucher/monthvoucher.php">
                    <i class="bi bi-journal-richtext"></i>
                    Honda vouchers
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH; ?>holidays/addholiday.php">
                    <i class="bi bi-journal-richtext"></i>
                    Holidays
                </a>
            </li>



            <li class="nav-item">


                <a class="nav-link" data-bs-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample3">
                    <i class="bi bi-pc-display"></i>
                    Display
                </a>
                <div class="collapse" id="collapseExample3">

                    <ul  style="list-style-type:none">

                        <li>   
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>services/display_services.php">
                                <i class="bi bi-pc-display"></i>
                                Display main services
                            </a>

                        </li>

                        <li>
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>services/viewcarousels.php">
                                <i class="bi bi-pc-display"></i>
                                Display carousel banners
                            </a>
                        </li>    
                        
                         <li>
                            <a class="nav-link" href="<?= SYSTEM_PATH; ?>feedbacks/viewfeedbacks.php">
                                <i class="bi bi-pc-display"></i>
                                Feed backs
                            </a>
                        </li>    
                      
                    </ul>    
                </div>

            </li>
             <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH; ?>vehicles/viewalladdedvehicles.php">
                   <i class="bi bi-car-front-fill"></i>
                    All vehicles
                </a>
            </li>






































        </ul>
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
            <span>Reports</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
                <span data-feather="plus-circle" class="align-text-bottom"></span>
            </a>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH; ?>voucher/voucherreports.php">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Pending Voucher Report
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH; ?>voucher/releasevoucherreports.php">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Released Voucher Report
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH; ?>reports/reservationsreport.php">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Reservation Report
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH; ?>reports/serviceincomereport.php">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                   Service Income Report
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH; ?>reports/vehiclesallexpendituresreport.php">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Vehicle expenditures report
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH; ?>reports/customerallexpendituresreport.php">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Customer expenditures report
                </a>
            </li>
            
             <li class="nav-item">
                <a class="nav-link" href="<?= SYSTEM_PATH; ?>reports/technicianjobcardcount.php">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Technician job cards
                </a>
            </li>
            
            
            
            
            
            
            
            
        </ul>
    </div>
</nav>  