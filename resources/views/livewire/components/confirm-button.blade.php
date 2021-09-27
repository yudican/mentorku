<div>
  @if (Auth::user()->role->role_type == 'member')
  @if (in_array($status,[0,3]))
  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" wire:click="getId('{{ $id }}')"
    id="btn-upload-{{ $id }}"><i class="fas fa-upload"></i></button>
  @else
  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" id="btn-upload-{{ $id }}" disabled><i
      class="fas fa-upload"></i></button>
  @endif
  @else
  @if ($status == 1)
  <button type="button" class="btn btn-info btn-sm" data-toggle="modal" wire:click="getId('{{ $id }}')"
    id="btn-info-{{ $id }}"><i class="fas fa-eye"></i></button>
  @else
  <button type="button" class="btn btn-info btn-sm" data-toggle="modal" id="btn-info-{{ $id }}" disabled><i
      class="fas fa-eye"></i></button>
  @endif
  @endif

</div>