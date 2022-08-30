</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

<script type="text/javascript" src="<?php echo base_url().'assets/vendor/izitoast/js/iziToast.min.js'?>"></script>
<script type="text/javascript">
    function populateSuccess(message) {
        iziToast.success({
            title: 'Sukses!',
            message: message,
            position: 'topCenter', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
        });
    }

    function populateError(message) {
        iziToast.error({
            title: 'Gagal!',
            message: message,
            position: 'topCenter', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
        });
    }

    function populateInfo(message) {
        iziToast.error({
            title: 'Info!',
            message: message,
            position: 'topCenter', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
        });
    }
</script>
</body>
</html>