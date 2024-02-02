<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $user->id }}</p>
</div>

<!-- Role Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $user->name }}</p>
</div>

<!-- Class Field -->
<div class="form-group">
    {!! Form::label('class', 'Class:') !!}
    @if($user->class == 1)
        <p>MI PSDKU PAMEKASAN</p>
    @elseif($user->class == 2)
        <p>SIB POLINEMA PUSAT</p>
    @endif
</div>
<!-- Created At Field -->
