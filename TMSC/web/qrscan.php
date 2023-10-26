<?php include 'header.php'; ?>
<?php include 'menu.php'; ?>



<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h6 class="">Scan job card QR</h6>
        <div class="btn-toolbar mb-2 mb-md-0">
            
            
        </div>
    </div>







<div class="card card-box px-5 bg-black" style="width: 40rem;">

    <div class="text-center card-header my-card-heading mb-3 px-1">
        <p class="display-6">Scan your Job card QR.</p>
    </div>



    <div class="card-body">

        <!--manage device video camera-->
        <video id="scanjob" height="200" width="285"></video>

        <button class='btn btn-primary' type="button" onclick="scanjobcard()">Scan</button>
        <button class='btn btn-danger' type="button" onclick="stopscanjobcard()">Stop</button>


    </div>
</div>
    
   



</main>
<?php include 'footer.php'; ?>


    

<script src="assets/qr_scanner/instascan.min.js"></script>


<script>

            function scanjobcard() {

                let scanner = new Instascan.Scanner({video: document.getElementById('scanjob')});

                scanner.addListener('scan', function (jobcardid) {
                    searchjobcard(jobcardid);
                        });

                Instascan.Camera.getCameras().then(function (cameras) {
                    if (cameras.length > 0) {
                        scanner.start(cameras[0]);
                    } else {
                        console.error('No cameras found.');
                    }
                }).catch(function (e) {
                    console.error(e);
                        });

            }


            function stopscanjobcard() {

                const video = document.querySelector('video');
                const mediaStream = video.srcObject;
                const tracks = mediaStream.getTracks();
                tracks[0].stop();
                tracks.forEach(track => track.stop())

            }
            
            
            function searchjobcard(jobcardid){
                window.location.href="http://localhost:8080/tmsc/web/jobcarddetails.php?jobcardid="+jobcardid;
                
                
            }



</script>