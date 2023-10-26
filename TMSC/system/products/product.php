<?php include '../header.php'; ?>
<?php include '../menu.php'; ?>

                

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Manage Products</h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group me-2">
                                <a href="products/add.php" type="button" class="btn btn-sm btn-outline-secondary">Add New Product</a>
                                <button type="button" class="btn btn-sm btn-outline-secondary">Search</button>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                                <span data-feather="calendar" class="align-text-bottom"></span>
                                Update Product
                            </button>
                        </div>
                    </div>

                   

                    <h2>Product list</h2>
                    <div class="table-responsive">
                    <?php 
                       
                    
                    
                        
                        
                        
                        
                    ?>    
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Product name</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price(Rs.)</th>
                                    <th scope="col">Amount(Rs.)</th>
                                    <th></th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                 <?php
                                    
                                        
                                    
                                    
                                    ?>
                                <tr>
                                   
                                    
                                    <td>1</td>
                                    <td>BodyCover</td>
                                    <td>10</td>
                                    <td>Rs.1000</td>
                                    <td>3000</td>
                                    <td>5000</td>
                                </tr>
                                
                                <?php
                                    
                                    
                                ?>
                               
                            </tbody>
                        </table>
                    </div>
                </main>
<?php include '../footer.php'; ?>

