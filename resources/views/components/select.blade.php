<div class="form-group {{$errors->has($name) ? 'has-error has-feedback' : '' }}">
  <label for="{{$name}}" class="placeholder"><b>{{$label}}</b></label>

  <select name="{{$name}}" id="{{isset($id) ? $id : $name}}" wire:model="{{$name}}" class="form-control"
    {{isset($multiple) ? 'multiple' : ''}}
    wire:change={{isset($handleChange) ? $handleChange.'($event.target.value)' : ''}}>
    {{$slot}}
  </select>
  <small id="helpId" class="text-danger">{{ $errors->has($name) ? $errors->first($name) : '' }}</small>
</div>