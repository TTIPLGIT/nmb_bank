<div>
    <form id="cronjob" action="{{route('cronjob')}}" method="POST">
        @csrf
    </form>
</div>
<script>
    $(document).ready(function{
        document.querySelector('#cronjob').submit();
    })
</script>