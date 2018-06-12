<script src="{{ url('/public/js/base.min.js') }}"></script>
@if(in_array($_route, ['profile','orders','order','cart','discounts','product','balance']))
<script src="{{ url('/public/js/user.min.js') }}"></script>
@endif
@if(in_array($_route, ['order','cart']))
<script type="text/javascript" src="{{ url('/public/js/shim.min.js') }}" /></script>
<script type="text/javascript" src="{{ url('/public/js/xlsx.full.min.js' )}}" /></script>
@endif
@if(in_array($_route, ['orders']))
<script type="text/javascript" src="{{ url('/public/js/socket.io.slim.js') }}" /></script>
@endif
<script src="{{ url('/public/js/jquery.mask.js') }}"></script>
<script src="{{ url('/public/js/modals.js') }}"></script>
<script src="{{ url('/public/js/__.js') }}"></script>