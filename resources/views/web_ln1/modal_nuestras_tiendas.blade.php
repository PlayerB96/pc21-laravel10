<div class="modal-body">
    <div class="col-lg-12 row" style="margin-left:0px">  
        <img style="max-width:100%;cursor:pointer;border-radius:40px" src="{{ asset($img) }}">
    </div>
    
    <div class="col-lg-12 row">          
        <div class="form-group col-lg-12 text-center">
            <img  src="{{ asset('web_ln1/img/mapa.png') }}"><b>{{ $ubicacion }}</b><br>
            {{ $tienda }}<br>
            {{--<b>Horario:</b>{{ $horario }}<br>
            <b>E-mail:</b>{{ $email }}<br>--}}
            <b><a target="_blank" href="{{ $como_llegar }}">Como llegar</a> </b>
        </div>
    </div>
</div>