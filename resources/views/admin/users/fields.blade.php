<div class="form-group col-sm-6">
  {!! Form::label('name', 'Name:') !!}
  {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
{!! Form::label('role', 'Role:') !!}
    {!! Form::select('role_id', $roles, null, ['class' => 'form-control']) !!}

</div>


<div class="form-group col-sm-6">
  {!! Form::label('email', 'Email:') !!}
  {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>

<div class="col-md-6">
    <label for="first_name">Class:</label><span
                class="text-danger">*</span>
    <select class="custom-select" id="inputGroupSelect01" name="class">
        <option selected>Choose class</option>
        <option value="1" @if($code == "edit") @if($user->class == 1) selected @endif @endif>MI PSDKU PAMEKASAN</option>
        <option value="2" @if($code == "edit") @if($user->class == 2) selected @endif @endif>SIB POLINEMA PUSAT</option>
    </select>
</div>

<div class="form-group col-sm-6">
  {!! Form::label('password', 'Password:') !!}
  {!! Form::text('password', null, ['class' => 'form-control', "type"=> "password"]) !!}
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
  {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
  <a href="{{ route('admin.users.index') }}" class="btn btn-light">Cancel</a>
</div>
