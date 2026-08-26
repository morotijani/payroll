        </div> <!-- end container-fluid -->
    </div> <!-- end page-content-wrapper -->
</div> <!-- end wrapper -->
<!-- Bootstrap JS for dismissible alerts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery for global fade out -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        // Find any alert on the page, wait 10 seconds, then fade it out slowly
        $('.alert').delay(10000).fadeOut('slow');
    });
</script>
</body>
</html>
