<video id="scan_job" height="200" width="285"></video>

<button type="button" onclick="scanjob()">Scan</button>
<button type="button" onclick="stopscan()">Stop</button>

<script src="assets/qr_scanner/instascan.min.js"></script>

<script>

    function scanjob() {
        let scanner = new Instascan.Scanner({video: document.getElementById('scan_job')});
        scanner.addListener('scan', function (content) {
            findCustomer(content);
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





    function stopscan() {
        const video = document.querySelector('video');
        const mediaStream = video.srcObject;
        const tracks = mediaStream.getTracks();
        tracks[0].stop();
        tracks.forEach(track => track.stop())
        }


function findCustomer(custid){
    
    
    
    window.location.href ="http://localhost:8080/tmsc/system/findcustomer.php?customerid="+custid
}




</script>

