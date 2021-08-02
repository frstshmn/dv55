<div class="container mt-5">
    @php echo($material->code) @endphp
</div>
<div class="container p-5 d-flex justify-content-center">
    @if(!empty($next_material))
        <button class="button px-5 next-material" data-next="{{$next_material->id}}" data-current="{{$material->id}}" data-user="{{Auth::user()->id}}">Proceed to next chapter: <em>{{$next_material->title}}</em><span class="m-0 h4 iconify" data-icon="ic:round-navigate-next" data-inline="false"></span></button>
    @else
        <p class="font-italic">This was the last chapter of material, now you are ready to pass the test!</p>
    @endif
</div>
