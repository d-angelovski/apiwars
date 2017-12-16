@extends('layouts.app')

@section('content')
    <div class="container">
        <api-fight></api-fight>
    </div>
@endsection

@section('scripts')
    <script type="application/json" name="items">
        {!! json_encode($items) !!}
    </script>
    <script>
        var json = document.getElementsByName("items")[0].innerHTML;
        var items = JSON.parse(json);
    </script>

    <script type="application/javascript">
        const app = new Vue({
            el: '#app'
        });
    </script>
@endsection