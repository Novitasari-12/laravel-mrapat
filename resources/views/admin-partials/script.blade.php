<!-- jQuery -->
<script src="{{asset('assets/admin-lte')}}/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI -->
<script src="{{asset('assets/admin-lte')}}/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('assets/admin-lte')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="{{asset('assets/admin-lte')}}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('assets/admin-lte')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{asset('assets/admin-lte')}}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{asset('assets/admin-lte')}}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{asset('assets/admin-lte')}}/plugins/select2/js/select2.full.min.js"></script>
<!-- Select2 -->
<script src="{{asset('assets/admin-lte')}}/plugins/select2/js/select2.full.min.js"></script>
<!-- fullCalendar 2.2.5 -->
{{-- <script src="{{asset('assets/admin-lte')}}/plugins/moment/moment.min.js"></script>
<script src="{{asset('assets/admin-lte')}}/plugins/fullcalendar/main.min.js"></script>
<script src="{{asset('assets/admin-lte')}}/plugins/fullcalendar-daygrid/main.min.js"></script>
<script src="{{asset('assets/admin-lte')}}/plugins/fullcalendar-timegrid/main.min.js"></script>
<script src="{{asset('assets/admin-lte')}}/plugins/fullcalendar-interaction/main.min.js"></script>
<script src="{{asset('assets/admin-lte')}}/plugins/fullcalendar-bootstrap/main.min.js"></script> --}}
{{-- <script src="{{asset('assets/fullcalender/main.js')}}"></script> --}}
<!-- QR CODE -->
<script src="{{asset('assets')}}/qrcode/qrcode.min.js"></script>
<!-- CKEDITOR -->
<script src="{{asset('assets')}}/ckeditor/ckeditor.js"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/admin-lte')}}/dist/js/adminlte.min.js"></script>





<script>
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
</script>

<script>
    $("table").DataTable({
      "responsive": true,
      "autoWidth": false,
    });

    $('.select').select2({
      theme: 'bootstrap4'
    })
</script>

@yield('script')