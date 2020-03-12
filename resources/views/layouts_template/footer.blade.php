<footer class="main-footer">
    <div class="footer-left">
        Copyright &copy; 2020 <div class="bullet">
            </div> Laravel Restfull API
    </div>
    <div class="footer-right">

    </div>
</footer>
</div>
</div>

<!-- General JS Scripts -->
<script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
<script src="{{ asset('assets/modules/popper.js') }}"></script>
<script src="{{ asset('assets/modules/tooltip.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('assets/modules/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/stisla.js') }}"></script>

<!-- JS Libraies -->

<!-- Page Specific JS File -->
<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var name   = button.data('name');
        var email  = button.data('email');
        var id     = button.data('id');
        var modal  = $(this);

        modal.find('.modal-body #name').val(name);
        modal.find('.modal-body #email').val(email);
        modal.find('.modal-body #id').val(id);
    });

    $('#showModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var name   = button.data('name');
        var email  = button.data('email');
        var id     = button.data('id');
        var modal  = $(this);

        modal.find('.modal-body #name').val(name);
        modal.find('.modal-body #email').val(email);
        modal.find('.modal-body #id').val(id);
    });
</script>

<!-- Template JS File -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
</body>

</html>
