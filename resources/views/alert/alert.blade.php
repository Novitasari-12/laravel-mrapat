@if (session('danger'))
    <div id="alert" class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {!! session('danger') !!}
    </div>
@endif

@if (session('msg_error'))
    <div id="alertNoTime" class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {!! session('msg_error') !!}
    </div>
@endif

@if (session('info'))
    <div id="alert" class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {!! session('info') !!}
    </div>
@endif

@if (session('warning'))
    <div id="alert" class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {!! session('warning') !!}
    </div>
@endif

@if (session('success'))
    <div id="alert" class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {!! session('success') !!}
    </div>
@endif



<script type="text/javascript">
    setTimeout("alertDismiss()", 10000);

    function alertDismiss() {
        let alert = document.getElementById('alert')
        try {
            if (alert) {
                alert?.fadeIn(1000)
                alert?.style.display = "none"
            }
        } catch (error) {
            console.warn(error)
        }
    }
</script>
