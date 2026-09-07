        </div> <!-- end container-fluid -->
    </div> <!-- end page-content-wrapper -->
</div> <!-- end wrapper -->
<!-- Bootstrap JS for dismissible alerts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery for global fade out and DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        // Find any alert on the page, wait 10 seconds, then fade it out slowly
        $('.alert').delay(10000).fadeOut('slow');

        // Initialize DataTable if #staffTable exists
        if ($('#staffTable').length) {
            $('#staffTable').DataTable({
                "pageLength": 10,
                "language": {
                    "search": "",
                    "searchPlaceholder": "Search employees...",
                    "lengthMenu": "Show _MENU_ entries"
                },
                "order": [[ 0, "asc" ]] // Order by the numbering column
            });
            // Style the search box to look more modern
            $('.dataTables_filter input').addClass('form-control form-control-sm').css({'border-radius':'20px', 'padding':'5px 15px'});
        }
    });
</script>
</body>
</html>
